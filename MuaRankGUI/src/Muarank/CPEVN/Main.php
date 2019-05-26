<?php

namespace Muarank\CPEVN;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\{Player, Server};
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\item\Item;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as CP;
use pocketmine\math\Vector3;
use jojoe7777\FormAPI;

class Main extends PluginBase implements Listener{
	public $tag = "§6[§aMuaRank§cUI§6]";
	
	public function onEnable(){
		$this->getLogger()->info(CP::GREEN . "Enable Plugin by §cZero§bSky");
		$this->point = $this->getServer()->getPluginManager()->getPlugin("PointAPI");
	}
	
	public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool{
		switch(strtolower($cmd->getName())){
			case "muarank":
			if(!($sender instanceof Player)){
				$this->getLogger()->info(CP::RED . "Please Dont Use that command in here.");
				return true;
			}
			$tien = $this->point->myMoney($sender);
			$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
			$form = $api->createSimpleForm(Function (Player $sender, $data){
				
				$result = $data;
				if ($result == null) {
				}
				switch ($result) {
					case 0:
					$sender->sendMessage("§c");
					break;
					case 1:
					$this->rank1($sender);
					break;
					case 2:
					$this->rank2($sender);
					break;
					case 3:
					$this->rank3($sender);
					break;
					case 4:
					$this->rank4($sender);
					break;
					case 5:
					$this->rank5($sender);
					break;
				}
			});
			
			$form->setTitle("§b-=-=-=-=| ".$this->tag."§b |=-=-=-=-");
			$form->setContent("§l§bSử Dụng Point Để mua! - Your Point:§e ". $tien);
			$form->addButton("§cEXITS", 0);
			$form->addButton("§c❤️ §aVip§e-§bI§c ❤️", 1);
			$form->addButton("§c❤️ §aVip§e-§bII§c ❤️", 2);
			$form->addButton("§c❤️ §aVip§e-§bIII§c ❤️", 3);
			$form->addButton("§c❤️ §aVip§e-§bIV§c ❤️", 4);
			$form->addButton("§c❤️ §aVip§e-§bV§c ❤️", 5);
			$form->sendToPlayer($sender);
		}
		return true;
	}
	
	public function rank1(Player $sender){
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createModalForm(Function (Player $sender, $data){
			
			$result = $data;
			if ($result == null) {
			}
			switch ($result) {
				case 1:
				$point = $this->point->myMoney($sender);
				$cost = 50;
				if($point >= $cost){
					$this->point->reduceMoney($sender, $cost);
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "setvip ".strtolower($sender->getName()). " vip1 7");
					$sender->sendMessage($this->tag . "§l§aPurchased Completed!.");
				}else{
					$sender->sendPopup($this->tag . "§l§c Không Đủ Point....");
					return true;
				}
				break;
				case 2:
				$sender->sendMessage($this->tag . "§l§c Bạn Đã Huỷ Mua Rank!");
				break;
			}
		});
		
