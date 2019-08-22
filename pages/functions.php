<?php
function connect($host="127.0.0.1", $user="root", $pass="123456", $dbname="travels") {
    
    // ф-ция для подключения к mysql. Требует 4 параметра.
    $link = mysqli_connect($host, $user, $pass, $dbname);
    
    if(!$link){
        echo "Невозможно установить соединение с MySQL";
        //Возвращает код ошибки последнего соединения
        echo "Код ошибки errno" .mysqli_connect_errno();
        //mysqli_connect_error() - ТЕКСТ ОШИБКИ
        echo "Текст ошибки errno:" .mysqli_connect_error();
        exit; // прервать дальнейшее выполнение ф-ции
    }
    echo "Connect was succesfully<br>";
    
    if(!mysqli_set_charset($link, "utf8")) {
        echo "Ошибка при загрузке кодировки символов utf8: "
        .mysqli_error($link);
        exit;
    }
    return $link;
}

?>



<?php

// Параметры из текстовых полей в форме регистрации
function register($name, $pass, $pass2, $email) {
    // ф-я trim () - позволяет убрать пробелы в начале и конце строки
    // ф-я htmlspecialchars - позволяет убирать символы, предназначенные для передачи вредоносного кода (защита от php-иньекций)
    $name = trim(utf8_encode(htmlspecialchars($name)));
    $pass = trim(htmlspecialchars($pass));
    $pass2 = trim(htmlspecialchars($pass2));
    $email = trim(htmlspecialchars($email));
    
    
    
    if($name == '' || $pass == '' || $email == '') {
        echo "<h3 style='color:red;'>Заполните все поля</h3>";
        return false;
    }
    
    
    // strlen() - позволяет узнать кол-во символов в строке
    if(strlen($name) <3 || strlen($name) > 30 || strlen($pass) <3 || strlen($pass) >30 ) {
        echo "<h3 style='color:red;'>От 3 до 30 символов</h3>";
        return false;
    }
    
    // Занесение данных о пользователе при регистрации в таблицу Users при регистрации
    // Хэшируем пароль через ф-цию password_hash
    $pass = password_hash($pass, PASSWORD_BCRYPT);
    // Вставляем данные из полей формы регистрации в таблицу
    $ins = "INSERT INTO users(login, pass, email, roleid) VALUES('$name', '$pass', '$email', 2)";
    
    $link = connect();
    
    $add_user = mysqli_query($link, $ins);
    
    // дописать проверку
    return true;
}

function login($login, $pass) {
    $login = trim(utf8_encode(htmlspecialchars($login)));
    $pass = trim(htmlspecialchars($pass));
    
        if($login == '' || $pass == '') {
            echo "<h3 style='color:red;'>Заполните все поля</h3>";
            return false;
        }
    
        if(strlen($login) <3 || strlen($login) > 30 || strlen($pass) <3 || strlen($pass) >30 ) {
        echo "<h3 style='color:red;'>От 3 до 30 символов</h3>";
        return false;
        }
    
    $link = connect();
    // $pass = password_hash($pass, PASSWORD_BCRYPT);
    $sel='SELECT * FROM users WHERE login="'.$login.'"'; 
    $res = mysqli_query($link, $sel);
    
    // проверка пользователя на роль (админ или обычный) и занесение в сессию
 
  if($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
         
    if(password_verify($pass, $row[2])) {
        $_SESSION['ruser']=$login;
        if($row[5]==1) {
            $_SESSION['radmin']=$login;
        }
        return true;
    }   
  } else {
        echo "<h3 style='color:red;'>No such user</h3>";
        return false;
    } 
    mysqli_free_result($sel);
}

?>