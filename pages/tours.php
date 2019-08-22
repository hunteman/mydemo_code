<h2>Select Tours</h2>
<hr>


<?php
error_reporting(E_ALL);
$link = connect();

echo '<div class="form-inline">';
echo '<select name="countryid" id="countryid" onchange="showCities(this.value)">';
echo '<option value="0">select country</option>';
$res=mysqli_query($link, 'SELECT * FROM countries');
while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
echo "<option value='$row[0]'>$row[1]</option>";
}
echo '</select>';

// выпадающий список для городов
echo '<select name="cityid" id="citylist" onchange="showHotels(this.value)"></select>';
echo '</div>';

// блок для вывода отелей
echo '<div id="h"></div>';

// за пределами скрипта будут JS функции

?>


<script>
    function showCities(countryid) {
        if(countryid=="0") {
            document.getElementById('citylist').innerHTML="";
        }
        
        // создание Ajax объекта
        if(window.XMLHttpRequest) {
            ao=new XMLHttpRequest();
        } else {
            ao=new ActiveXObject('Microsoft.XMLHTTP');

        }
        
        // создадим callback
        ao.onreadystatechange = function() {
            if(ao.readyState == 4 && ao.status == 200) {
                document.getElementById('citylist').innerHTML = ao.responseText;
            }
        }
        
        // создать запрос обработчику
        ao.open('GET', "handlers/ajax1.php?cid="+countryid, true);
        ao.send(null);
    }
    
    function showHotels (cityid) {
        var h = document.getElementById("h");
        if(cityid=="0") {
            h.innerHTML = "";
        }
        
        // создание Ajax объекта
        if(window.XMLHttpRequest) {
            ao=new XMLHttpRequest();
        } else {
            ao=new ActiveXObject('Microsoft.XMLHTTP');

        }
        
        // создадим callback
        ao.onreadystatechange = function() {
            if(ao.readyState == 4 && ao.status == 200) {
                h.innerHTML = ao.responseText;
            }
        }
        
        ao.open("POST", "handlers/ajax2.php", true);
        ao.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ao.send("cid="+cityid);
    }
    
</script>