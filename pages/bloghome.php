<?php session_start(); 

if (isset($_SESSION['logged_user'])){
    if (isset($_POST['logoutsubmit'])) {     
            unset($_SESSION["logged_user"]);
        } 
}

?> 

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Cornell in Vietnam | Winter 2017</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css">
    </head>
<body>
	<?php
		include("../includes/header.php");
   		include("../includes/nav.php");

	    require_once ("../includes/config.php");
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
        if($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        } else {
            echo NULL;
        }
    
	?>
	<div class="page-content">
        
		<div id="loginformwelcome">
        <p>Log In Form</p>  
            <form action="bloghome.php" method="post">
                Username:<input type="text" name="authorname"><br>
                Password:<input type="password" name="password"><br> 
                <input type="submit" name="loginsubmit" value="Log In">
            </form>
	   </div>
    </div> <!-- page content div -->
    
<?php
 
if(isset($_POST['loginsubmit'])) {
        
        if(!isset($authorname) && !isset($password)) {
            if (preg_match('/^[A-Za-z0-9_,. ]*$/', $_POST['authorname']) && preg_match('/^[A-Za-z0-9_,. ]*$/', $_POST['password'])) {
            $username = filter_input(INPUT_POST, 'authorname', FILTER_SANITIZE_STRING);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
            $hashpassword = '$2y$10$4MSLoGEop/TRC3TB96Dz5uq/c.jPlx8qqN3KKG/UlGVr963L5fLlG';
                
            if (password_verify($password, $hashpassword)) {
        
            $sql = "SELECT Author_Name, Hash_Password FROM Users;";  
            $result=$mysqli->query($sql);

                if($result && $result->num_rows==1){
                    $row=$result->fetch_assoc();
                        $database_username=$row['Author_Name'];
                        $database_password=$row['Hash_Password'];

                    if ($hashpassword == $database_password && $username == $database_username) {
                        $_SESSION['logged_user'] = $username;
                        echo"<script> window.location='winter2017.php';</script>";
                     }
             
                    elseif ($username != $database_username) {
                            echo "Please check your username.";
                    } 
                }
                
            } else {
                echo "Please check your credentials.";
            }
        }  //pregmatch    
            else {
                echo "Bad input.";
            }
        }   //!isset    
    }   
?>
    
    <form action="bloghome.php" method="post">
    <input type="submit" name="logoutsubmit" value="Log Out">
    </form>
    
</body>