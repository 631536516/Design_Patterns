<?php
class A{
	public  $A_val = 'A_A_val';
	public  $val = 'A_val';
	public  static $_val = 'A_staic_val';
	public function __construct(){
		var_dump('A');
		var_dump($this->val);
		var_dump(self::$_val);
	}
}

class B extends A{

	public $val = 'B_val';
	public static $_val = 'B_val';
	public function __construct(){
		parent::__construct();
		var_dump('B');
		var_dump($this->val);
		var_dump(self::$_val);

		var_dump(parent::$_val);

		var_dump($this->A_val);

	}
}



//$obj = new B();

class C{
	public $val = 'val';
}

$a  = new C();
$b  =  $a;

$b->val = 'aaa';

var_dump($a->val);
var_dump($b->val);

$c = new C();
$d = &$c;

$d->val ="ccc";

var_dump($c->val);
var_dump($d->val);

