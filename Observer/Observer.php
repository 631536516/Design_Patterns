<?php
/**
 * 观察者模式
 *
 * 某个对象可以被设置为是可观察的，只要通过某种方式允许其他对象注册为观察者。每当被观察的对象改变时，会发送信息给观察者
 *
 * 观察者模式提供了一种避免组件之间紧密耦合的方法。该模式非常简单:一个对象通过添加一个方法（该方法允许另一个对象，即观察者注册自己）试本身变得可观察。当本身变得可观察。当观察的对象更改时，它会将消息发送到已注册的观察者。这些观察者使用该信息执行的操作与可观察的对象无关。结果是对象可以相互对话，而不必了解原因。
 *
 *
 * 观察者模式属于行为模式，是定义对象间的一种一对多的依赖关系，以便当一个对象的状态发生改变时，所有依赖于它的对象都得通知并自动刷新。它完美的将观察者对象和被观察者对象分离。可以在独立的对象（主体）中维护一个对主体感兴趣的依赖项（观察者）列表。让所有观察器各自实现公关的Observer接口，以取消主体和依赖性对象之间的直接依赖关系
 *
 *
 * 观察者设计模式定义对象的一对多依赖，当一个对象改变状态时，他的所有依赖者都会收到通知并自动更新！
 * 
 * 下面一个简单的示例：
 * 代码显示一个用户列表，添加用户时，它将发送出一条消息。添加用户时，通过发送消息的日志观察者可以观察此列表 
 */

interface IObserver{

	function onChanged($sender , $args);
}

interface IObservable{

	function addObserver($observer);
}

class UserList implements IObservable{

	private $_obersvers = array();
	
	public function addCustomers($name){
		foreach($this->_obersvers as $obs){
			$obs->onChanged($this , $name);
		}
	}

	public function addObserver($observer){

		$this->_obersvers[] = $observer;
	}
}

class UserListLogger implements IObserver{

	public function onChanged($sender , $args){

		echo "{$args} added to user list \n ";
	}
}

$ul =  new UserList();
$ul->addObserver(new UserListLogger());
$ul->addCustomers('Jack');



