<h2>Comments</h2>
<hr>
<?php
error_reporting(E_ALL);
$link = connect();
echo $_SESSION['ruser'];

echo '<form action="index.php?page=2" method="post">';
// создать селект для выбора страны
$res = mysqli_query($link, 'SELECT * FROM countries ORDER BY country DESC'); 
echo '<select name="countryname">';
while($row=mysqli_fetch_array($res, MYSQLI_NUM)){ 
    echo "<option value='$row[0]'>$row[1]</option>";
} 
mysqli_free_result($res);
echo '</select>'; 
echo '<input type="submit" name="showcity" value="Send" class="btn btn-sm ml-5 btn-info">';
echo '<br>';
echo '<br>';
if(isset($_POST['showcity'])){
    $countryid = $_POST['countryname'];
    $sel='SELECT * FROM cities WHERE countryid='.$countryid;
    $res = mysqli_query($link, $sel); 
    echo '<select name="cityname">';
        while($row=mysqli_fetch_array($res, MYSQLI_NUM)){
            echo "<option value='$row[0]'>$row[1]</option>"; 
        } 
    mysqli_free_result($res);
    echo '</select>';
    echo '<input type="submit" name="showhotels" value="Send" class="btn btn-sm ml-4 btn-info">';
}
//обработчик вывода отелей
if(isset($_POST['showhotels'])){
    $cityid = $_POST['cityname'];
    $sel='SELECT * FROM hotels WHERE cityid='.$cityid;
    $res = mysqli_query($link, $sel); 
    echo '<select name="hotelname">';
        while($row=mysqli_fetch_array($res, MYSQLI_NUM)){
            echo "<option value='$row[0]'>$row[1]</option>"; 
        } 
    mysqli_free_result($res);
    echo '</select>';
    echo '<br>';
    echo '<br><textarea name="comment" placeholder="Comment" class="m-2"></textarea>';
    echo '<input type="submit" name="sendcomment" value="Send" class="btn btn-sm ml-4 btn-info">';
}
//сбор комментариев
if(isset($_POST['sendcomment'])){
    $hotelid = $_POST['hotelname'];
    $sel = 'SELECT cityid FROM hotels WHERE id='.$hotelid;
    $res = mysqli_query($link, $sel);
    while($row = mysqli_fetch_array($res, MYSQLI_NUM)){
        $cityid = $row[0];
    }
    mysqli_free_result($res);
    $sel = 'SELECT countryid FROM hotels WHERE id='.$hotelid;
    $res = mysqli_query($link, $sel);
    while($row = mysqli_fetch_array($res, MYSQLI_NUM)){
        $countryid = $row[0];
    }
    mysqli_free_result($res);
    $comment = trim(htmlspecialchars($_POST['comment']));
    if($comment=="") exit;
    $ins="INSERT INTO comments(countryid,cityid,hotelid,comment) VALUES('$countryid','$cityid','$hotelid','$comment')";
    mysqli_query($link, $ins);
    
    $err=mysqli_error($link);
    if($err){
        echo "Error code $err <br>";
        exit;
    }
    echo '<script>window.location=document.URL</script>';
}
echo '</form>';
?>