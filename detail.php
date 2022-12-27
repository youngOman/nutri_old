<?php
//手機版頁面
include("include/cart.php");
$cart=new cart();
$weight=200;
if (isset($_GET['id'])) {
	$id=$_GET['id'];	
	$sql="SELECT * FROM `nutri` WHERE `id`='$id'";
	$temp=$cart->rundata($sql);
	//print_r($temp);
}
?>
<?php include("header1.php"); ?>	
<script>
 	$(document).ready(function() {
 		$("#btn").click(function(event) {
 			console.log("OK");
 			var id=$("#id").val();
 			var weight=$("#weight").val();
 			//console.log("id:"+id);
 			//console.log("weight:"+weight);
 		 	$.ajax({
 		 		url: 'ajax.php',
 		 		type: 'POST',
 		 		dataType:'json',
 		 		data: {
 		 			op:"weight",
 		 			id:id,
 		 			weight:weight
 		 		},success:function(rt){
 		 			console.log(rt);
 		 			for(var idx_Key in rt[0]){
 		 				$("#"+ idx_Key).html(rt[0][idx_Key]);//idx_key=n_...
 		 			}
 		 				$("#w").html(weight+"g");
 		 		}

 		 	});
 		
 		 	
 		});

 	});
</script>
<style>
/*table{
		background-color:#ccc;
}
table td{
		background-color:#fff;
}*/
.table-hover tr:hover td{
 	background-color:#ffb;
}
.table th{
	text-align:left;
	background-color:#bbb;
}
.table tr:nth-child(odd){
	background-color:#ccc;
}
.table tr:nth-child(even){
	background-color:#fff;
}
.table td,th{
	margin:0px;
	padding:0px;
}		
</style>
<?php include("header2.php"); ?>

<input type="button" value="上一頁" onclick="window.history.back();">
<!-- <p style="color:#f00;">*本資料庫所列數值單位均為每100 g可食部分之含量。</p> -->
<br>
請輸入重量:<input type="text" id="weight" value="<?php echo $weight; ?>"><input type="submit" value="送出" id="btn">
<input type="hidden" id="id" value="<?php echo $id; ?>">

<table class="table table-hover">
<?php
if (isset($_GET['id'])) {
	$sql="SELECT * FROM `fileds`";
	$tempfiled=$cart->rundata($sql);
	for ($i=0; $i <sizeof($tempfiled) ; $i++) { 
		echo "<tr>";
		echo "<td>".$tempfiled[$i]['filedName']."</td>";
		$Spanstr="";
		if ($tempfiled[$i]['id']<=4) $Spanstr="colspan='2'";	
		$alignstr=""; 
		if ($tempfiled[$i]['id']>=5) $alignstr="text-align:right;";
		echo "<td $Spanstr style='width:120px;$alignstr'>".$temp[0][$tempfiled[$i]['filed']]."</td>";
		if ($tempfiled[$i]['id']>=5) {
			if ($tempfiled[$i]['id']==86) {
				$arr=explode("/",$temp[0][$tempfiled[$i]['filed']]);
				echo "<td style='text-align:right;' id=".$tempfiled[$i]['filed'].">";
				for ($j=0; $j <sizeof($arr) ; $j++) { 
					echo $weight/100*$arr[$j];
					if ($j<sizeof($arr)-1) echo "/"; 
				}
                echo "</td>";
			
			}else{
				echo "<td style='width:120px;$alignstr' id=".$tempfiled[$i]['filed'].">".($weight/100*$temp[0][$tempfiled[$i]['filed']])."</td>";
			}
		}
		echo "</tr>";
		if ($tempfiled[$i]['id']==4) {
			echo "<tr><td></td><td>100g</td><td id='w'>".$weight."g</td></tr>";
		}

	}	
}
?>
</table>	
<?php include("footer.php"); ?>