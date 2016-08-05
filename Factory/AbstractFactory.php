<?php
/**
 * 抽象工厂
 *
 * 抽象工厂包含：
 * 
 * 【抽象工厂类】
 * 		【工厂A】 -> 生产 A 类产品 -> 包含 A1 、 A2 ... 产品
 * 		【工厂B】 -> 生产 B 类产品 -> 包含 B1 、 B2 ... 产品
 * 【抽象A产品类】
 * 		【产品 A1】
 * 		【产品 A2】
 * 【抽象B产品类】
 * 		【产品 B1】
 * 		【产品 B2】
 *
 * 中心调度中心 -> 创建工厂(实例化工厂(A、B)类) -> 创建产品类(实例化产品(A1、A2 | B1、B2)类) -> 获取产品信息 
 * 		
 */

/**
 * 创建抽象工厂类
 */
interface AbstractFactory{

	// 创建产品类
	public function createProduct($product_name);
}

/**
 * 创建A工厂
 */
class AFactory implements AbstractFactory{

	//创建产品类
	public function createProduct($product_name){

		return new $product_name;
	}
}

/**
 * 创建B工厂
 */
class BFactory implements AbstractFactory{

	//创建产品类
	public function createProduct($product_name){

		return new $product_name;
	}
}

/**
 * 创建A抽象产品类
 */
interface AProduct{

	public function getName();
}

/**
 * 创建A1产品
 */
class A1Product implements AProduct{

	public function getName(){

		return 'This is A1Product';
	}
}

/**
 * 创建A2产品
 */
class A2Product implements AProduct{

	public function getName(){

		return 'This is A2Product';
	}
}


/**
 * 创建抽象B产品类
 */
interface BProduct{

	public function getName();
}

class B1Product implements BProduct{

	public function getName(){

		return 'This is B1Product';
	}
}

class B2Product implements BProduct{

	public function getName(){

		return 'This is B2Product';
	}
}

/**
 * 中心调度类
 */
class CenterOpt{

	public static function getFactory($factory_name){

		return new $factory_name;
	}
}


//获取 AFactory 工厂
$factory = CenterOpt::getFactory('AFactory');
$product = $factory->createProduct('A1Product');
var_dump($product->getName());





