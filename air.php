<?php include("include/cart.php") ?>
<?php include("include/header1.php") ?>
<?php include("include/header2.php") ?>

<?php
$url = "https://data.epa.gov.tw/api/v1/aqx_p_432?limit=1000&api_key=9be7b239-557b-4c10-9775-78cadfc555e9&format=json";
$ch = curl_init(); //建立連線
// curl_setopt ($ch,要使用的CURLOPT_***選項,CURLOPT_***的值)
$options = array(
	CURLOPT_URL => $url,
	CURLOPT_HEADER => false,
	CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 10.0; Win64; x64)",
	CURLOPT_RETURNTRANSFER => 1, // 有沒有回傳值
	// CURLOPT_VERBOSE=>0

);
curl_setopt_array($ch, $options);	

$result = curl_exec($ch);
curl_close($ch);
$json = json_decode($result, true);
// echo "<pre>";
// print_r($json);
// echo "</pre>";
$records = $json['records'];  //傳回值為1 
foreach ($records as $key => $value) { //$varieble=陣列的變數名稱 $key=索引[] $value=$key對應的值 =>
	$County[$value['County']] = $value['County'];
}
// print_r($County);
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>AQI</title>
	<style>
		.container.custom-container-width {
			max-width: 1010px;
			text-align: left;
			position: absolute;
			left: 0px;
		}
	</style>

</head>

<body>
	<form action="" method="get">
		<select name="County" onchange="submit();">
			<option value="all">全部</option>
			<?php
			foreach ($County as $key => $value) {
				$preselect = "";
				if ($key == $_GET['County']) $preselect = "selected";
				echo "<option value='$key' $preselect>$value</option>";
			}
			?>
		</select><input type="submit" value="查詢">
	</form>

	<table class="table table-hover">
		<div class="container custom-container-width">
			<div class="row">
				<div class="col-lg-12">
					<?php
					$fields = $json['fields']; //表頭
					echo "<tr>";
					foreach ($fields as $key => $value) { //$fields[$key]['info']['label']
						$data = $fields[$key]['id'];
						if ($data == "County" || $data == "Status" || $data == "AQI" || $data == "SiteName") {
							echo "<th>" . $fields[$key]['info']['label'] . "</th>";
						}
					}
					echo "</tr>";
					?>
					<div class="row">
						<div class="col-lg-12">

							<?php
							$records = $json['records'];
							foreach ($records as $key => $value) {
								// echo "<pre>";
								// print_r($value); //$value=陣列
								// echo "</pre>";
								if (!isset($_GET['County']) || $_GET['County'] == $value['County'] || $_GET['County'] == "all") {
									//if (condition) 只要顯示四個欄位
									echo "<tr>";
									foreach ($value as $k => $v) {
										// echo "<pre>";
										// print_r($v);
										// echo "</pre>";
										if ($k == "County" || $k == "Status" || $k == "AQI" || $k == "SiteName") {
											echo "<td>";
											echo $v;
											echo "</td>";
										}
									}

									echo "</tr>";
								}
							}
							?>
	</table>
	</div>
	</div>
	</div>
	<!--<div class="col-lg-12"> -->
	</div>
	<!--<div class="row"> -->
	</div>
	<!--<div class="container"> -->

</body>

</html>
<?php include("include/footer.php") ?>