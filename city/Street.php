<?php
namespace city;
class Street{
    public $name;
	public $porchesQty;
    public $janitors; //дворники
    public $houses=array();
    public $streetCitizens;
    public $costStreetMop;
    public $costStreetLandTax;
    public $streetHeating;
    public $streetElevator;
    public $streetGarbage;
    
    public function streetsGen(){
        $titleStreet = array("Сумская", "Пушкинская", "проспект Победы", "площадь Конституции", "проспект Гагарина", "Набережная", "Гоголя", "Чернышевская", "3-я улица строителей", "Университетская", "Полтавский шлях", "Культуры"); 
        return array(
            "streetName" => $titleStreet[array_rand($titleStreet, 1)],
            );
    }
    
    public function __construct(){
        $obj=$this->streetsGen();
        $this->name=$obj['streetName'];
		$this->setHouses();    
    } 
    
   
    // метод расчета всех коммун.платежей со всех домой
    public function setHouses(){
        for($i=0;$i<10;$i++){
            $this->houses[$i]=new House(rand(1,5),rand(5,15),rand(1,10),rand(4,6),rand(100,500));
        }
    }   
    
    // подсчет кол-ва подъездов
    public function countPorchesQtyOfAllHouses(){
        foreach($this->houses as $i){
            $this->porchesQty+=$i->porchesQty;
        }
    }
	
    // подсчет кол-ва дворников, необходимых для уборки территории
	public function countJanitorsQty(){
		$this->janitors=floor($this->porchesQty/5); //т.е. один дворник из расчета на 5 подъездов
	}
    
    public function countStreetPaymentsByApartment(){
      for($i=0;$i<5;$i++){
          for($j=0;$j<10;$j++){
              $this->streetCitizens+=$this->houses[$i]->apartments[$j]->tenants;
              $this->streetHeating+=$this->houses[$i]->apartments[$j]->heating();
              $this->streetElevator+=$this->houses[$i]->apartments[$j]->elevator();
              $this->streetGarbage+=$this->houses[$i]->apartments[$j]->garbage();  
          }
      }
    }
    
    //для всей улицы
    public function countStreetPayments(){
         foreach($this->houses as $i){
            $this->costStreetMop+=$i->MOP();        // затраты МОП 
            $this->costStreetLandTax+=$i->landTax();// Налог на землю 
        }
    }
	
    // вывод инфо об улице
    public function information(){
        echo "<br>Название улицы {$this->name}<br>";
        echo "Кол-во домов на улице 10<br>";
		$this->countPorchesQtyOfAllHouses();
		$this->countJanitorsQty();
        $this->countStreetPaymentsByApartment();
		echo "Кол-во подъездов на улице {$this->porchesQty}<br>";
        echo "Необходимое кол-во дворников - {$this->janitors} человек<br>";
        echo "Кол-во жильцов на улице {$this->streetCitizens} человек<br>";
        echo "<b>Затраты для всей улицы</b> <br>";
        $this->countStreetPayments();
        echo "Затраты на освещение - {$this->costStreetMop} грн/мес.<br>";
        echo "Налог на землю - {$this->costStreetLandTax} грн/мес.<br><br>";
        echo "Стоимость услуги за отопление {$this->streetHeating} грн/мес.<br>";
        echo "Стоимость услуги вывоза мусора {$this->streetGarbage} грн/мес. <br>";
        echo "Стоимость услуги за электроснабжение лифтов {$this->streetElevator} грн/мес.<br>";
        echo "<b>Итого </b>объем коммунальных платежей, которые будут получены со всех домов <b>всей улицы</b> ".($this->costStreetLandTax+$this->costStreetMop+$this->streetElevator+$this->streetGarbage+$this->streetHeating)." грн/мес.<br>";
    }
}

    
//    $oneStreet=new Street();
//    $oneStreet->streetsGen();
//    $oneStreet->information()
?>
