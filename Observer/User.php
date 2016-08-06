<?php
/**
 *  其实观察者模式这是一种较为容易去理解的一种模式吧，它是一种事件系统，意味着这一模式允许某个类观察另一个类的状态，当被观察的类状态发生改变的时候，观察类可以收到通知并且做出相应的动作。比如键盘，我一敲击，系统就收到通知并进行相应的回应。
 *
 * 
 * php设计模式-观测者模式 
 * 
* 3.1.1概念:其实观察者模式这是一种较为容易去理解的一种模式吧，它是一种事件系统，意味 
          着这一模式允许某个类观察另一个类的状态，当被观察的类状态发生改变的时候， 
*          观察类可以收到通知并且做出相应的动作;观察者模式为您提供了避免组件之间
*          紧密耦合的另一种方法
* 3.1.2关键点:
*        1.被观察者->追加观察者;->一处观察者;->满足条件时通知观察者;->观察条件
*        2.观察者 ->接受观察方法
* 3.1.3缺点:
* 3.1.4观察者模式在PHP中的应用场合:在web开发中观察者应用的方面很多
*        典型的:用户注册(验证邮件，用户信息激活)，购物网站下单时邮件/短信通知等
* 3.1.5 php内部的支持  PHP内置提供了两个接口来供外部应用区实现这个模式。
*        SplSubject 接口，它代表着被观察的对象，
*        其结构：
*        interface SplSubject
*        {
*            public function attach(SplObserver $observer);
*            public function detach(SplObserver $observer);
*            public function notify();
*        }
*        SplObserver 接口，它代表着充当观察者的对象，
*        其结构：
*        interface SplObserver
*        {  
*            public function update(SplSubject $subject);
*        }
*
*	   这一个模式是这样实现的。SplSubject维护了一个特定的状态，当这个状态发生变化时，它就用notify()来通知之前用attach注册到SplSubject的所有SplObserver，并且调用其相应的update方法。
简单的例子：
* 
*/


/**
 * 用户登入 -- 诠释观察者模式 使用PHP 内置 SplSubject 、 SplObserver 接口实现
 */
class User implements SplSubject{

	// 注册观测者
	public $_observers = array();

	public $email = '';

	//动作类型
	CONST OBSERVER_TYPR_REGISTER = 1 ; // 注册
	CONST OBSERVER_TYPE_EDIT     = 2 ; // 编辑

	/**
	 * 注册观察者
	 * @param  SplObserver $observer 观察者
	 * @param  int      $type     观察类型
	 */
	public function attach(SplObserver $observer , $type = 1){

		$this->_observers[$type][] = $observer;
	}

	/**
	 * 删除观察者
	 * @param  SplObserver $observer 观察者
	 * @param  int      $type     观察者类型 
	 */
    public function detach(SplObserver $observer , $type = 1){
    	if( $index = array_search($observer , $this->_observers[$type] , true) ){
    		unset($this->_observers[$type][$index]);
    	}
    }

    /**
     * 满足条件时通知观察者
     * @param  int $type 观察类型
     */
    public function notify($type = 1){
    	if(!empty($this->_observers[$type])){
    		foreach($this->_observers[$type] as $observer){
    			$observer->update($this);
    		}
    	}
    }

    public function addUser($email){

    	$this->email = $email;

    	// 添加用户sql操作 
    	$this->notify(self::OBSERVER_TYPR_REGISTER);
    }

    public function editUser(){

    	// 编辑用户sql操作
    	$this->notify(self::OBSERVER_TYPE_EDIT);
    }
}

/**
 * 观察者--发送邮件
 */
class Send_Mail implements SplObserver{

	//private $_email = '';

	public function __construct(){

	}

	/**
	 * 相应被观察者的变更信息
	 * @param  SplSubject $subject 
	 */
	public function update(SplSubject $subject){

		$title   = 'Title';
		$content = 'Contents'; 

		$this->sendMail($subject->email , $title , $content);
	}

	public function test($val = ''){
		var_dump($val);
	}

	/**
	 * 发送邮件
	 * @param  str $email   
	 * @param  str $title   
	 * @param  str $content 
	 */
	public function sendMail($email , $title , $content){

		echo 'Message:'.$email.'--'.$title.'--'.$content.'<br/>';
	}
}


$user = new User();
$user->attach(new Send_Mail() , 1);
$user->attach(new Send_Mail() , 1);

$user->addUser('631536516');
//$user->addUser('214688869');


// function test(Array $arr = array()){

// 	var_dump($arr);
// }

// test();



// function obj(stdClass $obj ){
// 	var_dump($obj);
// }

// obj((object)array(1,2));


// obj();
// var_dump((object)array(1,2));

// var_dump(new User());


//function obj2()
//obj(new User);

