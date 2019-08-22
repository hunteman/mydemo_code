<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hotel Info</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .carousel {
              height: 450px !important;
              width: 80%;
              margin: 0 auto;
            }    
        .carousel-inner img {
              height: 450px !important;
              margin: 0 auto;
            }
    </style>
</head>
<body style='color:#FFF; background:#000; line-height:0.8'>
    <?php
    include_once("functions.php");
    if(isset($_GET['hotel'])) {
        $hotel = $_GET['hotel'];
        $link = connect();
        $sel = 'SELECT * FROM hotels WHERE id='.$hotel;
        $res = mysqli_query($link, $sel);
        $row = mysqli_fetch_array($res, MYSQLI_NUM);
        $hname = $row[1];
        $hstars = $row[4];
        $hcost = $row[5];
        $hinfo = $row[6];
        mysqli_free_result($res);
        
        //echo "<div>$hname || $hstars || $hcost || $hinfo</div>";
        echo '<div class="container-fluid">';
        echo "<div class='row'>";
        echo "<div class='text-center col-sm-9 col-md-9 col-lg-9 left m-1 p-2'>";
        echo '<h2 class="text-uppercase text-center">'.$hname.'</h2>';
        
        $sel = 'SELECT imagepath FROM images WHERE hotelid='.$hotel;
        $res = mysqli_query($link, $sel);
        echo '<p class="lead">Watch our pictures</p>';
        echo '<p class="lead">Info: '.$hinfo.'</p>';
        
        echo '<ul id="gallery" style="list-style-type:none; padding: 0;">';
        for($i=0; $i<$hstars; $i++) {
            echo '<img src="../images/star2.png" alt="star2" draggable="false" style="width:40px;">';
        }
        echo '</ul>';
        
        echo '<div id="carouselExampleIndicators" class="carousel slide">';
                

        echo '<div class="carousel-inner">';

        while($row=mysqli_fetch_array($res, MYSQLI_NUM)) {
            echo '<div class="carousel-item"><img src="../'.$row[0].'" alt="hotelimage" class="img-fluid d-block w-100"></div>';
            $count += 1;
        }
        
        echo '</div>';
        
        echo  '<ol class="carousel-indicators">';
            for($i=0; $i<$count; $i++) {
                echo '<li data-target="#carouselExampleIndicators" data-slide-to="'.$i.'" class="active"></li>';
            }
            echo '</ol>';
        
        echo '<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>';
        
        echo '</div>';
        echo '</div>';
        mysqli_free_result($res);
        
    }
    
    echo "<div class='text-center col-sm-2 col-md-2 col-lg-2 right  m-1 p-2' style='overflow: scroll; max-height:96vh;'>";
        $sel = 'SELECT comment FROM comments WHERE hotelid='.$hotel;
        $res = mysqli_query($link, $sel);
        echo '<h3>Comments</h3><br>';
        while($row=mysqli_fetch_array($res, MYSQLI_NUM)){
            echo '<div class="mt-2" style="line-height:1.5;">';
            echo $row[0];
            echo '<hr style="background:yellow;">';
            echo '</div>';
        }
    echo "</div>";
    echo "</div>";
    echo "</div>";
    
    ?>
    
    
<!--<div class="container">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img class="d-block w-100" src="https://place-hold.it/1100x500" alt="First slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-100" src="https://place-hold.it/1100x500" alt="Second slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-100" src="https://place-hold.it/1100x500" alt="Third slide">
        </div>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
</div>-->
   
    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script>
         $(".carousel-item").first().toggleClass("active");
    </script>
    
</body>
</html>