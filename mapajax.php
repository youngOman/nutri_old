<?php include("include/cart.php") ?>
<?php include("include/header1.php") ?>
<!-- 若要使用ajax要先載jquery外掛-->
<script>
	$(document).ready(function() {
		checkgym();
	});

	function checkgym() {
		var gym_name = $("#gym_name").val();
		var fastp = $("#fastp").val(); //val() 擷取輸入的值
		var str = "";
		console.log(fastp);
		$.ajax({
				url: 'ajax.php',
				type: 'POST',
				dataType: 'json',
				data: {
					op: 'listGym',
					gym_name: gym_name,
					fastp: fastp
				},
			})
			.done(function(rt) {
				console.log(rt);
				if (rt) { //從ajax.php擷取到的資料
					str += "<table class='table table-hover'>";
					str += "<tr><th>健身房名稱</th><th>健身房電話</th><th>健身房地址</th><th>營業時間</th></tr>";
					for (var i = 0; i < rt.length; i++) {
						str += "<tr><td>" + rt[i]['gym_name'] + "</td>";
						str += "<td>" + rt[i]['gym_tel'] + "</td>"
						str += "<td>" + rt[i]['gym_address'] + "</td>"
						str += "<td>" + rt[i]['opentime'] + "</td>"
						str += "</tr>"
					}
					str += "</table>";
					$("#gymlist").html(str);
				}
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
	}
</script>
<?php include("include/header2.php"); ?>
<select id="gym_name" onchange="checkgym();">
	<option value="all">全部</option>
	<?php
	$sql = "SELECT `gym_name` FROM `gym`";
	$temp = $cart->rundata($sql);
	foreach ($temp as $key => $value) { //value=[];
		foreach ($value as $k => $v) {
			$selectstr = ""; // 不預設會選自己selected之後的
			if ($gym == $v) {
				$selectstr = "selected";
			}
			echo "<option $selectstr>$v</option>";
		}
	}
	?>
</select>
請輸入關鍵字:<input type="text" id="fastp" onkeydown="checkgym();"><input type="button" value="查詢" onclick="checkgym();">
<div id="gymlist">

</div>

<?php include("include/footer.php") ?>