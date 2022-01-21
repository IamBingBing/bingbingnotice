<?php
namespace bingbing;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\utils\Config;

class bingbingnotice extends PluginBase implements Listener{ 
    static $instance;
    public $config;
    protected function onEnable():void{
        parent::onEnable();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $config = new Config($this->getDataFolder()."option.yml", Config::YAML ,['frontmessage' => "[ 공지 ] "]);
        $this->config= $config->getAll();
    }
    public function getinstance():bingbingnotice{
        
        return self::$instance;
    }
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args):bool{
        if ($command == "notice" || $command == "공지"){
            foreach($this->getServer()->getWorldManager()->getWorlds() as $world ){
                if ($args[0] == $world->getFolderName() ){ 
                    $this->sendmessage($world->getPlayers(), $this->config['frontmessage'].$this->arraytostring(array_splice($args , 0, 1)));
                    return true;
                }
            }
            $this->sendmessage($this->getServer()->getOnlinePlayers(), $this->config['frontmessage'].$this->arraytostring($args));
            return true;
        }
    }
    
    public function sendmessage(array $players , string $msg){
        /*
         * @param Player $p;
         * */
        foreach ($players as $p){
            $p->sendMessage($msg);
        }
    }
    public function arraytostring(array $args) : string{
        $result= "";
        foreach ($args as $a) {
            $result = $result." ".$a;
        }
        return $result;
    }
}