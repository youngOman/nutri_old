<?php include("include/cart.php") ?>
<?php include("include/header1.php") ?>
<?php include("include/header2.php") ?>

<div class="form-group">
  <form action="" method="get" name="form1">
    <label for="exampleFormControlInput1"></label>
    <h1>BMI計算</h1>
    身高：<input type="number" class="form-control" id="exampleFormControlInput1" placeholder=".....cm" name="cm" required="required" value="<?php echo $_GET['cm'] ?>">
    體重：<input type="number" class="form-control" id="exampleFormControlInput1" placeholder=".....kg" name="kg" required="required" value="<?php echo $_GET['kg'] ?>"><br>
    <button type="button" class="btn btn-primary" onclick="form1.submit();">計算</button>
    <!--代替input="submit"-->
    <?php
    if (isset($_GET['cm'])) {
      $cm = $_GET['cm'];
      $kg = $_GET['kg'];
      $BMI = round(($kg / ($cm * $cm)) * 10000, 1); //四捨五入 
      echo '<h2><br>BMI為' . $BMI . "</h2>";
    }
    ?>
  </form>
</div>
<div class="form-group">
  <form action="" method="get" name="form2">
    <h1>TDEE熱量計算機與BMR基礎代謝計算機</h1>
    年齡：<input type="text" class="form-control" id="exampleFormControlInput1" placeholder="18" name="age" required="required" value="<?php echo $_GET['age']; ?>">
    身高：<input type="text" class="form-control" id="exampleFormControlInput1" placeholder=".....cm" name="height" required="required" value="<?php echo $_GET['height']; ?>">
    體重：<input type="text" class="form-control" id="exampleFormControlInput1" placeholder=".....kg" name="weight" required="required" value="<?php echo $_GET['weight']; ?>">

    <label for="exampleFormControlSelect2">性別</label>
    <select class="form-control" id="exampleFormControlSelect2" name="sex">
      <?php
      $sexarray = array("male" => "男性", "female" => "女性");
      foreach ($sexarray as $key => $value) {
        $selectstr = "";
        if ($key == $_GET['sex']) $selectstr = "selected";
        echo "<option value='$key'>$value</option>";
      }
      ?>
    </select>
</div>

<div class="form-group">
  <label for="exampleFormControlSelect1">日常活動等級</label>
  <select class="form-control" id="exampleFormControlSelect1" name="act">
    <?php
    $actarr = array(1 => "完全沒在動..", 2 => "一週運動1~3天", 3 => "一週運動3~5天", 4 => "一週運動6~7天", 5 => "永動機"); //$key=option value 
    foreach ($actarr as $key => $value) {
      $selectstr = "";
      if ($key == $_GET['act']) $selectstr = "selected"; //用if判斷式才能先預設不要select任何option
      echo "<option value='$key' $selectstr>$value</option>";
    }
    ?>
  </select><br>
  </form>
  <button type="button" class="btn btn-primary" onclick="form2.submit();">計算</button><br>
  <?php
  if (isset($_GET['sex']) && $_GET['sex'] == 'female') { //女生的BMR
    $age = $_GET['age'];
    $cm = $_GET['height'];
    $kg = $_GET['weight'];
    $BMR = round((655 + (9.6 * $kg) + (1.8 * $cm) - (4.7 * $age)), 1);
    echo "<h3>您的BMR為:" . $BMR . "</h3><br>";
  } else if (isset($_GET['sex']) && $_GET['sex'] == 'male') { //男生的BMR
    $age = $_GET['age'];
    $cm = $_GET['height'];
    $kg = $_GET['weight'];
    $BMR = round((66 + (13.7 * $kg) + (5 * $cm) - (6.8 * $age)), 1);
    echo "<h3>您的BMR為:" . $BMR . "</h3><br>";
  }
  $selectOp = $_GET['act'];
  $TDEE = "";
  if ($selectOp == "1") {
    $TDEE = $BMR * 1.2;
  } elseif ($selectOp == "2") {
    $TDEE = $BMR * 1.375;
  } elseif ($selectOp == "3") {
    $TDEE = $BMR * 1.55;
  } elseif ($selectOp == "4") {
    $TDEE = $BMR * 1.725;
  } elseif ($selectOp == "5") {
    $TDEE = $BMR * 1.9;
  }
  if (isset($_GET['act'])) echo "<h3>TDEE=" . $TDEE . "</h3>"; //有選才顯示TDEE
  ?>
</div>
<!--<div class="form-group">
    <label for="exampleFormControlTextarea1">Example textarea</label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
  </div> -->
<!--BMR
男性  66 + （13.7 × 體重（kg） + 5 × 身高（公分） - 6.8 × 年齡）
女性  655 + （9.6 × 體重（kg） + 1.8 × 身高（公分） - 4.7 × 年齡）
TDEE=BMR*1.2
TDEE=BMR*1.375
TDEE=BMR*1.55
TDEE=BMR*1.725
TDEE=BMR*1.9 -->
<?php include("include/footer.php") ?>