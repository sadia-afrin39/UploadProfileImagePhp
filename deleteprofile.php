<?php
session_start();
include_once 'dbh.php';

////Delete one file
    $sessionid = $_SESSION['id'];

    //find the image in server
    $filename = "uploads/profile".$sessionid."*";
    $fileinfo = glob($filename);  //searches  everything with profile$sessionid.something
    //print_r($fileinfo);  //The desired file is always in index 0
    $fileExt = explode(".",$fileinfo[0]);
    //print_r($fileExt);
    $fileActualExt = $fileExt[1];
    $file =  "uploads/profile".$sessionid.".".$fileActualExt;

    //delete from server
    if(!unlink($file)){
        echo "file was not deleted";
    }else{
      echo "File was deleted";  
    }

     //delete from database
    $sql = "UPDATE profileimg SET status=1 where userid='$sessionid';";
    mysqli_query($conn,$sql);
    header("Location: index.php?delete=success");



////Delete more than one file(same folder as index.php)
    $fileNames = $_POST['filename'];
    $removeSpaces = str_replace(" ","",$fileNames);
    $allFileNames = explode(",",$removeSpaces);
    //print_r($allFileNames);

    //check if the input file exist or not
    $countAllNames = count($allFileNames);
    for ($i = 0; $i < $countAllNames; $i++){
        if(file_exists($allFileNames[$i]) == false){
            header("Location: index.php?delete=FileNotFound");
            exit();
        }else{
            $path = $allFileNames[$i];
            if(!unlink($path)){
            echo "You have an error";
             exit();
            }
        }
    }
    header("Location: index.php?delete=success");
