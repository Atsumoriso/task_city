<?php
namespace city;
class Apartment{
    public $number; 
    public $rooms; 
    public $square; 
    public $balconySq;
    public $floorN;
    public $tenants; // кол-во жильцов
    const TARIFFHEATING = 10; 
    const TARIFFGARBAGE = 7;
    const TARIFFELEVATOR = 0.5;
    
    
    public function __construct($number,$rooms,$square,$balconySq,$floorN,$tenants){  
    $this->number=$number;
    $this->rooms=$rooms;
    $this->square=$square;
    $this->balconySq=$balconySq;
    $this->floorN=$floorN;
    $this->tenants=$tenants;
    }
    
    //метод посчитать площадь без балконов
    public function sqBezBalc(){   
        return $this->square-$this->balconySq; 

    }
    
    //метод посчитать плату за отопление
    public function heating(){
        return self::TARIFFHEATING*$this->sqBezBalc();        
    }
    
    // метод посчитать вывоз мусора 
    public function garbage(){
       return self::TARIFFGARBAGE*$this->tenants;
    }
    
    //метод посчитать плату за лифт
    public function elevator(){
        return self::TARIFFELEVATOR*$this->floorN;
    }
    
    //метод посчитать сумму коммунальных платежей
    public function allApartmCosts(){
        return $this->heating()+$this->garbage()+$this->elevator();
    } 
    
    //метод вывести инфо о квартире
    public function information(){
        echo "<br>Номер квартиры {$this->number}<br>";
        echo "Количество комнат в квартире {$this->rooms}<br>";
        echo "Общая площадь квартиры {$this->square} кв.м.<br>";
        echo "Площадь балконов {$this->balconySq} кв.м.<br>";
        echo "Этаж {$this->floorN}<br>";
        echo "Кол-во жильцов {$this->tenants}<br>";
        
        echo "Тариф на отопление ".self::TARIFFHEATING." грн/мес за 1 кв.м.<br>";
        echo "Тариф на вывоз мусора ".self::TARIFFGARBAGE." грн/мес. на 1 человека<br>";
        echo "Тариф на электроснабжение лифтов ".self::TARIFFELEVATOR." грн/мес.<br>";
        
        echo "Стоимость услуги за отопление {$this->heating()} грн/мес. за {$this->sqBezBalc()} кв.м.<br>";
        echo "Стоимость услуги вывоза мусора {$this->garbage()} грн/мес. для квартиры из {$this->tenants} человек <br>";
        echo "Стоимость услуги за электроснабжение лифтов {$this->elevator()} грн/мес. за {$this->floorN} этаж<br>";
        echo "Итого коммунальные расходы {$this->allApartmCosts()} грн/мес.<br>";
    }
    
    public function addTenants($tenants, $flag=false){ // на сколько меньше жильцов
        if (!$flag) {
            $this -> tenants += $tenants;
        } else {
            if ($this -> tenants - $tenants > 0 ) $this->tenants -= $tenants;
        }
        }   
    }

?>
