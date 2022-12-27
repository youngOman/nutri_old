<?php
/*===========================================================================*/
/*      Taiwan Food Nutrition Information Database Query System
        v2.0 [May 23, 2020]
        Copyright (C)2019 by butyshop inc. and LO YANG - mis@butyshop.com

        This code is hereby released into the public domain.
        Free to use or revise but don't make money with it.                  */
/*===========================================================================*/
//-----------------------------------------------------------------------------
// Startup code
//-----------------------------------------------------------------------------
include("include/cart.php");
$cart = new cart();
session_start();
if (isset($_GET['op']) && $_GET['op'] == 'delete') {
	$id = $_GET['id'];
	$sql = "DELETE FROM `nutri` WHERE `id`=$id";
	$cart->rundata($sql);
	header("LOCATION:./");
}
if (isset($_GET['pass'])) {
	if ($_GET['pass'] == "young") $_SESSION['user'] = $_GET['pass'];
}
if (isset($_GET['logout']) && $_GET['logout'] == 1) unset($_SESSION['user']);
?>
<?php include("include/header1.php"); ?>
<script>
	$(document).ready(function() {
		$("input[name='p']").focus(); //input type<請輸入關鍵字> focus頁面進入時焦點即是搜尋框
		//pdlist('n_crude_protein','粗蛋白(g)');
		$("#descShow").click(function(event) { //顯示內容物描述
			if ($("#descShow:checked").val()) {
				$(".descTd").show();
			} else $(".descTd").hide();
		});
	});

	function pdlist(filed, fname) {
		$("#loadingImg").show();
		var classID = $("select[name='class']").val();
		var p = $("input[name='p']").val();
		var page = $("input[name='page']").val();
		var orderbyOp = $("input[name='orderbyOp']").val();
		if (filed) $("input[name='filed']").val(filed);
		else filed = $("input[name='filed']").val();
		if (fname) $("input[name='fname']").val(fname);
		else fname = $("input[name='fname']").val();
		console.log(classID);
		$.ajax({
				url: 'ajax.php',
				type: 'POST',
				dataType: 'JSON',
				data: {
					op: 'pdlist',
					p: p,
					classID: classID,
					page: page,
					orderbyOp: orderbyOp,
					filed: filed
				},
			})
			.done(function(rt) {
				console.log(rt);
				var str = "";
				if (rt) {
					str += '<table class="table table-hover">';
					str += '<tr><th>食品分類</th><th>食品名稱</th><th id="filedth">' + fname;
					if (orderbyOp == "ASC") str += " <a href='javascript:void(0);' onclick='orderby(0);'>遞減∇</a>";
					else str += " <a href='javascript:void(0);' onclick='orderby(1);'>∆遞增</a>";
					str += '</th><th class="descTd">內容物描述</th>';
					<?php if (isset($_SESSION['user'])) { ?>
						str += '<th class="descTd">修改</th><th class="descTd">刪除</th></tr>';
					<?php } ?>
					for (var i = 0; i < rt.length; i++) {
						str += "<tr>";
						str += "<td class='tr" + rt[i]['id'] + "'>" + rt[i]["n_class"] + "</td>";
						str += "<td class='tr" + rt[i]['id'] + "'><a href='javascript:void(0);' onclick='pdDetail(" + rt[i]['id'] + ")'>" + rt[i]["n_name"] + "</a></td>";
						str += "<td class='tr" + rt[i]['id'] + "'>" + rt[i][filed] + "</td>";
						str += "<td class='descTd tr" + rt[i]['id'] + "'>" + rt[i]["n_desc"] + "</td>";
						<?php if (isset($_SESSION['user'])) { ?>
							str += "<td style='text-align:center;' class=\"descTd tr" + rt[i]['id'] + "\"><a href='add.php?id=" + rt[i]['id'] + "'><img src='images/1.png' style='width:16px;'></a></td>";
							str += "<td style='text-align:center;' class=\"descTd tr" + rt[i]['id'] + "\"><a href='javascript:void(0);' onclick=\"if(confirm('確定刪除?')) window.location='./?op=delete&id=" + rt[i]['id'] + "';\"  style='color:#f00;'><i class=\"fas fa-trash-alt fa-1x\"></i></a></td>";
						<?php } ?>
						str += "</tr>";

						/*str+="<tr><td></td><td></td><td colspan='3'>";
						str+=rt[i]['desc'];
						str+="</td></tr>";*/
					}
					str += "</table>";

				}
				//$("#filedth").html(fname);
				$("#pdlist").html(str);
				$("#loadingImg").hide();
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
	}

	function btnClick(f, fname) {
		$("input[name='f']").val(f);
		$("inpuy[name='fname']").val(fname);
		$("#form1").submit();
	}

	function orderby(op) {
		if (op == 1) $("input[name='orderbyOp']").val("ASC");
		else $("input[name='orderbyOp']").val("DESC");
		pdlist();
	}

	function pdDetail(id) {
		$("#loadingImg").show();
		var sUserAgent = navigator.userAgent.toLowerCase();
		var bIsIpad = sUserAgent.match(/ipad/i) == "ipad";
		var bIsIphoneOs = sUserAgent.match(/iphone os/i) == "iphone os";
		var bIsMidp = sUserAgent.match(/midp/i) == "midp";
		var bIsUc7 = sUserAgent.match(/rv:1.2.3.4/i) == "rv:1.2.3.4";
		var bIsUc = sUserAgent.match(/ucweb/i) == "ucweb";
		var bIsAndroid = sUserAgent.match(/android/i) == "android";
		var bIsCE = sUserAgent.match(/windows ce/i) == "windows ce";
		var bIsWM = sUserAgent.match(/windows mobile/i) == "windows mobile";
		if (bIsIpad || bIsIphoneOs || bIsMidp || bIsUc7 || bIsUc || bIsAndroid || bIsCE || bIsWM) {
			window.location.href = "detail.php?id=" + id; //手機版，用連結到detail.php?id=
		} else { //電腦版顯示在右邊
			if ($("#weight").val()) var weight = $("#weight").val();
			else var weight = 200;
			$.ajax({
					url: 'ajax.php',
					type: 'post',
					dataType: 'html',
					data: {
						op: 'pdDetail',
						id: id,
						weight: weight
					},
				})
				.done(function(rt) {
					console.log(rt);
					str = "請輸入重量：<input type=\"text\" id=\"weight\" value=\"" + weight + "\"><input type=\"button\" value=\"送出\" id=\"btn\" onclick='pdDetail(" + id + ")'><br>" + rt;
					$("#pdDetail").html(str);
					oid = $("input[name='oid']").val();
					$(".tr" + oid).removeClass('trcolor');
					$(".tr" + id).addClass("trcolor");
					$("input[name='oid']").val(id);
					$("#loadingImg").hide();
				})
				.fail(function() {
					console.log("error");
				})
				.always(function() {
					console.log("complete");
				});
		}

	}

	function checkPass() {
		if (pass = prompt("請輸入密碼")) window.location = "./?pass=" + pass;
	}

	function changeFiled() {
		var filed = $("#filed_t").val();
		var fname = $("#filed_t").find(':selected').text();
		console.log(filed);
		console.log(fname);
		pdlist(filed, fname);

	}
</script>
<style>
	.table th {
		text-align: left;
		background-color: #bbb;
	}

	.table tr:nth-child(odd) {
		background-color: #ccc;
	}

	.table tr:nth-child(even) {
		background-color: #fff;
	}

	.table-hover tr:hover td {
		background-color: #ffb;
	}

	.descTd {
		display: none;
	}

	.table td,
	th {
		margin: 0px;
		padding: 0px;
	}

	.trcolor {
		background-color: #ffb;
	}

	#loadingImg {
		position: absolute;
		top: 50%;
		left: 50%;
		display: none;
		margin: -100px 0 0 -100px;
	}
</style>
<?php include("include/header2.php"); ?>

<div class="row">
	<div class="col-lg-12">
		<?php if (isset($_SESSION['user'])) {
			echo '<input type="button" value="新增" onclick="window.location=\'add.php\';">';
			echo ' <input type="button" value="登出" onclick="window.location=\'./?logout=1\';">';
		} else echo '<input type="button" value="登入管理" onclick="checkPass();">';
		?>

		<div style="border:#ffac55 1px dashed; padding:5px; ">
			<p style="margin:0px; padding:0px;">[常用營養成分排行]
				<?php
				$sql = "SELECT * FROM `fileds` WHERE `id`>=5 ";
				$temp = $cart->rundata($sql);
				echo "<select id='filed_t' onchange='changeFiled();' style='width:200px;'>";
				echo "<option>請選擇</option>";
				for ($i = 0; $i < sizeof($temp); $i++) {
					echo "<option value='" . $temp[$i]['filed'] . "'>" . $temp[$i]['filedName'] . "</option>";
				}
				echo "</select>";
				?>
			</p>
			<?php
			//$sql="SHOW FULL COLUMNS FROM `nutri`";
			$sql = "SELECT * FROM `fileds` WHERE `orderby`>2 ORDER BY `orderby` DESC";
			$temp = $cart->rundata($sql);
			//print_r($temp);
			for ($i = 0; $i < sizeof($temp); $i++) {
				$qstr = "&" . $_SERVER['QUERY_STRING']; //取得網址?後面的值
				echo "<input type='button' value='" . $temp[$i]['filedName'] . "'";
				echo "onclick=\"pdlist('" . $temp[$i]['filed'] . "','" . $temp[$i]['filedName'] . "')\"style='width:110px;'> ";
			}
			?>
		</div>
		<?php
		if (isset($_GET['p'])) {
			$p = $_GET['p'];
			$class = $_GET['class'];
			if ($class != "all") $str = "AND `n_class`='$class'";

			$whereStr = "WHERE (`n_name` LIKE '%$p%' OR `n_desc` LIKE '%$p%') $str";
		}
		?>
		<!--<form action="" method="get" id="form1">-->
		<input type="hidden" name="filed" value="n_crude_protein">
		<input type="hidden" name="fname" value="粗蛋白(g)">
		<input type="hidden" name="orderbyOp" value="DESC">
		<input type="hidden" name="oid" value="">

		<select name="class" onchange="pdlist(); ">
			<option value="all">全部</option>
			<?php
			$sql = "SELECT * FROM `class`";
			$tempClass = $cart->rundata($sql);
			for ($i = 0; $i < sizeof($tempClass); $i++) {
				echo "<option";
				if ($tempClass[$i]['className'] == $class) echo " selected";

				echo ">" . $tempClass[$i]['className'] . "</option>";
			}
			?>
		</select>

		請輸入關鍵字:<input type="text" name="p" onkeyup="pdlist(); " onchange="pdlist(); "><input type="submit" value="查詢" onclick="pdlist(); "> <span style="color:#999;">請輸入關鍵字,例如:蛋，乳清....</span>
		<!--<input type="button" value="上一頁" onclick="preF();" disabled="disabled" id="prebtn">-->
		<!--<input type="button" value="下一頁"  onclick="nextF(); " id="nextbtn">-->
		<!--<input type="hidden" name="fname" value="<?php echo $_GET['fname']; ?>">-->
		<!--<input type="hidden" name="f" value="<?php echo $_GET['f']; ?>">-->
		<label><input type="checkbox" id="descShow">顯示內容物描述</label>
		<!--</form>-->
	</div>
	<!--<div class="col-lg-12">-->
</div>
<!--<div class="row">-->
<div class="row">
	<div class="col-md-12 col-lg-8">
		<div id="pdlist">

		</div>
	</div>
	<!--<div class="col-lg-8">-->
	<div class="col-md-12 col-lg-4">
		<div id="pdDetail">

		</div>
	</div>
	<!--<div class="col-lg-4">-->
</div>
<!--<div class="row">-->
<?php include("include/footer.php"); ?>
<div id="loadingImg">
	<img src="images/loading.gif">
</div>