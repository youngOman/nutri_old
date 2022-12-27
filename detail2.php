<?php
include("include/cart.php");
$cart = new cart();
if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$weight = 100;
	if (isset($_GET['weight'])) $weight = $_GET['weight'];
	$sql = "SELECT * FROM `nutri` WHERE `id`='$id'";
	$temp = $cart->rundata($sql);
	//print_r($temp);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title><?php echo $temp[0]['n_name']; ?></title>
	<style>
		table {
			background-color: #ccc;
		}

		table td {
			background-color: #fff;
		}
	</style>
</head>

<body>
	<input type="button" value="上一頁" onclick="window.history.back();">
	<p style="color:#f00;">*本資料庫所列數值單位均為每100 g可食部分之含量。</p>
	<form action method="get">
		請輸入重量:<input type="text" name="weight" value="<?php echo $weight; ?>"><input type="submit" value="送出">
		<input type="hidden" name="id" value="<?php echo $id; ?>">
	</form>
	<table>
		<?php
		if (isset($_GET['id'])) {
			$sql = "SELECT * FROM `fileds`";
			$tempfiled = $cart->rundata($sql);
			for ($i = 0; $i < sizeof($tempfiled); $i++) {
				echo "<tr>";
				echo "<td>" . $tempfiled[$i]['filedName'] . "</td>";
				$Spanstr = "";
				if ($tempfiled[$i]['id'] <= 4) $Spanstr = "colspan='2'";
				$alignstr = "";
				if ($tempfiled[$i]['id'] >= 5) $alignstr = "text-align:right;";
				echo "<td $Spanstr style='width:120px;$alignstr'>" . $temp[0][$tempfiled[$i]['filed']] . "</td>";

				if ($tempfiled[$i]['id'] >= 5) {
					if ($tempfiled[$i]['id'] == 86) {
						$arr = explode("/", $temp[0][$tempfiled[$i]['filed']]);
						echo "<td style='text-align:right;' id='" . $tempfiled[$i]['filed'] . "'>";
						for ($j = 0; $j < sizeof($arr); $j++) {
							echo $weight / 100 * $arr[$j];
							if ($j < sizeof($arr) - 1) echo "/";
						}
						echo "</td>";
					} else {
						echo "<td style='width:120px;$alignstr'>" . ($weight / 100 * $temp[0][$tempfiled[$i]['filed']]) . "</td>";
					}
				}
				echo "</tr>";
				if ($tempfiled[$i]['id'] == 4) {
					echo "<tr><td></td><td>100g</td><td>" . $weight . "g</td></tr>";
				}
			}
		}
		?>
	</table>
</body>

</html>