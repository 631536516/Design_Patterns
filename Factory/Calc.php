<?php
/**
 *使用工厂模式(简单工厂)实现一个运算类
 *
 * 工厂模式：
 * 由工厂类根据参数来决定创建出哪一种产品(功能)类的实例
 * 工厂类是指包含了一个专门用来创建其他对象的的方法的类，所谓按需分配，传入参数进行选择，返回具体的类.
 * 工厂模式的最主要作用就是对象创建的封装、简化创建对象的操作。
 * 简明的说，就是调用工厂类的一个方法（传入参数）来得到需要的类。
 * 
 * 工厂模式包含：
 * ①抽象基类：类中定义抽象一些方法，用以在子类中实现
 * ②继承自抽象基类的子类(具体的功能类)：实现基类中的抽象方法
 * ③工厂类：用以实例化(功能类)对象
 *
 * 
 * 
 * 使用工厂模式的目的或目标？
 * 工厂模式的最大优点在于创建对象上面，就是把创建对象的过程封装起来，这样随时可以产生一个新的对象。
 * 减少代码进行复制粘贴，耦合关系重，牵一发动其他部分代码。
 * 通俗的说，以前创建一个对象要使用new，现在把这个过程封装起来了。
 * 假设不使用工厂模式：那么很多地方调用类a，代码就会这样子创建一个实例：new a(),假设某天需要把a类的名称修改，意味着很多调用的代码都要修改。
 *
 * 工厂模式的优点就在创建对象上。
 * 工厂模式的优点就在创建对象上。建立一个工厂（一个函数或一个类方法）来制造新的对象,它的任务就是把对象的创建过程都封装起来，
 * 创建对象不是使用new的形式了。而是定义一个方法，用于创建对象实例。
 *
 * 工厂模式有很多变体，抓住精髓才是关键：只要是可以根据不同的参数生成不同的类实例，那么就符合工厂模式的设计思想。
 *
 * pc_base:load_app_class("order"');//参数名称就是类名称。将会生成得到order这个实例。传递不同的参数得到不同的类实例，这个就符合工厂模式。
 * pc_base:load_app_class("comment"');//生成一个comment类实例
 *
 * 工厂模式我想到的一个典型的应用就是：php可能要链接mysql，也可能要链接sqlserver，还有其他什么数据库。那么做一个抽象的数据库类，
 * 这个类就是一个工厂类，专门负责产生不同的对象。
 * 这样子做很方便扩展。我们在直接链接数据库的时候，不是使用代码new Mysql($host,$username,$password,$dbname)的形式
 * 而可以动态生成一个连接数据库的实例。可以是mysql，也可以是连接oracle的。
 *
 *
 *
 * 简单工厂
 *
 * 简单工厂包含：
 * 
 * 【抽象运算(Calc)类】
 * 		【Add运算类】 
 * 		【Sub运算类】 
 * 		【Mul运算类】 
 * 		【Div运算类】 
 * 		【Rem运算类】 	
 * 【工厂(Factory)类】 -> 创建运算类(实例化(Add、Sub ...)类) -> 运算操作
 * 
 */

/**
 * 抽象运算类
 * 声明一个抽象基类，在基类中指定子类要实现的方法(getValue())
 */
abstract class Calc{

	/**
	 * 抽象方法
	 */
	abstract public function getValue($num1 , $num2);
}

// 以下:实现具体功能的子类
/**
 * 加法类
 */
class CalcAdd extends Calc{

	public function getValue($num1 , $num2){

		return $num1 + $num2;
	}
}

/**
 * 减法类
 */
class CalcSub extends Calc{

	public function getValue($num1 , $num2){

		return $num1 - $num2;
	}
}

/**
 * 乘法类
 */
class CalcMul extends Calc{

	public function getValue($num1 , $num2){

		return $num1 * $num2;
	}
}

/**
 * 除法类
 */
class CalcDiv extends Calc{

	public function getValue($num1 , $num2){
		try{
			if( $num2 == 0){
				throw new Exception("除数不能为0");
			}else{
				return $num1 / $num2;
			}
		}catch(Exception $e){
			echo "错误信息".$e->getMessage();
		}
	}
}

/**
 * 求余类
 */
class CalcRem extends Calc{

	public function getValue($num1 , $num2){

		return $num1 % $num2;
	}
}

/**
 * 现在还有一个问题未解决,就是如何让程序根据用户输入的操作符实例化相应的对象呢？
 * 解决办法：使用一个单独的类来实现实例化的过程，这个类就是工厂
 *
 * 创建用来实例化上面功能类的工厂
 * 
 * 工厂类，主要用来创建对象
 * 功能：根据输入的运算符号，工厂就能实例化出合适的对象
 */

class Factory{

	public static function createObj($operate){
		switch($operate){
			case '+':
				return new CalcAdd();
				break;
			case '-':
				return new CalcSub();
				break;
			case '*':
				return new CalcMul();
				break;
			case '/':
				return new CalcDiv();
				break;
			case '%':
				return new CalcRem();
				break;
		}
	}
}

$obj  = Factory::createObj('+');
$res  = $obj->getValue(1,2);
var_dump($res);



