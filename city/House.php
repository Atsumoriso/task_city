<?php
namespace city;
class House{
   public $number;
   public $apartments=array();
   public $floorsQty;
   public $porchesQty;
   public $apartmentIn1Floor; // кол-во квартир на 1 этаже
   public $area; //территория 1 подъезда
   const TARIFFELECTRICITYMOP = 5; // МОП - места общего пользования
   const TARIFFTAXLAND = 25; // ставка налога на землю
   
   public $totalHouseHeating=0;
   public $totalHouseElevator=0;
   public $totalHouseGarbage=0;
   public $totalHouseCost=0;
   public $totalHouseTenants=0;
   
  
   public function __construct($number, $floorsQty, $porchesQty,$apartmentIn1Floor,$area){
       $this->number=$number;
       $this->floorsQty=$floorsQty;
       $this->porchesQty=$porchesQty;
       $this->apartmentIn1Floor=$apartmentIn1Floor;
       $this->area=$area;
	   $this->setApartments(); 
   }
   
    // метод вычисления кол-ва квартир в доме
   public function apartmentsInHouse(){ 
       return $this->apartmentIn1Floor*$this->floorsQty*$this->porchesQty;
   }
   
   // метод вычисления площади придомовой терр. для вычисления налога
   public function houseArea(){
       return $this->porchesQty*$this->area;
   }
   
   // метод вычисления налога на землю в зависимости от размера территории, отведенной для дома;
   public function landTax(){
       return self::TARIFFTAXLAND*$this->houseArea();
   }
   
   // метод вычисления затрат на эл-во в МОП (объем потребляемого электричества для освещения подъездов в зависимости от количества подъездов и этажей)
   public function MOP(){
       return self::TARIFFELECTRICITYMOP*$this->floorsQty*$this->porchesQty;
   }
   
   // массив квартир
   public function setApartments(){
       for($i=0;$i<$this->apartmentsInHouse();$i++){
           $this->apartments[$i]=new Apartment(rand(1,10),rand(1,3),rand(50,100),rand(5,10),rand(1,15),rand(1,7));
       }
   }
   
   //Считаем затраты по квартирам из файла квартира
   public function thisHouseExpenses(){
        foreach($this->apartments as $i){
		//$this->totalHouseTenants+=
           $this->totalHouseHeating+=$i->heating();
		   $this->totalHouseGarbage+=$i->garbage();
		   $this->totalHouseElevator+=$i->elevator();
		   $this->totalHouseCost+=$this->totalHouseHeating+$this->totalHouseGarbage+$this->totalHouseElevator;
       }
   }
   
   public function countTenantsOfAllApartments(){
		foreach($this->apartments as $i){
			$this->totalHouseTenants+=$i->tenants;
		}
   }  
   
      // метод подсчета размера коммунальных платежей со всех квартир в этом доме
   public function AllHouseCosts(){
       return $this->MOP()+$this->landTax()+$this->totalHouseCost;
   }
   
   public function info(){
       echo "<br>Номер дома {$this->number}<br>";
       echo "Кол-во этажей {$this->floorsQty}<br>";
       echo "Кол-во подъездов {$this->porchesQty}<br>";
       echo "Кол-во квартир в доме {$this->apartmentsInHouse()}<br>";
	   $this->countTenantsOfAllApartments();
	   echo "Кол-во жильцов в доме {$this->totalHouseTenants}<br>";
       echo "Площадь придомовой территории {$this->houseArea()} кв.м.<br><br>";
       echo "Тариф на освещение МОП - ".self::TARIFFELECTRICITYMOP." грн/этаж<br>";
       echo "Ставка налога на землю ".self::TARIFFTAXLAND." грн/мес.<br><br>";
       echo "<b>Затраты для всего дома</b> <br>";
       echo "Затраты на освещение - {$this->MOP()} грн/мес.<br>";
       echo "Налог на землю {$this->landTax()} грн/мес.<br><br>";
	   $this->thisHouseExpenses(); //вызываем метод здесь, т.к. он не возвращает значение
       echo "Стоимость услуги за отопление {$this->totalHouseHeating} грн/мес.<br>";
       echo "Стоимость услуги вывоза мусора {$this->totalHouseGarbage} грн/мес. <br>";
       echo "Стоимость услуги за электроснабжение лифтов {$this->totalHouseElevator} грн/мес.<br>";
       echo "<b>Итого </b>затраты на содержание <b>для всего дома</b> {$this->AllHouseCosts()} грн/мес.<br>";
   }
}
?>
