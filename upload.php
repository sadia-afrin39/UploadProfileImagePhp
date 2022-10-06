<?php
    session_start();
    include_once 'dbh.php';

    $id = $_SESSION['id'];

    if(isset($_POST['submit'])){
     $file = $_FILES['file'];  //$_FILES is a super global
     //print_r($file);
     $fileName = $_FILES['file']['name'];
     $fileTmpName = $_FILES['file']['tmp_name'];
     $fileSize = $_FILES['file']['size'];
     $fileError = $_FILES['file']['error'];
     $fileType = $_FILES['file']['type'];
     
     $fileExt = explode('.', $fileName);
     //print_r($fileExt);
     $fileActualExt = strtolower(end($fileExt));
     
     $allowed = array('jpg','jpeg','png','pdf');
     
     if(in_array($fileActualExt, $allowed)){
         if($fileError === 0){
             if($fileSize < 1000000){
                $fileNameNew = "profile".$id.".".$fileActualExt;//give the file a unique name to prevent that file from more upload
                $fileDestination = 'uploads/'.$fileNameNew;
                 move_uploaded_file($fileTmpName,$fileDestination);
                 $sql = "UPDATE profileimg SET status=0 where userid='$id';";
                 mysqli_query($conn,$sql);
                 header("Location: index.php?upload=success");
             }else{
                 echo "You file is too big";
                  exit();
             }
         }else{
             echo "There was an error uploading your file";
              exit();
         }
     }else{
         echo "You cannot upload files of this type";
         exit();
     }
 }
















