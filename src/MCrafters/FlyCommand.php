<?php

namespace MCrafters;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as MF;
use pocketmine\Player;
use pocketmine\Server;

use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;

class FlyCommand extends PluginBase implements Listener {

    public $flying = [];
    
    public function onEnable(){
      $this->getLogger()->info(MF::DARK_GREEN."Let the players fly in survival!");
      $this->getLogger()->info(MF::AQUA."FlyCommand ".MF::AQUA."v1.0 ".MF::GREEN."by MCrafters");
    }

    public function onDisable{
      $this->getLogger()->info(MF::DARK_RED."FlyCommand DISABLED!");
    }
    
    public function getPrefix(){
      return (MF::GRAY."[".MF::DARK_GREEN.MF::BOLD."FlyCommand".MF::RESET.MF::GRAY."] ");
    }

    public function onCommand(CommandSender $sd, Command $cmd, $label, array $args){
      if ($cmd->getName() == "fly" or $cmd->getName() == "flycommand"){
        if (isset($args[0]) and !isset($args[1])){
          if ($sd->hasPermission("flycommand.other")){
           $p = $this->getServer()->getPlayerExact($args[0]);
           if ($p instanceof Player){
             if (!isset($this->flying[$p->getName()])){
               $sd->sendMessage($this->getPrefix().MF::GREEN."Successfully enabled flying for player ".$args[0]);
               $p->sendMessage($this->getPrefix().MF::DARK_GREEN."You have now flying enabled!");
               $p->setAllowFlight(true);
               $field = [$p->getName() => $p->getName()];
               $this->flying = \array_merge($field,$this->flying);
               return true;
             }
             else {
                $sd->sendMessage($this->getPrefix().MF::GREEN."Successfully disabled flying for player ".$args[0]);
               $p->sendMessage($this->getPrefix().MF::DARK_GREEN."You have now flying disabled");
               $p->setAllowFlight(false);
               unset($this->flying[$p->getName()]);
               return true;
             }
           }
           else {
             $sd->sendMessage($this->getPrefix().MF::RED."There is no player online with name ".$args[0]."!");
             return true;
           }
           return true;
        }
        elseif(!$sd->hasPermission("fc.command")) {
          $sd->sendMessage($this->getPrefix().MF::RED."You don't have permission for enabling flying for other players");
        }
      }
      elseif (!isset($args[0])){
        if ($sd->hasPermission("flycommand.fly")){
          if ($sd instanceof Player) {
            if (!isset($this->flying[$sd->getName()])){
              $sd->sendMessage($this->getPrefix().MF::GREEN."You have now flying enabled");
              $sd->setAllowFlight(true);
              $field = [$sd->getName() => $sd->getName()];
              $this->flying = \array_merge($field,$this->flying);
              return true;
              }
              else {
                $sd->sendMessage($this->getPrefix().MF::GREEN."You have now flying disabled");
              $sd->setAllowFlight(false);
              unset ($this->flying[$sd->getName()]);
              return true;
              }
            return true;
          }
          elseif(!$sd instanceof Player) {
            $sd->sendMessage($this->getPrefix().MF::RED."Console can't fly!");
            return true;
          }
         return true;
        }
        elseif(!$sd->hasPermission("fc.command")) {
          $sd->sendMessage($this->getPrefix().MF::RED."You don't have permissions for /fly!");
          return false;
        }
       return true;
      }
      else {
        return false;
      }
    }
      return true;
    }

}