		$form->setTitle("§b-=-=-=-=| ".$this->tag." §b|=-=-=-=-");
		$form->setContent("§eMua §aVIP§e-§cI §evới giá 50 Zcoin,bạn có muốn mua không?Các quyền lợi của §aVIP§e-§cII §eáp dụng từ ngày 2/4\n §c►§a/tp");
		$form->setButton1("§aMUA", 1);
		$form->setButton2("§cCancel", 2);
		$form->sendToPlayer($sender);
	}
	
	public function translateMessage($scut, $message){
		$message = str_replace($scut."{name}", $sender->getName(), $message);
		return $message;
	}
	
	public function getItem($sender){
		$item = Item::get(276,0,1);
		$item->setCustomName("§b-=-= §aThanh Long Bảo Kiếm §b=-=-");
		$item->setLore(array("§l§b Thanh Long Bảo Kiếm Là 1 Thanh Kiếm Thất Truyền Từ Đời Nhà Thanh.\n §c•§a Rồng Trời Giáng Trần §c•\n §c•§a Kháng Long Hữu Hối §c•\n§b Đây Là Bảo Vật Chỉ Nhận khi Mua Play3 và Event Drop!"));
        $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(9), 200));
		$item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(10), 50));
		$sender->getInventory()->addItem($item);
		return true;
	}
	
	public function onDeath(PlayerDeathEvent $ev){
		$player = $ev->getPlayer();
		$pp = $this->getServer()->getPluginManager()->getPlugin("PurePerms");
		$rank = $this->pp->getUserDataMgr()->getGroup($player);
		if($rank == "vip1" || $rank == "vip2" || $rank == "vip3" || $rank == "vip4" || $rank == "vip5"){
			$player->sendMessage("§c>>•§a SPN§eVN§c •<<§a Bạn Là §6[§c".$rank."§6]§a Nên Sẽ Không bị phạt xu khi chết!");
			return true;
		}
	}
	
	public function rank2(Player $sender){
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createModalForm(Function (Player $sender, $data){
			
			$result = $data;
			if ($result == null) {
			}
			switch ($result) {
				case 1:
				$point = $this->point->myMoney($sender);
				$cost = 100;
				if($point >= $cost){
					$this->point->reduceMoney($sender, $cost);
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "setvip ". strtolower($sender->getName()). " vip2 14");
					$sender->sendMessage($this->tag . "§l§aPurchased Completed!");
				}else{
					$sender->sendPopup($this->tag . "§l§c Không Đủ ZCoin....");
					return true;
				}
				break;
				case 2:
				$sender->sendMessage($this->tag . "§l§c Bạn Đã Huỷ Mua Rank!");
				break;
			}
		});
		
		$form->setTitle("§b-=-=-=-=| ".$this->tag." §b|=-=-=-=-");
		$form->setContent("§emua §aVIP§e-§cII §evới giá 100 Zcoin,bạn có muốn mua không?Các quyền lợi của §aVIP§e-§cII §eáp dụng từ ngày 2/4\n §c►§a/tp\n §c►§a/fly");
		$form->setButton1("§aMUA", 1);
		$form->setButton2("§cCancel", 2);
		$form->sendToPlayer($sender);
	}
	
	public function rank3(Player $sender){
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createModalForm(Function (Player $sender, $data){
			
			$result = $data;
			if ($result == null) {
			}
			switch ($result) {
				case 1:
				$point = $this->point->myMoney($sender);
				$cost = 300;
				if($point >= $cost){
					$this->point->reduceMoney($sender, $cost);
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "setvip ". strtolower($sender->getName()). " vip3 30");
					$sender->sendMessage($this->tag . "§l§aPurchased Completed!.");
					$this->getItem($sender);
				}else{
					$sender->sendPopup($this->tag . "§l§c Không Đủ ZCoin....");
					return true;
				}
				break;
				case 2:
				$sender->sendMessage($this->tag . "§l§c Bạn Đã Huỷ Mua Rank!");
				break;
			}
		});
		
		$form->setTitle("§b-=-=-=-=| ".$this->tag." §b|=-=-=-=-");
		$form->setContent("§emua §aVIP§e-§cIII §evới giá 300 Zcoin,bạn có muốn mua không?Các quyền lợi của §aVIP§e-§cIII §eáp dụng từ ngày 2/4\n §c►§a/tp\n §c►§a/fly\n §c►§a/size");
		$form->setButton1("§aMUA", 1);
		$form->setButton2("§cCancel", 2);
		$form->sendToPlayer($sender);
	}
	
	public function rank4($sender){
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createModalForm(Function (Player $sender, $data){
			
			$result = $data;
			if ($result == null) {
			}
			switch ($result) {
				case 1:
				$point = $this->point->myMoney($sender);
				$cost = 500;
				if($point >= $cost){
					$this->point->reduceMoney($sender, $cost);
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "setvip ". strtolower($sender->getName()). " vip4 60");
					$sender->sendMessage($this->tag . "§l§aPurchased Completed!.");
				}else{
					$sender->sendPopup($this->tag . "§l§c Không Đủ ZCoin....");
					return true;
				}
				break;
				case 2:
				$sender->sendMessage($this->tag . "§l§c Bạn Đã Huỷ Mua Rank!");
				break;
			}
		});
		
		$form->setTitle("§b-=-=-=-=| ".$this->tag." §b|=-=-=-=-");
		$form->setContent("§emua §aVIP§e-§cIV §evới giá 500 Zcoin,bạn có muốn mua không?Các quyền lợi của §aVIP§e-§cIV §eáp dụng từ ngày 2/4\n §c►§a/tp\n §c►§a/fly\n §c►§a/size\n §c►§a/god(god là bất tử)");
		$form->setButton1("§aMUA", 1);
		$form->setButton2("§cCancel", 2);
		$form->sendToPlayer($sender);
	}
	
	public function rank5($sender){
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createModalForm(Function (Player $sender, $data){
			
			$result = $data;
			if ($result == null) {
			}
			switch ($result) {
				case 1:
				$point = $this->point->myMoney($sender);
				$cost = 1000;
				if($point >= $cost){
					$this->point->reduceMoney($sender, $cost);
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "setvip ". strtolower($sender->getName()). " vip5 120");
					$sender->sendMessage($this->tag . "§l§aPurchased Completed!");
				}else{
					$sender->sendPopup($this->tag . "§l§c Không Đủ ZCoin....");
					return true;
				}
				break;
				case 2:
				$sender->sendMessage($this->tag . "§l§c Bạn Đã Huỷ Mua Rank!");
				break;
			}
		});
		
		$form->setTitle("§b-=-=-=-=| ".$this->tag." §b|=-=-=-=-");
		$form->setContent("§emua §aVIP§e-§cII §evới giá 1000 Zcoin,bạn có muốn mua không?Các quyền lợi của §aVIP§e-§cII §eáp dụng từ ngày 2/4\n §c►§a/tp\n §c►§a/fly\n §c►§a/size\n §c►§a/god(god là bất tử)\n §c►§a/vanish(vanish là tàng hình)");
		$form->setButton1("§aMUA", 1);
		$form->setButton2("§cCancel", 2);
		$form->sendToPlayer($sender);
	}
	
	public function processor(Player $player, string $string): string{
		$string = str_replace("{name}", $player->getName(), $string);
		return $string;
	}
}