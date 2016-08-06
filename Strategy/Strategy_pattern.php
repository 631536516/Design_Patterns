<?php
/**
 * 策略模式是对象的行为模式，用意是对一组算法的封装，动态的选择需要的算法并使用。
 * 策略模式指的是程序中涉及决策控制的一种模式。策略模式功能非常强大，因为这个涉及模式本身的核心思想就是面向对象编程的多形式思想。
 *
 * 策略模式的三个角色：
 * 1、抽象策略角色
 * 2、具体策略角色
 * 3、环境角色(对具体策略角色的引用)
 * 实现步骤：
 * 1、定义抽象角色类(定义好各个实现分共同抽象方法)
 * 2、定义具体策略类(具体实现父类的共同方法)
 * 3、定义环境角色类(私有化申明抽象角色变量，重载构造方法，执行抽象方法)
 *
 */

//抽象策略类
interface baseAgent{
	public function PrintPage();
}
//用于客户端是IE时调用的类(具体策略角色)
class ieAgent implements baseAgent{
	public function PrintPage(){
		echo 'IE <br/>';
	}
}
//用户客户端不是IE时调用的类(具体策略角色)
class otherAgent implements baseAgent{
	public function PrintPage(){
		echo 'not IE <br/>';
	}
}

//环境角色
class Browers{
	public function call(baseAgent $agent){
		return $agent->PrintPage();
	}
}

$bro =  new Browers();
$bro->call(new ieAgent());
$bro->call(new otherAgent());

