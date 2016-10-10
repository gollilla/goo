<?php

namespace goo;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\Listener;

class goo extends PluginBase implements Listener{

  public function onEnable(){

        $this->getServer()->getPluginManager()->registerEvents($this,$this);

        if(!file_exists($this->getDataFolder())){
              mkdir($this->getDataFolder(), 0744, true);
        }

        $this->count = new Config($this->getDataFolder() ."count.yml", Config::YAML, array());
        $this->count->save();

        
   }

  public function onJoin(PlayerJoinEvent $ev){

          $name = $ev->getPlayer()->getName();
          

          if($this->count->exists($name)){

            }else{
                $this->count->set($name,"0");
                $this->count->save();
            }
   }


  public function onCommand(CommandSender $sender, Command $cmd, $label, array $args){
         
           $cmdname = $cmd->getName();

           switch($cmdname){

                           case "goo":
                                     if(isset($args[0])){

                                       if($sender->getName() == $args[0]){ $sender->sendMessage("§cInfo§f >§e 自分にグ～はできません");}else{
                                           
                                          if($this->getServer()->getPlayer($args[0]) instanceof Player){
 
                                                     $pname = $this->getServer()->getPlayer($args[0])->getName();
                                            }else{
                                          
                                                     $pname = $args[0];
                                          }
                                           
                                          if($this->count->exists($pname)){
                                                    
                                                    $a = $this->count->get($pname);
                                                    $b = $a + 1;
                                                    $this->count->set($pname,$b);
                                                   
                                                    $this->getServer()->broadcastPopup("§bInfo§f > §6".$sender->getName()." §aさんが§d ".$pname."§a さんを§f グ～ §aしました");
                                          }else{

                                                    $sender->sendMessage("§cInfo§f > §e 存在しないplayerです");
                                          }
                                       }
                                     
                                     }
                                     break;
   

                                case "check":

                                             if(isset($args[0])){
                                                     $name = $args[0];
                                                     if($this->count->exists($name)){
                                                              $date = $this->count->get($name);
                                                              $sender->sendMessage("§bInfo§f > §e".$name."§a さんは合計§6 ".$date." §a回§fグ～§aされています");
                                                      }else{
                                                              $sender->sendMessage("§cInfo §f> §e存在しないplayerです");
                                                      }
                                             }else{

                                                       $sender->sendMessage("§cInfo§f > §e使い方:/check 名前");
                                             }
                                       break;

                               }

           }

 }                                             