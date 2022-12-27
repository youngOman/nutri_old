<?php
error_reporting(E_ALL^E_NOTICE^E_WARNING);
class cart{
	var $link;
	function __construct(){ //建構式
		include("db.php");
		session_start();
		$this->link=mysqli_connect($url,$username,$password,$database);
		//echo mysqli_error($this->$link);
		//if ($this->link) echo "成功";
		//else echo "失敗";
	}
	function __destruct(){ //解構式
		mysqli_close($this->link);
	}
	function rundata($sql){ //查詢
			$res=mysqli_query($this->link,$sql);
			while ($rec=mysqli_fetch_assoc($res)) {
				$data[]=$rec;
			}
			return $data;
	}	
	function run($sql){ //新增，修改，刪除
		mysqli_query($this->link,$sql);
	}
}
$cart=new cart();

?>