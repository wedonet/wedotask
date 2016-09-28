<?php   
  
/**  
* 功能:数据库操作类  
* 作者:phpox  
* 日期:Tue Aug 14 08:46:27 CST 2007  
*/  
  
  
class ClsPdo{
	
private static $instance;   
public $dsn;   
public $dbuser;   
public $dbpass;   
public $sth;   
public $dbh;   
public $isconnected = false;

       
function __construct(){   
	$this->connect();

}   

    
public static function getInstance(){   
	if (self::$instance === null)   
	{   
		self::$instance = new include_database();   
	}   
	return self::$instance;   
}   
       
//连接数据库   
private function connect()   
{   
	$config =& $GLOBALS['config'];

	try    
	{   
		$this->dbh = new PDO('mysql:host='.$config['DbHost'].';dbname='.$config['Dbname']
			,$config['Dbuser']
			,$config['Dbpass']);   
	}   
	catch (PDOException $e)   
	{   
		exit('连接失败:'.$e); //.$e->getMessage());   
	}   
	$this->dbh->setAttribute ( PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true );


	$this->dbh->query('SET NAMES UTF8');   
	$this->dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}   
       
//获取数据表里的字段   
public function getFields($table) {   
	//if (!$this->isconnected) {
	//   $this->connect();
	//}
	
	try{
		$this->sth = $this->dbh->query('DESCRIBE '.$table);   
	}
	catch(PDOException $e){
		showerr('数据表不存在'.$table);
	} 
	

	$this->getPDOError();   
	//$this->sth->setFetchMode(PDO::FETCH_ASSOC);   
	$result = $this->sth->fetchAll(PDO::FETCH_COLUMN, 0);   
	$this->sth = null;   

	return $result;  	
}   
        
   
//插入数据   
public function insert($table, $arr, $debug = null){
	$i=0;
	$a = array();
	$b = array();
	$c = array();
	foreach ($arr  as $k=>$v ) {
		$a[$i] = '`' .$k. '`';
		$b[$i] = '?';
		$c[$i] = $v;
		$i++;
	}
	$sql = 'insert into `' .$table. '`  ('.implode(', ', $a).') values ('.implode(', ', $b).')';

	$stmt = $this->dbh->prepare($sql);  
	$this->getPDOError();   	

	$mycount=$i;
	for ($i=0; $i<$mycount; $i++) {
		
	    $stmt->bindParam(($i+1), $c[$i]);
	}

	$stmt->execute();
	
	return $this->dbh->lastinsertid();  
//	return false;   
}   

//更新数据
public function update($table, $rs, $where){
	$sql = 'update `' .$table. '` set ';

	$a = array();
	$i = 0;
	foreach ($rs as $k=>$v ) {
		$a[$i] = '`' .$k. '`=:' .$k;
		$i++;
	}
	$sql .= join(',', $a) . ' where ' . $where;

	$stmt = $this->dbh->prepare($sql);

	foreach ($rs as $k=>$v ) {
		$stmt->bindValue(':'.$k, $v);
	}

	$stmt->execute();
	
	return $stmt->rowCount();	
}

public function select($sql, $para=null){
	$stmt = $this->dbh->prepare($sql);

	$this->getPDOError();

	if ($para == null) {
		$stmt->execute();
	}
	else {
		$stmt->execute($para);
	}	

	$rs = $stmt->fetchAll();

	$a['rs'] = $rs;

	return $a;
}

public function del($sql, $para=null){
	$stmt = $this->dbh->prepare($sql);

	$this->getPDOError();

	if ($para == null) {
		$stmt->execute();
	}
	else {
		$stmt->execute($para);
	}	

	return $stmt->rowCount();	
} // end func
   


/**  
 * 执行SQL查询  
 *  
 */  
public function execute($sql, $para=null, $haspage=false) {   
	//$sql  = str_replace('select', 'select sql_calc_found_rows ', $sql);
	//$sql.=';SELECT FOUND_ROWS();';
	//echo $sql;
	//die;

	/*带翻页时加上返回总记录数*/
	if ($haspage !== false) {

		/*把select 加上 sql_calc_found_rows */	
		$sql = substr($sql, stripos($sql, 'select')+6);

		$sql = 'select sql_calc_found_rows '.$sql;
	}

	$stmt = $this->dbh->prepare($sql);

	$this->getPDOError();



	if ($para == null) {
		$stmt->execute();
	}
	else {
		$stmt->execute($para);
	}	
	/*选择*/
	if (stripos($sql, 'select')===0) {
		$stmt->setFetchMode(PDO::FETCH_ASSOC);

		$rs = $stmt->fetchAll();

		$a['rs'] = $rs;
		$a['total'] = $this->foundRows();

		return $a;	
	}
	elseif (stripos($sql, 'delete')===0) {
		return $stmt->rowCount();	
	}


	//$this->dbh->exec($sql);   
	//$this->getPDOError();   
}   

/*检测数据表是否存在*/
public function mdbexist( $table ){
	try{
		$this->sth = $this->dbh->query('DESCRIBE '.$table);   
		return true;
	}
	catch(PDOException $e){
		return FALSE;
	} 
} // end func
   
/**  
 * 捕获PDO错误信息  
 */  
private function getPDOError()   
{   
	if ($this->dbh->errorCode() != '00000')   
	{   
		$error = $this->dbh->errorInfo();   
		exit($error[2]);   
	}   
}   
public function foundRows(){
 $rows = $this->dbh->prepare('SELECT found_rows() AS rows');
 $rows->execute();
 $rowsCount = $rows->fetch(PDO::FETCH_OBJ)->rows;
 $rows->closeCursor();
 return $rowsCount;
}    

//事务处理
public function begintrans(){
	$this->dbh->beginTransaction();
} // end func

public function submittrans(){
	$this->dbh->commit();
}

public function rollbacktrans(){
	$this->dbh->rollback();
}


//关闭数据连接   
public function __destruct(){   
	$this->dbh = null;   
}







}