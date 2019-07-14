<?php

namespace AClear;

    use pocketmine\event\Listener;
    use pocketmine\plugin\PluginBase;
    use pocketmine\scheduler\Task;
    use pocketmine\entity\Human;
    use pocketmine\entity\Entity;
    use pocketmine\entity\Creature;

class Main extends PluginBase implements Listener {
	protected $entities = [];

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getScheduler()->scheduleRepeatingTask(new AutoClear($this), 20 * 300);
	}
}
	
class AutoClear extends Task {
    public $clear;
    public function __construct(Main $main) {
    	$this->clear = $main;
    }
    
    public function onRun(int $currentTick){
    	$count = array(0, 0);
    foreach($this->clear->getServer()->getLevels() as $level){
    	foreach($level->getEntities() as $entity){
    	if(!isset($this->entities[$entity->getID()]) && !($entity instanceof Creature)){
    	$entity->close();
    $count[0]++;
    }
    if(!isset($this->entities[$entity->getID()]) && $entity instanceof Creature && !($entity instanceof Human)){
    	$entity->close();
    $count[1]++;
				}
			}
		}
		$this->clear->getServer()->broadcastPopup("§7[§f*§7] §aCleaning §7> §b{$count[0]} §ftrash removed from earth");
	}
}