<?php error_reporting(E_ALL); 
if(!isset($_SESSION['radmin'])){
    echo "<h3 style='color:red;'>Only Admin</h3>";
    exit;
}

?>
   <!-- ROW 1 -->
    <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6 left">
            <!-- section A: for form countries -->
            <?php
            $link = connect(); // результат ф-ции конект
            $sel = 'SELECT * FROM countries';
            $res = mysqli_query($link, $sel);
            
            // вывод стран в таблице
            echo '<form action="index.php?page=4" method="post" class="input-group p-3 border border-dark" id="formcountry" style="background:#fff">';
            echo '<table class="table table-striped">';
            // mysqli_fetch_array - берет одну строку и  помещает ее в массив. Если обычный массив, то вторым пар-ром идет константа MYSQLI_NUM, если массив ассоц (MYSQLI_ASSOC), если и так и так, то MYSQLI_BOTH
            while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
            echo '<tr>';
            echo '<td>'.$row[0].'</td>'; // номер страны
            echo '<td>'.$row[1].'</td>'; // название страны
            echo '<td><input type="checkbox" name="cb'.$row[0].'"></td>';
            echo '</tr>';
            }
            echo '</table>';
            mysqli_free_result($res); // Освобождает память, занятую результатом запроса
            
            // добавление стран START
            
            echo '<input type="text" name="country" placeholder="Country">';
            echo '<input type="submit" name="addcountry" value="add" class="btn btn-sm btn-info">';
            echo '<input type="submit" name="delcountry" value="del" class="btn btn-sm btn-warning">';
            echo '</form>';
            // добавление стран END
            
            //обработчик добавления страны
            if(isset($_POST['addcountry'])) {
                $country = trim(htmlspecialchars($_POST['country']));
                if($country=="") exit;
                $ins = 'INSERT INTO countries(country) VALUES("'.$country.'")';
                mysqli_query($link, $ins);
                echo '<script>window.location=document.URL</script>';
            }
            
            //обработчик удаления страны
            if(isset($_POST['delcountry'])) {
                foreach($_POST as $k => $v) {
                    if(substr($k,0,2)=='cb') {
                        $idc = substr($k, 2); // делаем выборку числа из cb1, cb2...
                        $del = 'DELETE FROM countries WHERE id='.$idc;
                        mysqli_query($link, $del);
                    }
                } 
                echo '<script>window.location=document.URL</script>';
            } 
            
            ?>
        </div>        
        <div class="col-sm-6 col-md-6 col-lg-6 right">
            <!-- section B: for form cities -->
            <?php
            echo '<form action="index.php?page=4" method="post" class="input-group  p-3 mt-4 border border-dark" id="formcity" style="background:#fff">';
            

            
            // Блок вывода городов
            $sel='SELECT ci.id, ci.city, co.id, co.country FROM cities ci, countries co WHERE ci.countryid=co.id';
            $res = mysqli_query($link,$sel);
            echo '<table class="table table-striped">';
            while($row=mysqli_fetch_array($res, MYSQLI_NUM)){
                echo '<tr>';
                echo '<td>'.$row[0].'</td>';
                echo '<td>'.$row[1].'</td>';
                echo '<td>'.$row[3].'</td>';
                echo '<td><input type="checkbox" name="cc'.$row[0].'"</td>';
                echo '</tr>';
            }
            echo '</table>';
            mysqli_free_result($res);
            

            // Добавление города и привязка его к стране
            $res = mysqli_query($link, 'SELECT * FROM countries');
            // список стран
            echo '<select name="countryname">';
            while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
            echo "<option value='$row[0]'>$row[1]</option>";
            }
            echo '</select>';
            echo '<input type="text" name="city" placeholder="City">';
            echo '<input type="submit" name="addcity" value="add" class="btn btn-sm btn-info">';
            echo '<input type="submit" name="delcity" value="del" class="btn btn-sm btn-warning">';
            
            echo '</form>';
            
            // Обработчик для добавления города
            if(isset($_POST['addcity'])) {
                $city = trim(htmlspecialchars($_POST['city']));
                if($city=="") exit;
                $countryid = $_POST['countryname']; // возьмется значение и select, в зависимости от выбранного option и его value, т.е. если выбрать spain, то после нажатия кнопки add, то в $_POST['countryname'] будет записан номер страны (допустим 10)
                $ins = "INSERT INTO cities(city, countryid) VALUES('$city', '$countryid')";
                mysqli_query($link, $ins);
                
                $err = mysqli_error($link);
                if($err) {
                    echo "Error text: $err <br>";
                    exit;
                }
                
                    echo '<script>window.location=document.URL</script>';
            }
            
            //обработчик удаления города
            if(isset($_POST['delcity'])) {
                
                foreach($_POST as $k => $v) {
                    if(substr($k,0,2)=='cc') {
                        $idc = substr($k, 2); // делаем выборку числа из cb1, cb2...
                        $del = 'DELETE FROM cities WHERE id='.$idc;
                        mysqli_query($link, $del);
                    }
                } 
                echo '<script>window.location=document.URL</script>';
            } 
            
            ?>
        </div>
    </div>   
    
    <!-- ROW 2 -->
    <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6 left">
            <!-- section C: for form hotels -->
            <?php 
            echo '<form action="index.php?page=4" method="post" class="input-group p-3 mt-4 border border-dark" id="formhotel" style="background:#fff">';
            
            // Блок вывода отелей
            $sel='SELECT ci.id, ci.city, ho.id, ho.hotel, ho.cityid, ho.countryid, ho.stars, ho.info, co.id, co.country FROM cities ci, hotels ho, countries co WHERE ho.cityid=ci.id AND ho.countryid=co.id';
            $res = mysqli_query($link,$sel);
            echo '<table class="table">';
            while($row=mysqli_fetch_array($res, MYSQLI_NUM)){
                echo '<tr>';
                echo '<td>'.$row[2].'</td>';
                echo '<td>'.$row[1].'-'.$row[9].'</td>';
                echo '<td>'.$row[3].'</td>';
                echo '<td>'.$row[6].'</td>';
                echo '<td><input type="checkbox" name="hb'.$row[2].'"</td>';
                echo '</tr>';
            }
            echo '</table>';
            mysqli_free_result($res);
            
            // форма добавления отелей
            $sel = 'SELECT ci.id, ci.city, co.country, co.id FROM countries co, cities ci WHERE ci.countryid=co.id';
            $res = mysqli_query($link, $sel);  // query - запрос, т.е. рез-т работы mysqli_query запишется в $res, т.е. вот эти все данные (ci.id, ci.city, co.country, co.id)
            $csel = array();
            echo '<div class="form-group row"><div class="col"><select name="hcity" class="form-control">';
            while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
            echo "<option value='$row[0]'>$row[1] : $row[2]</option>";
            $csel[$row[0]]=$row[3]; // т.е. присвоить co.id в ci.id
            }
            echo '</select></div>';
            echo '<div class="col"><input type="text" name="hotel" placeholder="hotel" class="form-control"></div></div>';
            echo '<label for="stars" class="m-2">STARS:</label><input type="number" id="stars" name="stars" min="1" max="5" class="form-control m-1">';
            echo '<input type="text" name="cost" placeholder="cost" class="form-control m-1">';
            echo '<div class="form-group row col-sm-12 col-md-12 col-lg-12"><textarea name="info" placeholder="Description hotel" class="m-1"></textarea></div>';
            echo '<div class="form-group row col-sm-12 col-md-12 col-lg-12"><input type="submit" name="addhotel" value="add" class="btn btn-sm btn-info">';
            echo '<input type="submit" name="delhotel" value="del" class="btn btn-sm btn-warning"></div>';
            
            echo '</form>';
            
            // обработчик добавления отелей
            if(isset($_POST['addhotel'])){
                $hotel = trim(htmlspecialchars($_POST['hotel']));
                $cost= intval(trim(htmlspecialchars($_POST['cost']))); // intval() - преобразует в целое число столбец cost имеет тип int
                $stars = intval($_POST['stars']);
                $info = trim(htmlspecialchars($_POST['info']));
                if($hotel==""||$cost==""||$stars=="") exit;
                $cityid = $_POST['hcity']; // $cityid = ci.id, только ci.id будет зависеть от выбранного в селекте варианта
                $countryid=$csel[$cityid]; // берем из массива $csel индекс по номеру города и заносим значение в переменную $countryid
                
                $ins = "INSERT INTO hotels(hotel,cityid,countryid,stars,cost,info) VALUES('$hotel','$cityid','$countryid','$stars','$cost','$info')";
                mysqli_query($link,$ins);
                    
                    echo '<script>window.location=document.URL</script>';
            }
            
            //обработчик удаления отелей
            if(isset($_POST['delhotel'])) {
                foreach($_POST as $k => $v) {
                    if(substr($k,0,2)=='hb') {
                        $idc = substr($k, 2); // делаем выборку числа из hb1, hb2...
                        $del = 'DELETE FROM hotels WHERE id='.$idc;
                        mysqli_query($link, $del);
                    }
                } 
                echo '<script>window.location=document.URL</script>';
            } 
            ?>
            
        </div>        
        <div class="col-sm-6 col-md-6 col-lg-6 right">
            <!-- section D: for form images -->
            <?php
            echo '<form action="index.php?page=4" method="post" enctype="multipart/form-data" class="input-group mt-4 p-3 border border-dark" style="background:#fff">';
            $sel = 'SELECT ho.id, co.country, ci.city, ho.hotel FROM countries co, cities ci, hotels ho WHERE co.id=ho.countryid AND ci.id=ho.cityid ORDER BY co.country'; // ORDER BY - сортирует по возрастанию в алф порядке
            $res = mysqli_query($link, $sel);

            echo '<select name="hotelid">';
            while($row=mysqli_fetch_array($res, MYSQLI_NUM)) {
                echo "
                <option value='$row[0]'>$row[1]|$row[2]|$row[3]</option>"; 
            }
            echo '</select>';
            mysqli_free_result($res);
            // multiple - атрибут для загрузки нескольких файлов сразу
            echo '<input type="file" name="file[]" multiple accept="image/*">';
            echo '<input type="submit" name="addimage" value="add" class="btn btn-sm btn-info">';
            echo '</form>';
            
            // Обработчик добавления изображений
            if(isset($_POST['addimage'])) {
                foreach($_FILES['file']['name'] as $k => $v) {
                    if($_FILES ['file']['error'][$k] != 0) {
                        echo '<script>alert("Upload file error:'.$v.'")</script>)';
                        continue;
                    }
                    if(move_uploaded_file($_FILES['file']['tmp_name'][$k], 'images/'.$v)) {
                        $ins = 'INSERT INTO images(hotelid, imagepath) VALUES('.$_POST['hotelid'].', "images/'.$v.'")';
/*                        if(!array_unique($v)) {
                            echo "<span style='color: red;'><b>".$v." - This image is already there!</b></span>";
                            exit;
                        }*/
                        mysqli_query($link, $ins); 
                    }
                }
            }
            
            ?>
            
        </div>
    </div>