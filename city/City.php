<?php
namespace city;
  class City{
      public $cityName;
      public $foundationYear;
      public $coordinates;
	  public $streets=array();
            
      public $cityPopulation; //переменные для вычислений данных из других файлов (вложенных массивов)
      public $cityHeating;
      public $cityElevator;
      public $cityGarbage;
      public $cityMOP;
      public $cityLandTax;
      
      public function cityGen() {
        $titleCity = array("Kharkov", "Sevastopol", "Odessa");
        $titleCityR = $titleCity[array_rand($titleCity, 1)]; 
        if($titleCityR=="Kharkov"){
            return array(
            "cityName" => 'Kharkov',
            "foundationYear" => '1654',
            "coordinates" => "50°00′00\" с. ш. 36°13′45\" в. д."
            );
        }
         if($titleCityR=="Sevastopol"){
            return array(
            "cityName" => 'Sevastopol',
            "foundationYear" => '1783',
            "coordinates" => "44°36′00\″ с. ш. 33°32′00\″ в. д." 
            );
         }  
         if($titleCityR=="Odessa"){
            return array(
            "cityName" => 'Odessa',
            "foundationYear" => '1794',
            "coordinates" => "46°28′ с. ш. 30°44′ в. д." 
            );
        }
    }
      
      public function __construct(){
          $obj=$this->cityGen();
          $this->cityName=$obj['cityName'];
          $this->foundationYear=$obj['foundationYear'];
          $this->coordinates=$obj['coordinates'];
          $this->setStreets();
      }
      
      public function returnObjectCity(){
          $objCity=array('cityName'=>$this->cityName,'foundationYear'=>$this->foundationYear,'coordinates'=>$this->coordinates,'population'=>$this->cityPopulation,'cityExpenses'=>$this->cityMOP+$this->cityElevator+$this->cityGarbage+$this->cityHeating,'cityBudget'=>$this->cityLandTax);
          
          echo "<br>".json_encode($objCity)."<br><br>";
          var_dump($objCity);
          echo "<br><br>";
      }
      
	  public function setStreets(){
			for($i=0;$i<5;$i++){
			$this->streets[$i]=new Street();
			}
	  }
	        
      public function cityExpenses(){
      for($i=0;$i<5;$i++){// кол-во улиц
          for($j=0;$j<5;$j++){//кол-во домов на 1 улице
          $this->cityLandTax+=$this->streets[$i]->houses[$j]->landTax();
          $this->cityMOP+=$this->streets[$i]->houses[$j]->MOP();
              for($k=0;$k<$this->streets[$i]->houses[$j]->apartmentsInHouse();$k++){
              $this->cityPopulation+=$this->streets[$i]->houses[$j]->apartments[$k]->tenants;
              $this->cityHeating+=$this->streets[$i]->houses[$j]->apartments[$k]->heating();
              $this->cityElevator+=$this->streets[$i]->houses[$j]->apartments[$k]->elevator();
              $this->cityGarbage+=$this->streets[$i]->houses[$j]->apartments[$k]->garbage();
              }
          }
      }
      }
      
      public function information(){
        echo "<br><br>Название города {$this->cityName}<br>";
        echo "Год основания {$this->foundationYear}<br>";
        echo "Координаты {$this->coordinates}<br>";
        $this->cityExpenses();
        echo "Население {$this->cityPopulation} человек<br>";
        echo "Ставка налога на землю ".house::TARIFFTAXLAND." грн/мес.<br>";
        echo "<b>Бюджет города </b>(все налоги на землю) - {$this->cityLandTax} грн/мес.<br><br>";
        echo "<b>Затраты по всему городу</b> <br>";
        echo "Затраты на освещение - {$this->cityMOP} грн/мес.<br>";
        echo "Стоимость услуги за отопление {$this->cityHeating} грн/мес.<br>";
        echo "Стоимость услуги вывоза мусора {$this->cityGarbage} грн/мес. <br>";
        echo "Стоимость услуги за электроснабжение лифтов {$this->cityElevator} грн/мес.<br>";
       
        echo "<b>Итого <b>объем коммунальных платежей <b>со всех улиц</b> ".($this->cityMOP+$this->cityElevator+$this->cityGarbage+$this->cityHeating)." грн/мес.<br>";  
      }
  }
  
//    $oneCity=new City();
//    $oneCity->cityGen();
//    $oneCity->information();
  
?>
