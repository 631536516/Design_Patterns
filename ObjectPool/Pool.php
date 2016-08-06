<?php
/**
 * PHP 对象池设计模式
 *
 * 对象池()
 *
 * 对象池模式

今天忽然看到一个有趣的设计模式，就上网看了下，现做一个整理。

 

前期了解：Object Pool，即对象池，对象被预先创建并初始化后放入对象池中，对象提供者就能利用已有的对象来处理请求，减少对象频繁创建所占用的内存空间和初始化时间，例如数据库连接对象基本上都是创建后就被放入连接池中，后续的查询请求使用的是连接池中的对象，从而加快了查询速度。类似被放入对象池中的对象还包括Socket对象、线程对象和绘图对象（GDI对象）等。
  在Object Pool设计模式中，主要有两个参与者：对象池的管理者和对象池的用户，用户从管理者那里获取对象，对象池对于用户来讲是透明的，但是用户必须遵守这些对象的使用规则，使用完对象后必须归还或者关闭对象，例如数据库连接对象使用完后必须关闭，否则该对象就会被一直占用着。
  对象管理者需要维护对象池，包括初始化对象池、扩充对象池的大小、重置归还对象的状态等。
  对象池在被初始化时，可能只有几个对象，甚至没有对象，按需创建对象能节省资源和时间，对于响应时间要求较高的情况，可以预先创建若干个对象。
  当对象池中没有对象可供使用时，管理者一般需要使用某种策略来扩充对象池，比如将对象池的大小翻倍。另外，在多线程的情况下，可以让请求资源的线程等待，直到其他线程归还了占用的对象。
  一般来说，对象池中的对象在逻辑状态上是相同的，如果都是无状态对象（即没有成员变量的对象），那么这些对象的管理会方便的多，否则，对象被使用后的状态重置工作就要由管理者来承担。

1、意图

    在创建对象比较昂贵，或者对于特定类型能够创建的对象数目有限制时，管理对象的重用。

2、问题

    对象的创建和/或管理必须遵循一组定义明确的规则集。通常这些规则都与如何创建对象、能够创建多少个对象和在已有对象完成当前任务时如何重用它们等等相关。

3、通用结构

4、解决方案

    在需要一个Reusable对象时，Client调用ReusablePool的AcquireReusable方法。如果池是空的，那么AcquireReusable方法创建一个Reusable对象（如果能够），否则，就等待知道有Reusable对象返回集合。

5、参与者与协作

    ReusablePool管理着Client所用的Reusable对象的可用性。Client然后在一个有限的时间段内使用Reusable对象的实例，ReusablePool包含所有Reusable对象，这样就可以对其以统一的方式进行管理。

6、效果

    最适用于对对象的需求一直非常稳定的时候，需求变化太大会带来性能问题。ObjectPool中为了解决这一问题，限制了能够创建的对象数量。使管理实例创建的逻辑与实例被管理的类分离，可以得到内聚更好的设计。

7、实现

    如果可以创建的对象数量有限制，或者池的大小有限制，可以使用一个简单的数组来实现池。否则，使用vector对象，负责管理对象池的对象必须是唯一能够创建这些对象的对象。ReusablePool是使用Singleton模式实现的。另一种变体是在Reusable对象中加一个释放方法---让它自己返回到池。

 */

class Pool{
	private $instances = array();
	private $class;

	public function __construct($class){
		$this->class = $class;
	}
	public function get(){
		if(count($this->instances) > 0){
			return array_pop($this->instances);
		}
		return new $this->class;
	}
	public function dispose($instance){
		$this->instances[] = $instance;
	}
}

class Processor{
	private $pool;
	private $processing = 0;
	private $maxProcesses = 3;
	private $waitingQueue = array();

	public function __construct(Pool $pool){
		$this->pool = $pool;
	}
	private function createWorker($image){
		$worker = $this->pool->get();
		$worker->run($image , array($this,'proessDone'));
	}
	private function pushToWaitingQueue($image){
		$this->waitingQueue[] = $image;
	}
	private function popFormWaitingQueue(){
		return array_pop($this->waitingQueue);
	}
	public function process($image){
		if($this->processing++ < $this->maxProcesses){
			$this->createWorker($image);
		}else{
			$this->pushToWaitingQueue($image);
		}
	}
	public function processDone($worker){
		$this->processing --;
		$this->pool->dispose($worker);
		if(count($this->waitingQueue) > 0){
			$this->createWorker($this->popFormWaitingQueue());
		}
	}
}

class Worker{
	public function __construct(){

	}
	public function run($image , array $callback){
		call_user_func($callback , $this);
	}
}

class TestWorker
{
    public $id = 1;
}

//Case:
class PoolTest extends \PHPUnit_Framework_TestCase
{
    public function testPool()
    {
        $pool = new Pool(new TestWorker());
        $worker = $pool->get();

        $this->assertEquals(1, $worker->id);

        $worker->id = 5;
        $pool->dispose($worker);

        $this->assertEquals(5, $pool->get()->id);
        $this->assertEquals(1, $pool->get()->id);
    }
}

$pool = new Pool(new TestWorker());
$worker = $pool->get();

$this->assertEquals(1, $worker->id);

$worker->id = 5;
$pool->dispose($worker);

$this->assertEquals(5, $pool->get()->id);
$this->assertEquals(1, $pool->get()->id);


//---------------------------------------//

class Product{
	protected $id;
	public function __construct($id){
		$this->id = $id;
	}
	public function getId(){
		return $this->id;
	}
}
class Factory{
	protected static $products = array();
	public function __construct(){
		echo 11;
	}
	public static function pushProduct(Product $product){
		self::$products[$product->getId()] = $product;
	}
	public static function getProduct($id){
		return isset(self::$products[$id])?self::$products[$id]:null;
	}
	public static function removeProduct($id){
		if(array_key_exists($id, self::$products)){
			unset(self::$products[$id]);
		}
	}
}

Factory::pushProduct(new Product('first'));
Factory::pushProduct(new Product('second'));

var_dump(Factory::getProduct('first')->getId());

var_dump(Factory::getProduct('second')->getId());

