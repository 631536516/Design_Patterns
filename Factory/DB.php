<?php
/**
 * 工厂模式的一个典型的应用就是：php可能要链接mysql，也可能要链接sqlserver，还有其他什么数据库。那么做一个抽象的数据库类，
 * 这个类就是一个工厂类，专门负责产生不同的对象。
 * 这样子做很方便扩展。我们在直接链接数据库的时候，不是使用代码new Mysql($host,$username,$password,$dbname)的形式
 * 而可以动态生成一个连接数据库的实例。可以是mysql，也可以是连接oracle的。
 *
 *还有做支付接口的时候，未来可能对应不同的支付网关：支付宝、财付通、网银在线等。方便未来扩展,设计成工厂模式。定一个专门生产网关接口的工厂，抽象出来,做成接口形式，让所有的子类都要实现它的接口。以后加一个支付方式，要使用哪一种支付方式，改变一下参数即可
 *
 * 书籍<php权威编程>(英文名称为PHP 5 Power Programming)也提到一个工厂模式的例子，学到一招：在为用户注册的时候，分为很多种角色的用户。比如册用户，匿名用户、管理员用户等。完全使用可以使用工厂的思想来实现,代码也容易维护,为每种角色可以生成操作的类。
 *
 *
 * 定义以下几个类：
 * UserFactory 用户工厂类，负责生成不同的用户类
 * User：用户类的基类，所有用户类都是继承这个类
 * 不同角色的类：注册用户类、匿名用户类、管理员用户类
 */


class DbFactory{

	public static function db($db_class_name){
		if( include_once('Drivers/'.$db_class_name.'.php') ){
			$className = 'Drivers_'.$db_class_name;
			return new $className;
		}else{
			throw new Exception("对应的数据库类没找到");
		}
	}
}

$mysql  = DbFactory::db('mysql');

$oracle = DbFactory::db('oracle');