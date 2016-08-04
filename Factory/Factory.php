<?php
/**
 * 工厂模式，正如其名字所示:确实是对象实例的生成工厂。某些意义上，工厂模式提供了通用的方法有助于我们去获取对象，而不需要关心其具体的内在的实现。
 */
interface Factory{

	public function getProduct();
}

interface Product{

	public function getName();
}

class FirstFactory implements Factory{

	public function getProduct(){

		return new FirstProduct();
	}
}

class SecondFactory implements Factory{

	public function getProduct(){

		return  new SecondProduct();
	}
}

class FirstProduct implements Product{

	public function getName(){

		return 'The first Product';
	}
}

class SecondProduct implements Product{

	public function getName(){

		return 'The Second Product';
	}
}

$factory = new FirstFactory();
$firstProduct = $factory->getProduct();

$factory = new SecondFactory();
$secondProduct = $factory->getProduct();

print_r($firstProduct->getName());

print_r($secondProduct->getName());

