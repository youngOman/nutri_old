<?php
include("include/cart.php");
error_reporting(E_ALL^E_NOTICE^E_WARNING);
$cart=new cart();
if (isset($_POST['op'])) {
	if ($_POST['op']=='add') {
		foreach ($_POST as $key => $value) {
			
			if ($key!="op"&&$key!="id"){
				if($str1) $str1.=",`".$key."`";
				else $str1="`".$key."`";
				if($str2) $str2.=",'".$value."'";
				else $str2="'".$value."'";				
			}
		}
		$sql="INSERT INTO `nutri` ($str1) VALUES ($str2)";
		//echo $sql;
		$cart->run($sql);
		echo mysqli_error($cart->link);	
		
	}
	if ($_POST['op']=='mod') {
		foreach ($_POST as $key => $value) {
			if ($key!='op'&&$key!='id') {
				if ($str1) $str1.=",`".$key."`='".$value."'";
				else $str1="`".$key."`='".$value."'";
			}
		}
	$id=$_POST['id'];
	$sql="UPDATE `nutri` SET $str1 WHERE `id`='$id'";	
	echo $sql;
	$cart->run($sql);
	}
	header("LOCATION:./");
}
$btnStr="新增";
$opStr="add";
if (isset($_GET['id'])) {
	$id=$_GET['id'];
	$sql="SELECT * FROM `nutri` WHERE `id`=$id";
	$tempdata=$cart->rundata($sql);
	$btnStr="修改";
	$opStr="mod";
}
?>
<?php include("header1.php"); ?>
<?php include("header2.php"); ?>
<div class="row">
	<div class="col-lg-6">		
<form action="" method="post">
<input type="submit" value="<?php echo $btnStr; ?>">
<table>
<?php
$sql="SELECT * FROM `fileds`";
$temp=$cart->rundata($sql);
for ($i=0; $i <sizeof($temp) ; $i++) { 
	echo "<tr><td>".$temp[$i]['filedName'];
	echo $temp[$i]['fileNmae'].":";
	if ($temp[$i]['id']==2) {
			$sql="SELECT * FROM `class`";
			$tempClass=$cart->rundata($sql);
			echo "<select name='".$temp[$i]['filed']."'>";
			for ($j=0; $j <sizeof($tempClass) ; $j++) { 
			echo "<option>".$tempClass[$j]['className']."</option>";
			}
			echo "</select>";
			
	}else {
		if ($tempdata[0][$temp[$i]['filed']]) $v=$tempdata[0][$temp[$i]['filed']];
		else{
			if ($temp[$i]['id']==1) {
				$sql="SELECT `n_num` FROM `nutri` WHERE `n_num` LIKE 'U%' ORDER BY `n_num` DESC";
				$tempNum=$cart->rundata($sql);
				if ($tempNum) {
					$v="U".sprintf("%05d",substr($tempNum[0]['n_num'],1 ,5)+1);

				}else $v="U00001";

			}else if ($temp[$i]['id']>=5) $v=0;
			else $v="";
		}
	echo "<input type='text' name='".$temp[$i]['filed']."' value='$v'>";
	}
	echo "</td></tr>";	
}
?>
</table>
<input type="hidden" name="id" value="<?php echo $id; ?>">
<input type="hidden" name="op" value="<?php echo $opStr; ?>">
<input type="submit" value="<?php echo $btnStr; ?>">
</form>	
</div><!--<div class="col-lg-6">-->
</div><!--<div class="row">-->
<?php include("footer.php"); ?>