<?php
  error_reporting();
  session_start();

  // Connect to the sql database
  $db = mysqli_connect("localhost", "root", "", "form");


  // Function to check if email is valid
  function checkemail($str) {
    return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
}

  // Check if the user makes a post request and respond to it
  if(isset($_POST['submit'])){ 
    // assign the value of the email to a variable of same name
    $email = $_POST['email'];

    // VAlidate Email
    if(!checkemail($email)){
      $_SESSION["error"] = "This email is invalid 💀";
      header("Location:index.php");
      exit();
    }
      


    $sql_e = "SELECT * FROM cb_mailing_list WHERE email='$email'";
    $res_e = mysqli_query($db, $sql_e);

    if(mysqli_num_rows($res_e) > 0){
      $_SESSION["error"] = "This email has already been registered 😜";
      header("Location:index.php");
  	} else {
      $query = "INSERT INTO cb_mailing_list(email)values('$email')";

      $result = mysqli_query($db, $query);
    


      if ($result == true) {
        echo "saved";
        $_SESSION["success"] = "Registered successfully 😙";
        header("Location:index.php");
        exit();
      } else {
        echo "Omo, something wrong o 💀: " . mysqli_error($db);
        $_SESSION["error"] = "An error occured, try again";
        header("Location:index.php");
        exit();
      }
    }

    
  }
?>