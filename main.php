<?php

class Car
{
    private $color = 'white';
    private $cost;
    private $name;

    public function __construct($name, $color, $cost)
    {
        $this->name = $name;
        $this->color = $color;
        $this->cost = $cost;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setColor($color)
    {
        $this->color = $color;
    }

    public function getCost()
    {
        return $this->cost;
    }

    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    public function getName()
    {
        return $this->name;
    }
}

class TelevisionSet
{
    const STATE_OFF = 'выключен';
    const STATE_ON = 'включен';

    private $name;
    private $state = self::STATE_OFF;
    private $channel;
    private $volume;

    public function __construct($name)
    {
        $this->name = $name;
        $this->channel = 1;
        $this->volume = 50;
    }

    public function getVolume()
    {
        return $this->volume;
    }

    public function volumeUp()
    {
        $this->volume = ($this->state === self::STATE_ON) && ($this->volume) < 100 ? ++$this->volume : $this->volume;
    }

    public function volumeDown()
    {
        $this->volume = ($this->state === self::STATE_ON) && ($this->volume) > 0 ? --$this->volume : $this->volume;
    }

    public function turnOn()
    {
        $this->state = self::STATE_ON;
    }

    public function turnOff()
    {
        $this->state = self::STATE_OFF;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getState()
    {
        return $this->state;
    }

    public function getChannel()
    {
        return $this->channel;
    }

    public function setChannel($channel)
    {
        $this->channel = $this->state === self::STATE_ON ? $channel : $this->channel;
    }
}

class Pen
{
    private $color;
    private $thickness;
    private $inkLevel;

    public function __construct($color, $thickness, $inkLevel = 100)
    {
        $this->color = $color;
        $this->thickness = $thickness;
        $this->inkLevel = $inkLevel;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function getThickness()
    {
        return $this->thickness;
    }

    public function getInkLevel()
    {
        return $this->inkLevel;
    }

    public function usePen()
    {
        $this->inkLevel = $this->inkLevel > 0 ? --$this->inkLevel : 0;
    }
}

class Duck
{
    private $age;
    private $color;
    private $weight;

    public function __construct($color, $age = 1, $weight = 1)
    {
        $this->color = $color;
        $this->age = $age;
        $this->weight = $weight;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function changeWeight($changeWeight)
    {
        $this->weight = ($this->weight + $changeWeight) >= 1 ? ($this->weight + $changeWeight) : 1;
    }

    public function upAge()
    {
        $this->age = ++$this->age;
    }

    public function getColor()
    {
        return $this->color;
    }
}

class Product
{
    private static $groupDiscount = [];
    public $name;
    private $price;
    private $productDiscount;
    private $productGroup;

    public function __construct($name, $price, $productGroup, $productDiscount = 0)
    {
        $this->name = $name;
        $this->price = $price;
        $this->productGroup = $productGroup;
        $this->productDiscount = $productDiscount;
    }

    public function getProductInfo()
    {
        $product = [
            $this->getProductGroup(),
            $this->name,
            $this->getPrice(),
            self::getGroupDiscount($this->productGroup),
            $this->getProductDiscount()
        ];
        return $product;
    }

    public function getProductGroup()
    {
        return $this->productGroup;
    }

    public function setProductGroup($productGroup)
    {
        $this->productGroup = $productGroup;
    }

