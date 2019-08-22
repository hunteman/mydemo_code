<h2>
Leave your comment about the hotel please!</h2>
<hr>

<?php
error_reporting(E_ALL);
$link = connect();

echo '<form action="index.php?page=2" method="post">';
$sel = 'SELECT * FROM countries';
$res = mysqli_query($link, $sel);


// Создать селект для выбора страны
echo '<select name="countryid">';
while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
    echo "<option value='$row[0]'>$row[1]</option>";
}
mysqli_free_result($res);
echo '</select>';
echo '<input type="submit" name="selcountry" value="select country" class="btn btn-sm btn-secondary"><br>';
echo '<br>';
if(isset($_POST['selcountry'])) {
    $countryid = $_POST['countryid'];
//    if($countryid == 0) exit;
    $res = mysqli_query($link, "SELECT * FROM cities WHERE countryid=".$countryid);
    echo '<select name="cityid">';
    while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
        echo "<option value='$row[0]'>$row[1]</option>";
    }
    mysqli_free_result($res);
    echo '</select>';
    echo '<input type="submit" name="selcity" value="select city" class="btn btn-sm btn-secondary">';
}

if(isset($_POST['selcity'])) {
    $cityid = $_POST['cityid'];
    $res=mysqli_query($link, "SELECT * FROM hotels WHERE cityid=".$cityid);
    echo '<select name="hotelid">';
    while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
        echo "<option value='$row[0]'>$row[1]</option>";
    }
    mysqli_free_result($res);
    echo '</select>';
    echo '<br>';
    echo '<br>';
    echo '<textarea name="hotelComment" cols="50" rows="5" class="col-sm-6 col-md-6 col-lg-6 left"></textarea>';
    echo '<br>';
    echo '<input type="submit" name="comment" value="comment" class="btn btn-sm btn-secondary">';
}

//if(isset($_POST['selhotel'])) {
//    $hotelid = $_POST['hotelid'];
//    
//     $res=mysqli_query($link, "SELECT * FROM hotels WHERE cityid=".$cityid);
//
//    mysqli_free_result($res);
//
//}

if(isset($_POST['comment'])){
    $hotelid = $_POST['hotelid'];
    $comment= trim(htmlspecialchars($_POST['hotelComment']));     
    if($comment=="") exit;           
    $ins = "INSERT INTO comments(comment, hotelid) VALUES('$comment', '$hotelid')";
    mysqli_query($link,$ins);
    
    $err=mysqli_error($link);
    if($err) {
        echo "Error text: $err <br>";
        exit;
    }    
    echo '<script>window.location=document.URL</script>';
}
echo '</form>';
?>