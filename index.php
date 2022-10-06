<?php
    session_start();
    include_once 'dbh.php';
?>
<!doctype html>
<html lang="en-US">
	<head>
		<title>How to upload profile images to users</title>
        <!-- <link rel='shortcut icon' type='image/x-icon' href='resources/img/favicon.png'>   -->
		<meta name="viewport" content="width = device-width, initial-scale=1.0">
        <meta name="description" content="How to upload profile images to users with php(mmtuts)">
		<meta http-equiv="X-UA-Compatible" content="IE=edge"> <!--for ie & edge support -->
		<meta name="author" content="Sadia Afrin Tarin">
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
		
		<!--<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css"/> used for animation on scroll-->
		<!--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">-->
		<!--<script src="../travelBD/js/all.min.js"></script>-->
		<!--<script src="Prefix_Free.js"></script>   if js not supported in browser-->
		<!--<link href="https://fonts.googleapis.com/css?family=Titillium+Web:300,400,600,700" rel='stylesheet'>-->	
        <!-- Latest compiled and minified CSS -->
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">-->

        <!-- jQuery library -->
       <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->

        <!-- Popper JS -->
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>-->

        <!-- Latest compiled JavaScript -->
        <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>-->
        <link rel="stylesheet"  type="text/css" href= "style.css">
	</head>

	<body>
        <?php
        //Shows username and profile in website 
             $sql = "SELECT * from user";
             $result = mysqli_query($conn,$sql);
             if(mysqli_num_rows($result) > 0){
                  while($row = mysqli_fetch_assoc($result)){
                      $id = $row['id'];
                      $sqlImg = "SELECT * FROM profileimg where userid = '$id';";
                      $resultImg =  mysqli_query($conn,$sqlImg);
                      while($rowImg = mysqli_fetch_assoc($resultImg)){
                          echo "<div class='user-container'>";
                            if($rowImg['status'] == 0){
                                $filename = "uploads/profile".$id."*";
                                $fileinfo = glob($filename); 
                                $fileExt = explode(".",$fileinfo[0]);
                                $fileActualExt = $fileExt[1];
                                echo "<img src='uploads/profile".$id.".".$fileActualExt."?'".mt_rand().">";  //mt_rand to understand browser different img
                            }else{
                               echo "<img src='uploadsprofiledefault.jpg'>";
                            }
                          echo "<p>".$row['username']."</p>";
                          echo "</div>";  
                      } 
                  }
              }else{
                 echo "There are no users yet!";
             } 
        
        
             if(isset($_SESSION['id'])){
                 if($_SESSION['id'] == 1){
                     echo "You are logged in as user number #1";
                 }
                 echo '<form action="upload.php" method="POST" enctype="multipart/form-data">
                <input type="file" name="file">
                <button type="submit" name="submit">Upload</button>
                </form>';
                 echo '<form action="deleteprofile.php" method="POST">
                 <button type="submit" name="submit">Delete Profile Image</button><br>
                 <input type="text" name="filename" placeholder="Seperate each name with a comma(,)" style="width:300px">
                <button type="submit" name="submit">Delete Multiple Image</button>
                </form>';
             }else{
                 echo "You are not logged in";
                 echo"<form action='signup.php' method='POST'>
                    <input type='text' name='first' placeholder='First name'>
                    <input type='text' name='last' placeholder='Last name'>
                    <input type='text' name='uid' placeholder='User name'>
                    <input type='password' name='pwd' placeholder='Password'>
                    <button type='submit' name='submitSignup'>SignUp</button>
                 </form>";
             }
        ?>    
        
        <p>Login as user!</p>
        <form action="login.php" method="POST">
            <button type="submit" name="submitLogin">Login</button>
        </form>
        
        <p>Logout as user!</p>
        <form action="logout.php" method="POST">
            <button type="submit" name="submitLogout">Logout</button>
        </form>
    </body>
</html>