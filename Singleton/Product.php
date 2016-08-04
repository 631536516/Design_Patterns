<?php
/**
 * Singleton class
 * 单例模式是最常见的模式之一，在Web应用的开发中，常常用于允许在运行时为某个特定的类创建一个可访问的实例
 *
 * 单例模式确保某个类只有一个实例，而且自行实例化并向整个系统提供这个实例
 * 
 * 单例模式有以下3个特点
 * 1、只能有一个实例
 * 2、必须自行创建这个实例
 * 3、必须给其他对象提供这一实例
 *
 * 单例模式至少拥有以下三种公共元素
 * 1、必须拥有一个构造函数，并且必须被标记为prvate
 * 2、拥有一个保存类的实例的静态成员变量
 * 3、拥有一个访问这个实例的公共的静态方法
 *
 * Why 使用单例模式？
 * 	 PHP一个主要应用场合就是应用程序与数据库打交道的场景，在一个应用的中会存在大量的数据库操作，针对数据库句柄连接数据库的行为，使用单例模式可以避免大量的new操作。因为每一次new操作都会消耗系统的内存和资源。
 *
 * 单例模式的类会伴随PHP运行的整个生命周期(仅仅是指页面级的)，对于内存也是一种消耗
 *
 *PHP的单例模式是相对而言的，因为PHP的解释运行机制使得每个PHP页面被解释执行之后，所有的相关资源都会被回收
 *也即PHP在语言级别上没法让某个变量常驻内存,在PHP中，所有的变量都是页面级的，无论是全局变量，还是静态变量，都会在页面执行完毕后被清空，结果会重新建立新的对象，这样也就完全失去了Singleton的意义。不过，在实际应用中同一个页面中可能会存在多个业务逻辑，这时单例模式就起到了很重要的作用，有效的避免了重复new对象(消耗资源跟内存)这样的行为，所以所PHP的单例模式是相对而言的。
 * 
 * $_instance 必须声明为静态的私有变量
 * 构造函数和析构函数、克隆函数必须声明为私有，防止外部程序new(clone)类从而失去单例的意义
 * getInstance() 方法必须声明为公有的，必须调用此方法以返回实例的一个引用
 * 使用单例模式生成一个对象后，该对象可以被其他众多对象所使用
 * 
 * 
 */
class Product{
	
	/**
	 * @var self 用来保存类的实例的静态成员变量
	 */
	private static $_instance;

	/**
	 * Return self _instance  用来访问这个实例的公共的静态方法,通过 instanceof 操作符来检测类是否已经被实例化了
	 * 
	 * @return self
	 */
	public static function getInstance(){
		var_dump(self::$_instance);
		if(!(self::$_instance instanceof self)){
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * private 标记的构造函数 防止被 new 
	 */
	private function __construct(){

		//disallow new instance
		var_dump('__construct');
	}

	/**
	 * 创建 __clone() 方法防止对象被复制(克隆)
	 */
	private function __clone(){

		//disallow clone
		//trigger_error('Clone is not allow!',E_USER_ERROR);
	}

	public function test(){
		var_dump('success');
	}
}

$firstProduct  = Product::getInstance();
$secondProduct = Product::getInstance();

$firstProduct->val = '111';
var_dump($firstProduct->val);
var_dump($secondProduct->val);

$firstProduct->test();
$secondProduct->test();



//$obj =  new Product();    // 抛出错误

//$obj =  clone $firstProduct; // 抛出错误
class B extends Product{

	public function __construct(){

	}
}

$obj =  new B();

$obj->test();




