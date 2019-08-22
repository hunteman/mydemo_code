<h2>Select tours</h2>
<hr>
<?php
error_reporting(E_ALL);
$link = connect();
echo $_SESSION['ruser'];

$sel = 'SELECT * FROM countries ORDER BY country';
$res = mysqli_query($link, $sel);

echo '<form action="index.php?page=1" method="post">';
// Создать селект для выбора страны
echo '<select name="countryid">';
while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
echo "<option value='$row[0]'>$row[1]</option>";
}
echo '</select>';
mysqli_free_result($res);
echo '<input type="submit" name="selcountry" value="select country" class="btn btn-sm btn-secondary"><br>';

// Селект для выбора города


if(isset($_POST['selcountry'])) {
    $countryid = $_POST['countryid'];
    if($countryid == 0) exit;
    $res = mysqli_query($link, "SELECT * FROM cities WHERE countryid=".$countryid);
    echo '<select name="cityid">';
    while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
        echo "<option value='$row[0]'>$row[1]</option>";
    }
    echo '</select>';
    echo '<input type="submit" name="selcity" value="select city" class="btn btn-sm btn-secondary">';
    mysqli_free_result($res);
}


echo '</form>';

// Обработчик вывода отелей
if(isset($_POST['selcity'])) {
    $cityid = $_POST['cityid'];
    $sel = 'SELECT co.country, ci.city, ho.hotel, ho.cost, ho.stars, ho.id FROM hotels ho, countries co, cities ci WHERE ho.countryid=co.id AND ho.cityid=ci.id AND ho.cityid='.$cityid;
    
//    $sel = 'SELECT co.country, ci.city, ho.hotel, ho.cost, ho.stars, ho.id FROM hotels ho, countries co, cities ci ';
    
    $res=mysqli_query($link, $sel);
    echo '<table class="table table-stripped tbtours text-center">';
    echo '<thead style="font-weight:bold;">
    <td>Hotel</td><td>Country</td><td>City</td><td>Price</td><td>Stars</td><td>Link</td></thead>';
        while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
            echo "<tr id='$row[1]'>";
            echo '<td>'.$row[2].'</td>
            <td>'.$row[0].'</td>
            <td>'.$row[1].'</td>
            <td>'.$row[3].'</td>
            <td>'.$row[4].'</td>
            <td><a href="pages/hotelinfo.php?hotel='.$row[5].'" target="_blank">more info</a></td>';

            echo '</tr>';
    }
    
    echo '</table>';
}

?>