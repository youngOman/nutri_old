<?php
include("include/cart.php");
// $cart=new cart();	
if ($_POST['op'] == "weight") {
	if (isset($_POST['id'])) {
		$id = $_POST['id'];
		$weight = $_POST['weight'];
		$sql = "SELECT * FROM `nutri` WHERE `id`=$id";
		$temp = $cart->rundata($sql);
		$i = 0;
		foreach ($temp[0] as $key => $value) {
			$i++;
			if ($i >= 6) {
				//echo $temp[0][$key]."<br>";
				if ($i == 87) {
					$arr = explode("/", $temp[0][$key]);
					$temp[0][$key] = "";
					$temp['arr'] = $arr;
					for ($j = 0; $j < sizeof($arr); $j++) {
						$temp[0][$key] .= $weight / 100 * $arr[$j];
						if ($j < (sizeof($arr) - 1)) $temp[0][$key] .= "/";
					}
				} else $temp[0][$key] = $temp[0][$key] * $weight / 100;
			}
		}
		echo json_encode($temp);
	}
	exit();
}
if ($_POST['op'] == "pdlist") {
	$classID = $_POST['classID'];
	$p = $_POST['p'];
	$classStr = "";
	$orderbyOp = $_POST['orderbyOp'];
	$filed = $_POST['filed'];
	/*$page=$_POST['page'];
	$row=100;
	$start=$page*$row;
	$Limit="LIMIT $start,$row";*/
	if ($classID != "all") $classStr = "AND `n_class`='$classID'";
	$sql = "SELECT * FROM `nutri` WHERE `n_name` LIKE '%$p%' $classStr ORDER BY `$filed` $orderbyOp";
	$temp = $cart->rundata($sql);
	/*$sql="SELECT * FROM `filed`";;
	$tempF=$cart->rundata($sql);
	for ($i=0; $i <sizeof($temp); $i++) { 
		$str="<table>";
		for ($j=0; $j <sizeof($tempF) ; $j++) { 
			if ($j>=6) {
				$str.="<tr>";
				$str.="<td>".$tempF[$j]['filedName']."</td><td>";
				$str.="</tr>";
			}
		}
	}$str.="</talbe>";*/
	echo json_encode($temp);
	exit();
}
if ($_POST['op'] == "pdDetail") {
	$id = $_POST['id'];
	$weight = $_POST['weight'];
	$sql = "SELECT * FROM `nutri` WHERE `id`='$id'";
	//echo $sql."<br>";
	$temp = $cart->rundata($sql);
	$sql = "SELECT * FROM `fileds`";
	$tempFiled = $cart->rundata($sql);
	$str = "<span style=\"color:#f00;\"></span>";
	$str .= "<table class='table'>";
	for ($i = 0; $i < sizeof($tempFiled); $i++) {
		$str .= "<tr>";
		$str .= "<td>" . $tempFiled[$i]['filedName'] . "</td>";
		$spanStr = "";
		if ($tempFiled[$i]['id'] <= 4) $spanStr = "colspan='2'"; //食品編號及分類
		$alignStr = "";
		if ($tempFiled[$i]['id'] >= 5) $alignStr = "text-align:right;"; // 
		$str .= "<td $spanStr style='width:120px;$alignStr'>" . $temp[0][$tempFiled[$i]['filed']] . "</td>";
		if ($tempFiled[$i]['id'] >= 5) {
			if ($tempFiled[$i]['id'] == 86) { //PMS格式為1.88/2.67/1.00	
				$arr = explode("/", $temp[0][$tempFiled[$i]['filed']]);
				$str .= "<td style='text-align:right;' id='" . $tempFiled[$i]['filed'] . "'>";
				for ($j = 0; $j < sizeof($arr); $j++) {
					$str .= $weight / 100 * (int)$arr[$j];
					if ($j < (sizeof($arr) - 1)) $str .= "/";
				}
				$str .= "</td>";
			} else {
				$str .= "<td style='width:120px;text-align:right;' id='" . $tempFiled[$i]['filed'] . "'>" . ($weight / 100 * $temp[0][$tempFiled[$i]['filed']]) . "</td>";
			}
		}
		$str .= "</tr>";
		if ($tempFiled[$i]['id'] == 4) {
			$str .= "<tr>";
			$str .= "<td></td><td style='text-align:right;'>100g</td>";
			//echo "<td>$weight g</td>";
			$str .= "<td style='text-align:right;' id='w'>" . $weight . "g</td>";
			$str .= "</tr>";
		}
	}
	$str .= "</table>";
	echo $str;
	exit();
}
if ($_POST['op'] == "listGym") {
	$gym_name = $_POST['gym_name'];
	$fastp = $_POST['fastp'];
	if ($gym_name != "all") {
		$sqlstr = " WHERE `gym_name`='$gym_name'"; //下拉式搜尋
	}
	if ($fastp != "") {
		$sqlstr = "WHERE `gym_name` LIKE '%$fastp%'"; //關鍵字搜尋
	}
	$sql = "SELECT * FROM `gym` $sqlstr ORDER BY `id`";
	$temp = $cart->rundata($sql);
	// $temp['error']=mysqli_error($cart->link); //若用echo偵錯dataType要改html
	// $temp['gym_name']=$gym_name;
	// $temp['fastp']=$fastp;
	//$temp['sql']=$sql;
	echo json_encode($temp);
}
