<?php

namespace Thaili;

use pocketmine\world\sound\BlazeShootSound;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat as CL;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener{
  
  public function onEnable() : void {
 
      $this->getServer()->getPluginManager()->registerEvents($this, $this);
  }
    
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        switch ($command->getName()) {
            case "rankitem":
                if (!$sender instanceof Player) {
                    return false;
                }
                if (!$sender->hasPermission("rank.item.give")) {
                    return false;
                }
                $rank1 = ItemFactory::getInstance()->get(ItemIds::NETHER_STAR, 0);
                $rank1->setCustomName(CL::AQUA."§lRank §6King §b7d");
                $rank1->setLore([
                    " ",
                    "§7dsc.gg/example",
                    "§7you can get it at" . " " . "§7Crates"
                ]);
                $rank1->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(0), 1, ));
             
                
                $sender->getInventory()->addItem($rank1);
                $sender->sendMessage("§l§b You Received The Item!");
                }
        return true;
    }
    
    public function rankClick(PlayerItemUseEvent $event) {
    $item = $event->getItem();
    $player = $event->getPlayer();
    $world = $player->getWorld();
      switch ($item->getCustomName()) {
          case CL::AQUA."§lRank §6King §b7d":
              $rank1 = ItemFactory::getInstance()->get(ItemIds::NETHER_STAR, 0);
               $world->addSound($player->getPosition(), new BlazeShootSound(), [$player]);
              //player

              $player->getInventory()->removeItem($rank1);
              Server::getInstance()->dispatchCommand($player, 'ranks setrank ' . $player->getName() . ' King 7d');
              $player->sendMessage(CL::GREEN."Now you have rank ". CL::RED . "King" . " " . CL::GREEN . "For 7 days");
      }
    }
}