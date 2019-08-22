<?php
include_once("../pages/functions.php");
$link = connect();
$cid = $_POST['cid'];


    $sel = 'SELECT co.country, ci.city, ho.hotel, ho.cost, ho.stars, ho.id FROM hotels ho, countries co, cities ci WHERE ho.countryid=co.id AND ho.cityid=ci.id AND ho.cityid='.$cid;
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