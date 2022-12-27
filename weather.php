<?php include("include/cart.php") ?>
<?php include("include/header1.php") ?>
<?php include("include/header2.php") ?>

<?php
// $url="https://opendata.cwb.gov.tw/fileapi/v1/opendataapi/F-C0032-005?Authorization=CWB-FC46C72A-2F64-4246-A696-5592612B9537&downloadType=WEB&format=JSON";
$url= "https://opendata.cwb.gov.tw/fileapi/v1/opendataapi/F-C0032-017?Authorization=CWB-6C8B5554-105B-4709-8182-8A51CF70782B&downloadType=WEB&format=JSON";
$ch=curl_init();//建立連線
// curl_setopt ($ch,要使用的CURLOPT_***選項,CURLOPT_***的值)
$options=array(
	CURLOPT_URL=>$url,
	CURLOPT_HEADER=>false,
	CURLOPT_USERAGENT=>"Mozilla/5.0 (Windows NT 10.0; Win64; x64)",
	CURLOPT_RETURNTRANSFER=>1, // 有沒有回傳值
	// CURLOPT_VERBOSE=>0
);
curl_setopt_array($ch, $options);

$result=curl_exec($ch);
echo $result;
curl_close($ch);
$json=json_decode($result); //若有true的話是回傳陣列 $json=array[0]
echo $json;
?>
<table class="table table-hover">
<div class="container">
	<div class="row">
		<div class="col-lg-12">
		
<?php
echo "<pre>";
print_r($json);
echo "</pre>";
// echo $json[0]['cwbopendata']=>;
$data=$json->cwbopendata->dataset->location;
echo "<h1 style='text-align:left;'>高雄本週天氣概況</h1>";
echo "Hello?123";
foreach ($data as $key => $value) {
	if ($value->locationName=='高雄市') { 
		echo "<tr><th>測量時間範圍</th><th>天氣狀況</th><th>最高溫</th><th>最低溫</th></tr>";
		foreach ($value->weatherElement[0]->time as $k => $v) {
			echo "<tr>";
			echo "<td>".$v->startTime."</td>"; 
			echo "<td>".$v->parameter->parameterName."-</td>";
			echo "<td>最高溫度:".$value->weatherElement[1]->time[$k]->parameter->parameterName.$value->weatherElement[1]->time[$k]->parameter->parameterUnit."</td>";
			echo "<td>最低溫度:".$value->weatherElement[2]->time[$k]->parameter->parameterName.$value->weatherElement[1]->time[$k]->parameter->parameterUnit."</td>";
			$img=sprintf("%02d",$v->parameter->parameterValue); //圖片格式01.svg
			echo "<td><img src='https://www.cwb.gov.tw/V8/assets/img/weather_icons/weathers/svg_icon/day/$img.svg'></td>";
			echo "</tr>";
		}
		// echo $value->locationName->weatherElement[0]->time."-".$v1->parameter->parameterName;
		// echo $value->weatherElement[0]->elementName;
		// echo $value->weatherElement[1]->elementName;
		// echo $value->weatherElement[2]->elementName;
	}
}	
?>		
		
		</div>
	</div>
</div>
</table>
<?php include("include/footer.php") ?>
