<?php
session_start();
include_once("functions.php");
$link = connect();
if(empty($_SESSION['radmin'])){
    echo '<h3 style="color:red;">For Admins Only</h3>';
    exit;
}
echo'<form action="" method="post" enctype="multipart/form-data" class="input-group">';
echo '<select name="userid">';
$sel = 'SELECT * FROM users WHERE roleid=2 ORDER BY login';
$res = mysqli_query($link, $sel);
while($row = mysqli_fetch_array($res, MYSQLI_NUM)){
    echo '<option value="'.$row[0].'">'.$row[1].'</option>';
}
echo'</select>';
mysqli_free_result($res);
echo '<input type="file" name="file" accept="image/*">';
echo '<input type="submit" name="addadmin" value="Make admin" class="btn btn-sm btn-info">';

echo '</form>';

// Обработчик для изменения роли пользователя
if(isset($_POST['addadmin'])) {
    $userid=$_POST['userid'];
    $fn = $_FILES['file']['tmp_name'];
    $file = fopen($fn, 'rb'); // rb - побайтовое чтение
    $img = fread($file, filesize($fn)); // filesize - возвращает размер файла
    fclose($file);
    $img = addslashes($img);
    $upd = 'UPDATE users SET avatar="'.$img.'", roleid=1 WHERE id='.$userid;
    mysqli_query($link, $upd);
}

// создание таблицы администраторов
$sel = 'SELECT * FROM users WHERE roleid=1 ORDER BY login';
$res = mysqli_query($link, $sel);
echo '<table class="table table-stripped">';
while($row=mysqli_fetch_array($res, MYSQLI_NUM)) {
    echo '<tr>';
    echo '<td>'.$row[0].'</td>';
    echo '<td>'.$row[1].'</td>';
    echo '<td>'.$row[3].'</td>';
    $img=base64_encode($row[6]); // $row[6] - аватар || base64_encode() переводит из bin(binary)
    echo '<td><img style="width: 100px;" src="data:image/*;base64,'.$img.'"></td>';
    echo '</tr>';
}
echo '</table>';
?>