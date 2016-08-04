<?php
/**
 * Mysql 单例应用
 */
class Mysql{

	//该属性用来保存实例
	private static $_instance;

	public $conn;

	public static $sql;


	//私有构造函数，防止对new创建对象
	private function __construct(){
		var_dump('construct');
		$db = array(
			'host' 		=> '127.0.0.1',
			'user' 		=> 'root',
			'password'	=> '',
			'database' 	=> 'test'
		);
		
		$this->conn = new mysqli($db['host'] , $db['user'] , $db['password'] , $db['database']);
		if( $this->conn->connect_errno ){
			die('Connect error'.$this->conn->connect_error);
		}
	}

	public static function getInstance(){
		if ( !(self::$_instance instanceof self) ){
			self::$_instance =  new self;
		}
		return self::$_instance;
	}

	/**
	 * 查询语句
	 */
	public function select($table , $condition = array() , $filed = array()){
		$where = '';
		if(!empty($condition)){
			foreach($condition as $k => $v){
				$where .= $k."='".$v."' and";
			}
			$where = 'where '.$where.' 1=1'; 
		}

		$filedstr = '';
		if(!empty($filed)){
			foreach($filed as $k => $v){
				$filedstr .= $v.',';
			}
			$filedstr = rtrim($filedstr,',');
		}else{
			$filedstr = '*';
		}

		self::$sql = "select {$filedstr} from {$table} {$where}";
		$result = $this->conn->query(self::$sql);
		$resultRow = array();
		$i = 0;
		while($row = $result->fetch_array()){
			foreach($row as $k => $v){
				$resultRow[$i][$k] = $v;
			}
			$i++;
		}
		return $resultRow;
	}

	/** 
     * 添加一条记录 
     */  
    public function insert($table,$data){  
        $values = '';  
        $datas = '';  
        foreach($data as $k=>$v){  
            $values.=$k.',';  
            $datas.="'$v'".',';  
        }  
        $values = rtrim($values,',');  
        $datas   = rtrim($datas,',');  
        self::$sql = "INSERT INTO  {$table} ({$values}) VALUES ({$datas})";  
        if(mysql_query(self::$sql)){  
            return mysql_insert_id();  
        }else{  
            return false;  
        };  
    }  

	/** 
      * 修改一条记录 
      */  
    public function update($table,$data,$condition=array()){  
        $where='';  
        if(!empty($condition)){  
              
            foreach($condition as $k=>$v){  
                $where.=$k."='".$v."' and ";  
            }  
            $where='where '.$where .'1=1';  
        }  
        $updatastr = '';  
        if(!empty($data)){  
            foreach($data as $k=>$v){  
                $updatastr.= $k."='".$v."',";  
            }  
            $updatastr = 'set '.rtrim($updatastr,',');  
        }  
        self::$sql = "update {$table} {$updatastr} {$where}";  
        return mysql_query(self::$sql);  
    }  

	/** 
     * 删除记录 
     */  
    public function delete($table,$condition){  
        $where='';  
        if(!empty($condition)){  
            foreach($condition as $k=>$v){  
                $where.=$k."='".$v."' and ";  
            }  
            $where='where '.$where .'1=1';  
        }  
        self::$sql = "delete from {$table} {$where}";  
        return mysql_query(self::$sql);  
    }  

    /**
     *  查看最后Mysql语句
     */
	public function getLastSql(){

		return self::$sql;
	}
}

// $mysql = Mysql::getInstance();

// $res = $mysql->select('album');

// var_dump($res);


