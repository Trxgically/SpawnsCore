<?php

namespace Trxgically\SpawnsCore;

use pocketmine\{Server,Player};
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as TF;
use pocketmine\event\Listener;
use pocketmine\command\{Command,CommandSender,ConsoleCommandSender};
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\math\Vector3;
use pocketmine\level\Level;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener {
    private $config;
    private $playerInteractions = false;
    private $setHub = false;
    private $setSpawn = false;
    private $setLobby = false;
    private $hubSet = false;
    private $spawnSet = false;
    private $lobbySet = false;

    public function onEnable() : void{
        $this->getServer()->getPluginManager()->registerEvents($this,$this);
        $this->getLogger()->info(TF::GREEN . "SpawnsCore enabled!");
        $this->saveDefaultConfig();
        $this->config = new Config($this->getDataFolder()."config.yml", Config::YAML);
        $this->config->getAll();
    }


  public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool {
    if ($command->getName() == "sc")
     {
     if ($sender->hasPermission("sc.cmd"))
      {
      if (count($args) === 0)
       {
       $sender->sendMessage(TF::DARK_RED . TF::BOLD . "SpawnsCore Commands :" . TF::RESET . "\n" . "\n" . TF::RED . "/sc sethub" . TF::GRAY . " - Set the player spawnpoint of /hub" . "\n" . TF::RED . "/sc setspawn" . TF::GRAY . " - Set the player spawnpoint of /spawn" . "\n" . TF::RED . "/sc setlobby" . TF::GRAY . " - Set the player spawnpoint of /lobby" . "\n" . "\n" . TF::RED . "/sc resethub" . TF::GRAY . " - Reset the player spawnpoint of /hub" . "\n" . TF::RED . "/sc resetspawn" . TF::GRAY . " - Reset the player spawnpoint of /spawn" . "\n" . TF::RED . "/sc resetlobby" . TF::GRAY . " - Reset the player spawnpoint of /lobby");
       }
        else
       {
       switch ($args[0])
        {
       case "sethub":
        $this->setHub = true;
        $sender->sendMessage(TF::BLACK . "[" . TF::RED . "SC" . TF::BLACK . "]" . TF::RESET . " Please click or tap where you would like to set the spawnpoint");
        break;

       case "setspawn":
        $this->setSpawn = true;
        $sender->sendMessage(TF::BLACK . "[" . TF::RED . "SC" . TF::BLACK . "]" . TF::RESET . " Please click or tap where you would like to set the spawnpoint");
        break;

       case "setlobby":
        $this->setLobby = true;
        $sender->sendMessage(TF::BLACK . "[" . TF::RED . "SC" . TF::BLACK . "]" . TF::RESET . " Please click or tap where you would like to set the spawnpoint");
        break;

       case "hub":
        if ($this->hubSet === false)
         {
         $sender->sendMessage(TF::BLACK . "[" . TF::RED . "SC" . TF::BLACK . "]" . TF::RESET . " There is no current hub set!");
         }
        elseif ($this->hubSet === true)
         {
         $sender->sendMessage(TF::BLACK . "[" . TF::RED . "SC" . TF::BLACK . "]" . TF::RESET . " Teleporting to hub...");
         }

        break;

       case "spawn":
        if ($this->spawnSet === false)
         {
         $sender->sendMessage(TF::BLACK . "[" . TF::RED . "SC" . TF::BLACK . "]" . TF::RESET . " There is no current spawn set!");
         }
        elseif ($this->spawnSet === true)
         {
         $sender->sendMessage(TF::BLACK . "[" . TF::RED . "SC" . TF::BLACK . "]" . TF::RESET . " Teleporting to spawn...");
         }

        break;

       case "lobby":
        if ($this->lobbySet === false)
         {
         $sender->sendMessage(TF::BLACK . "[" . TF::RED . "SC" . TF::BLACK . "]" . TF::RESET . " There is no current lobby set!");
         }
        elseif ($this->lobbySet === true)
         {
         $sender->sendMessage(TF::BLACK . "[" . TF::RED . "SC" . TF::BLACK . "]" . TF::RESET . " Teleporting to lobby...");
         }

        break;
        }
       }
      }
       else
      {
      $sender->sendMessage(TF::DARK_RED . TF::BOLD . "Conquest Commands :" . TF::RESET . "\n" . "\n" . TF::RED . "/conquest join" . TF::GRAY . " - Join the current Conquest event");
      }

     return true;
     }
    }

   public

   function onInteract(PlayerInteractEvent $event)
    {
    if ($this->setHub === true)
     {
     $player = $event->getPlayer();
     $block = $event->getBlock();
     $x = $block->getX();
     $y = $block->getY();
     $z = $block->getZ();
     $hubx = $this->config->setNested("hspawn-point.x", $x);
     $huby = $this->config->setNested("hspawn-point.y", $y);
     $hubz = $this->config->setNested("hspawn-point.z", $z);
     $this->config->save();
     $hubxd = $this->config->getNested("hspawn-point.x");
     $hubyd = $this->config->getNested("hspawn-point.y");
     $hubzd = $this->config->getNested("hspawn-point.z");
     $player->sendMessage(TF::BLACK . "[" . TF::RED . "SC" . TF::BLACK . "]" . TF::RESET . " You have successfully set the spawn point at " . TF::RED . TF::BOLD . "\n" . "X: " . $hubxd . TF::RESET . TF::RED . TF::BOLD . "Y :" . $hubyd . TF::RESET . TF::RED . TF::BOLD . "Z: " . $hubzd);
     $this->setHub = false;
     $this->hubSet = true;
     }
    elseif ($this->setSpawn === true)
     {
     $player = $event->getPlayer();
     $block = $event->getBlock();
     $x = $block->getX();
     $y = $block->getY();
     $z = $block->getZ();
     $spawnx = $this->config->setNested("sspawn-point.x", $x);
     $spawny = $this->config->setNested("sspawn-point.y", $y);
     $spawnz = $this->config->setNested("sspawn-point.z", $z);
     $this->config->save();
     $spawnxd = $this->config->getNested("sspawn-point.x");
     $spawnyd = $this->config->getNested("sspawn-point.y");
     $spawnzd = $this->config->getNested("sspawn-point.z");
     $player->sendMessage(TF::BLACK . "[" . TF::RED . "SC" . TF::BLACK . "]" . TF::RESET . " You have successfully set the spawn point at " . TF::RED . TF::BOLD . "\n" . "X: " . $spawnxd . TF::RESET . TF::RED . TF::BOLD . "Y :" . $spawnyd . TF::RESET . TF::RED . TF::BOLD . "Z: " . $spawnzd);
     $this->setSpawn = false;
     $this->spawnSet = true;
     }
    elseif ($this->setLobby === true)
     {
     $player = $event->getPlayer();
     $block = $event->getBlock();
     $x = $block->getX();
     $y = $block->getY();
     $z = $block->getZ();
     $lobbyx = $this->config->setNested("lspawn-point.x", $x);
     $lobbyy = $this->config->setNested("lspawn-point.y", $y);
     $lobbyz = $this->config->setNested("lspawn-point.z", $z);
     $this->config->save();
     $lobbyxd = $this->config->getNested("lspawn-point.x");
     $lobbyyd = $this->config->getNested("lspawn-point.y");
     $lobbyzd = $this->config->getNested("lspawn-point.z");
     $player->sendMessage(TF::BLACK . "[" . TF::RED . "SC" . TF::BLACK . "]" . TF::RESET . " You have successfully set the spawn point at " . TF::RED . TF::BOLD . "\n" . "X: " . $lobbyxd . TF::RESET . TF::RED . TF::BOLD . "Y :" . $lobbyyd . TF::RESET . TF::RED . TF::BOLD . "Z: " . $lobbyzd);
     $this->setLobby = false;
     $this->lobbySet = true;
     }
    }
   }

