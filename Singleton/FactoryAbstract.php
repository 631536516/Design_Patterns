<?php
/**
 * 为系统中的多个类创建单例的构造方式，可以建立一个通用的抽象父工厂方法
 */
abstract class FactoryAbstract{

	protected static $instances = array();

	public static function getInstance(){
		$className = static::getClassName();
		if (!(self::$instances[$className] instanceof $className)){
			self::$instances[$className] = new $className();
		}
		return self::$instances[$className];
	}

	public static function removeInstance(){
		$class = static::getClassName();
		if (array_key_exists($className, self::$instances)){
			unset(self::$instances[$className]);
		}
	}

	final protected static function getClassName(){
		return get_called_class();
	}
}

abstract class Factory extends FactoryAbstract{

	final public static function getInstance(){
		return parent::getInstance();
	}

	final public static function removeInstance(){
		parent::removeInstance();
	}
}


// using;
class FirstProduct extends Factory{

	public $a = array();
}

class SecondProduct extends FirstProduct{

}
 
FirstProduct::getInstance()->a[]  = 1;
SecondProduct::getInstance()->a[] = 2;
FirstProduct::getInstance()->a[]  = 3;
SecondProduct::getInstance()->a[] = 4;

print_r(FirstProduct::getInstance()->a);
print_r(SecondProduct::getInstance()->a);