
<ul class="nav nav-pills nav-fill">
    <li class="nav-item"><a class="nav-link active" href="index.php?page=1">Tours</a></li>
    <li class="nav-item"><a class="nav-link" href="index.php?page=2">Comments</a></li>
    <li class="nav-item"><a class="nav-link" href="index.php?page=3">Registration</a></li>   
    <li class="nav-item"><a class="nav-link" href="index.php?page=4">Admin Forms</a></li>   
    
    <?php
    if(isset($_SESSION['radmin'])){
        echo '<li class="nav-item"><a class="nav-link" href="index.php?page=5">Avatar</a></li>';
    }
    ?>   
</ul>





