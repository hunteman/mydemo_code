<?php
error_reporting(E_ALL);

include_once("functions.php");

$link = connect(); // в переменную link запишется переменная $link, кот-я будет возвращена ф-цией connect() при успешном подключении к MySQL(БД)

// auto_increment - поле увеличивается на единицу автоматически
// primary key - ключевое значение, всегда добавляется у поля id  и позволяет сделать запись уникальной
//ЭТО ВСЕ язык запросов sql
//varchar - это тип данных для текста, знач-е в () означает кол-во символов
//unique - делает так, чтобы одна и та же запись не могла быть создана (две одинаковые страны)
$ct1='CREATE TABLE countries(
id int not null auto_increment primary key, 
country varchar(64) unique
)default charset="utf8"';

// foreign key(countryid) references countries(id) - связывает внешним ключом 2 столбца из разных таблиц
// on delete caskade - если в родит столбце была удалена запись, то в дочерней они также удалятся (т.е. если удалим страну, то удалим и все города с ней связанные)
$ct2='CREATE TABLE cities(
id int not null auto_increment primary key, 
city varchar(64),
countryid int,
foreign key(countryid) references countries(id) on delete cascade,
ucity varchar(128),
unique index ucity(city, countryid)
)default charset="utf8"';

$ct3='CREATE TABLE hotels (
id int not null auto_increment primary key,
hotel varchar(64),
cityid int,
foreign key(cityid) references cities(id) on delete cascade,
countryid int,
foreign key(countryid) references countries(id) on delete cascade,
stars int,
cost int,
info varchar(1024)
)default charset="utf8"';

$ct4='CREATE TABLE images (
id int not null auto_increment primary key,
imagepath varchar(255),
hotelid int,
foreign key(hotelid) references hotels(id) on delete cascade
)default charset="utf8"';

$ct5='CREATE TABLE roles (
id int not null auto_increment primary key,
role varchar(32)
)default charset="utf8"';

// mediumblob - тип данных для изображений до 16 мб
$ct6='CREATE TABLE users (
id int not null auto_increment primary key,
login varchar(32) unique,
pass varchar(128),
email varchar(128),
discount int,
roleid int,
foreign key(roleid) references roles(id) on delete cascade,
avatar mediumblob
)default charset="utf8"';

$ct7='CREATE TABLE comments (
id int not null auto_increment primary key,
comment varchar(1024),
hotelid int,
foreign key(hotelid) references hotels(id) on delete cascade
)default charset="utf8"';

 // ф-я для запроса в базу данных. Имеет два пар-ра
mysqli_query($link, $ct1);
$err=mysqli_errno($link);
if($err) {
    echo "Error code 1 " . $err . '<br>';
    exit;
}

mysqli_query($link, $ct2);
$err=mysqli_errno($link);
if($err) {
    echo "Error code 2 " . $err . '<br>';
    exit;
}

mysqli_query($link, $ct3);
$err=mysqli_errno($link);
if($err) {
    echo "Error code 3 " . $err . '<br>';
    exit;
}

mysqli_query($link, $ct4);
$err=mysqli_errno($link);
if($err) {
    echo "Error code 4 " . $err . '<br>';
    exit;
}

mysqli_query($link, $ct5);
$err=mysqli_errno($link);
if($err) {
    echo "Error code 5 " . $err . '<br>';
    exit;
}

mysqli_query($link, $ct6);
$err=mysqli_errno($link);
if($err) {
    echo "Error code 6 " . $err . '<br>';
    exit;
}

mysqli_query($link, $ct7);
$err=mysqli_errno($link);
if($err) {
    echo "Error code 7 " . $err . '<br>';
    exit;
}

?>