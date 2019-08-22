<h3>Upload form</h3>


<?php
if(!isset($_POST['uppbtn'])) {
    


?>
<form action="index.php?page=2" method="post"
enctype="multipart/form-data">
    <div class="form-group">
        <label for="myfile">Select file for upload</label>
        <input type="file" class="form-control" name="myfile" accept="image/*">
    </div>
    <button type="submit" class="btn btn-primary" name="uppbtn">Send file</button>
</form>
<?php
} else {
    if($_FILES['myfile']['error'] !=0){
echo "<h3 style='color:red;'>".$_FILES['myfile']['error']."</h3>";
    exit;
    }
    
    // проверяем есть ли файл в папке tmp
    // is_uploaded_file - проверка файла на существование
    // move_uploaded_file - ф-ция переноса файла
    if(is_uploaded_file($_FILES['myfile']['tmp_name'])){
        move_uploaded_file($_FILES['myfile']['tmp_name'], "images/".$_FILES['myfile']['name']);
    }
    echo "<h3 style='color:green;'>file uploaded successful</h3>";
}
?>
