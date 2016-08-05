<?php
/**
 * 观察者模式设计定义对象的一对多依赖，这样一来，当一个对象改变状态时，他的所有依赖者都会收到通知并自动更新!
 *
 * 设计原理
 * 	 在观察者模式中，会改变的是主体的状态以及观察者的数目。用这个模式，你可以改变依赖于主体状态的对象，却不必改变主体。找出程序中会出变化的方面，然后将其和固定不变的方面想分离！
 * 	 主体和观察者利用主体的接口向主体注册，而主体利用观察者接口通知观察者。这样可以让两者之间运作正常，又不同时具有松耦合的优点！-- 针对接口编程，不针对实现编程
 * 	 观察者模式利用组合将许多观察者组合进主体中。对象（观察者--主体）之间的这种关系不是通过继承产生的，而是在运行时利用组合的方式产生的。-- 多用组合，少用继承！
 */

class Paper{

	private $_observer = array();

	/**
	 * 注册观察者
	 */
	public function register($sub){
	
		$this->_observer[] = $sub;
	}

	/**
	 * 外部统一访问
	 */
	public function trigger(){
		if(!empty($this->_observer)){
			foreach($this->_observer as $observer){
				$observer->update();
			}
		}
	}

}

/**
 * 观察者要实现的接口
 */
interface Observerable{

	public function update();
}

class Subscriber implements Observerable{

	public function update(){

		echo 'Callback';
	}
}



$paper = new Paper();
$paper->register(new Subscriber());
$paper->register(new Subscriber());
$paper->trigger();