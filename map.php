<?php include("include/cart.php") ?>
<?php include("include/header1.php") ?>
<?php include("include/header2.php");
if (isset($_GET['gym_name'])) {
	$gym = $_GET['gym_name'];
	$sqlstr = "WHERE `gym_name`='$gym'"; //判斷get值跟sql的是否一樣
}
?>

<form action="" method="get">
	<select name="gym_name" onchange="submit();">
		<option value="all">全部</option>
		<?php
		$sql = "SELECT `gym_name` FROM `gym`";
		$temp = $cart->rundata($sql);
		foreach ($temp as $key => $value) { //value=[];
			foreach ($value as $k => $v) {
				$selectstr = ""; //不預設會選 selected之後的
				if ($gym == $v) {
					$selectstr = "selected";
				}
				echo "<option $selectstr>$v</option>";
			}
		}
		?>
	</select><input type="submit" value="查詢">

	請輸入關鍵字:<input type="text" name="fastp" onchange=""><input type="submit" value="查詢">
</form>

<table class="table table-hover">
	<tr>
		<th>名稱</th>
		<th>電話</th>
		<th>地址</th>
		<th>營業時間</th>
	</tr>
	<?php
	$sql = "SELECT * FROM `gym` $sqlstr ORDER BY `id` ";
	$temp = $cart->rundata($sql);
	for ($i = 0; $i < sizeof($temp); $i++) {
		echo "<tr>";
		echo "<td>" . $temp[$i]['gym_name'] . "</td>";
		echo "<td>" . $temp[$i]['gym_tel'] . "</td>";
		echo "<td>" . $temp[$i]['gym_address'] . "</td>";
		echo "<td>" . $temp[$i]['opentime'] . "</td>";
		echo "</tr>";
	}
	?>
</table>
<?php include("include/footer.php") ?>