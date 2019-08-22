
<?php
if(isset($_SESSION['ruser'])) {
    echo '<form action="index.php';
    if(isset($_GET['page'])) echo '?page='.$_GET['page'];
    echo '"class="form-inline " method="post" style="color:white">';
    echo '<h4>Hello, <span>'.$_SESSION['ruser'].'</span>';
    echo '<input type="submit" value="Logout" id="ex" name="ex" class="btn btn-default btn-sm ml-2" style="background:white"></h4>';
    echo '</form>';
    if(isset($_POST['ex'])){
        unset($_SESSION['ruser']);
        unset($_SESSION['radmin']);
        echo '<script>window.location.reload()</script>'; 
    }
} else {
    if(isset($_POST['press'])) {
            if(login($_POST['login'], $_POST['pass'])) {
            echo '<script>window.location=document.URL</script>';
        }
    } else {
        echo '<form action="index.php';
        if(isset($_GET['page'])) echo '?page='.$_GET['page'];
        echo '"class="form-inline" method="post">';
        echo '<input class="form-control m-sm-1" type="text" name="login" size="10" placeholder="login">';
        echo '<input class="form-control m-sm-1" type="password" name="pass" size="10" placeholder="pass">';
        echo '<input type="submit" name="press" id="press" value="login" class="btn btn-primary m-1 my-sm-0">';
        echo '</form>';
    }
}
?>