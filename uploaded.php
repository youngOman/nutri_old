<?php include("include/cart.php"); ?>
<?php
// 若要上傳到nas需先改權限
if ($_FILES['pic']) { //input['name']
	print_r($_FILES['pic']);
	$fileName=date("Ymd")."-".rand(1000,9999);
	$ext=strtolower(end(explode(".",$_FILES['pic']['name']))); //副檔名 strtolower強制將副檔名改成小寫,end取陣列中最後一位,explode字串切割
	if ($ext=='jpg'||$ext=='png') {
		$fileName=$fileName.".".$ext;
		if(move_uploaded_file($_FILES['pic']['tmp_name'], "picfile/".$fileName)){
			// echo "OK";
		}
	}
	
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>照片上傳區</title>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data"> <!--要上傳檔案需用enctype-->
	<input type="file" name="pic">
	<input type="submit" value="上傳">
</form>

</body>
</html>