    /**
     * выводит цену с учетом скидки (выбирается максимальная скидка)
     * @return mixed
     */
    public function getPrice()
    {
        $discount = max($this->productDiscount, self::getGroupDiscount($this->productGroup));
        return $this->price * (1 + $discount / 100);
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public static function getGroupDiscount($group)
    {
        return isset(self::$groupDiscount[$group]) ? self::$groupDiscount[$group] : 0;
    }

    public static function setGroupDiscount($group, $discount)
    {
        self::$groupDiscount[$group] = $discount;
    }

    public function getProductDiscount()
    {
        return $this->productDiscount;
    }

    public function setProductDiscount($productDiscount)
    {
        $this->productDiscount = $productDiscount;
    }
}

/* ----------- */

$carAudi = new Car('Audi', 'white', 1000000);
$carKia = new Car('Kia', 'black', 800000);
$carKia->setCost(850000);
$formatCar = "Машина: %s цвета %s и стоимостью %u руб.<br>";

echo sprintf($formatCar, $carAudi->getName(), $carAudi->getColor(), $carAudi->getCost());
echo sprintf($formatCar, $carKia->getName(), $carKia->getColor(), $carKia->getCost());
echo '<br>';

/* ----------- */

$tvPhilips = new TelevisionSet('Philips');
$tvSony = new TelevisionSet('Sony');

$tvPhilips->turnOn();
$tvPhilips->setChannel(10); // канал изменится, т.к. телевизор включен
$tvSony->setChannel(10); // канал не изменится, т.к. телевизор выключен

for ($i = 1; $i < 10; $i++) {
    $tvPhilips->volumeUp(); // громкость меняться будет, т.к. телевизор включен
    $tvSony->volumeDown(); // громкость меняться не будет, т.к. телевизор выключен

}
$tvPhilips->turnOff();
$tvSony->turnOn();

$formatTV = "Телевизор %s сейчас %s, установлен канал %u, громкость на уровне %u.<br>";

echo sprintf($formatTV, $tvPhilips->getName(), $tvPhilips->getState(), $tvPhilips->getChannel(), $tvPhilips->getVolume());
echo sprintf($formatTV, $tvSony->getName(), $tvSony->getState(), $tvSony->getChannel(), $tvSony->getVolume());
echo '<br>';

/* ----------- */

$whitePen = new Pen('white', '0.5', 80);
$blackPen = new Pen('black', '0.7');

for ($i = 0; $i < 150; $i++) {
    if (rand(1, 2) === 1) {
        $whitePen->usePen();
    } else {
        $blackPen->usePen();
    }
}

$formatPen = "Ручка: цвет %s, толщина стержня %01.1f, уровень чернил %u.<br>";

echo sprintf($formatPen, $whitePen->getColor(), $whitePen->getThickness(), $whitePen->getInkLevel());
echo sprintf($formatPen, $blackPen->getColor(), $blackPen->getThickness(), $blackPen->getInkLevel());
echo '<br>';

/* ----------- */

$brownDuck = new Duck('brown', 2, 2);
$blackDuck = new Duck('black', 5);

for ($i = 0; $i < 10; $i++) {
    $brownDuck->changeWeight(rand(-1, 1));
    $blackDuck->changeWeight(rand(-1, 1));
    $brownDuck->upAge();
    $blackDuck->upAge();
}

$formatDuck = "Утка цвета %s, ее возраст %u и вес %u кг. <br>";

echo sprintf($formatDuck, $brownDuck->getColor(), $brownDuck->getAge(), $brownDuck->getWeight());
echo sprintf($formatDuck, $blackDuck->getColor(), $blackDuck->getAge(), $blackDuck->getWeight());
echo '<br>';

/* ----------- */

$phoneSamsung = new Product('Samsung', 20000, 'Смартфон');
$phoneApple = new Product('Apple', 30000, 'Смартфон', 10);
$caseSamsung = new Product('Samsung', 600, 'Чехол', 15);
$caseApple = new Product('Apple', 700, 'Чехол', 25);

Product::setGroupDiscount('Смартфон', 5);
Product::setGroupDiscount('Чехол', 20);

$formatProduct = "Товар %1\$s %2\$s, цена %3\$u руб., скидка на всю группу %1\$s - %4\$u, скидка именно на %1\$s %2\$s - %5\$u. <br>";

echo vsprintf($formatProduct, $phoneSamsung->getProductInfo());
echo vsprintf($formatProduct, $phoneApple->getProductInfo());
echo vsprintf($formatProduct, $caseSamsung->getProductInfo());
echo vsprintf($formatProduct, $caseApple->getProductInfo());
echo '<br>';




