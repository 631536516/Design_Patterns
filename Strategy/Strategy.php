<?php
/**
 * PHP 策略模式
 * 策略模式:定义了算法簇，分别封装起来，让他们之间可以相互替换，此模式让算法的变化独立于使用算法分客户。
 *
 * 封装：把应为用接口封装起来，我们可以把那些经常变化的部分，从当前的类中单独取出来，用接口进行单独的封装。
 * 相互替换：我们封装好了接口，通过指定不同的接口实现类的进行算法的变化。
 *
 *
 *1.Joe做了一套相当成功的模拟鸭子的游戏。设计了一个超类Duck,然后让各种鸭子继承这个类。
 * 2.后来客户提出要让鸭子有飞的能力。所以Joe就在超类中加了个fly()方法，这样下面的子类都有飞行的行为。
 *  问题来了：
 * 1>原来Duck的子类中竟然有橡皮鸭，橡皮鸭是不会飞的。——Joe用重载的方式，把橡皮鸭的fly()方法设置为空.
 * 2>覆盖fly()，我们看到了橡皮鸭的fly()里，没有任何代码，如果以后我们再添加别的不会飞的鸭子，那我么还要这么处理吗?——那么代码重复了!
 *3.上面2的方式我们知道是有问题的，所以Joe想到把Duck做成接口，这样每个子类必须实现Duck里的方法。这样就保证每个鸭子都能根据自己的需要添加行为。
 *问题来了：产品经常处于更新中，规格也在不断的变化。导致每当有新鸭子的时候，Joe就要被迫检查一遍子类是否覆盖了fly()方法。——当你修改某个行为的时候，你必须得往下追踪并在每一个定义此行为的类中修改它。
 *4.综合以上问题，Joe想到了把那些变化的部分从不变化的位置中抽出来。比如，我们对fly()行为，做了单独的接口FlyBehavior。如果鸭子想要飞行功能的时候，我们就让鸭子实现FlyBehavior.
 *5.深造:我们想让鸭子有不同的飞行功能，让它在运行时候做不同的飞行动作。让鸭子类实现接口，只能让鸭子有一种行为。
 *所以Joe，想到用组合的防止，当鸭子需要其他飞行功能要求的时候，我们可以用setBehavior()方式，指定性的飞行方式。
 *
 *
 * 总结:
 * 	1、找出应用中可能需要变化之处，把它们独立出来，不要和那些不需要变化的代码混在一起。
 * 	2、针对接口编程、不针对实现编程。
 * 	3、多用组合，少用继承。
 * 
 */

interface FlyBehavior{

	public function fly();
}

class FlyWithWings implements FlyBehavior{
	public function fly(){
		echo "Fly With Wings <br/>";
	}
}

class FlyWithNo implements FlyBehavior{
	public function fly(){
		echo "Fly With No Wings <br/>";
	}
}

class Duck{
	private $_flyBehavior;
	public function setFlyBehavior(FlyBehavior $behavior){
		$this->_flyBehavior = $behavior;
	}
	public function performFly(){
		$this->_flyBehavior->fly();
	}
}

class RubberDuck extends Duck{

}

//Test Case
$duck = new RubberDuck();

//想让鸭子用翅膀飞行
$duck->setFlyBehavior(new FlyWithWings());
$duck->performFly();

//想让鸭子不用翅膀飞行
$duck->setFlyBehavior(new FlyWithNo());
$duck->performFly();











