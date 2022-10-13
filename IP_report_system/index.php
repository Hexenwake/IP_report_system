<?php 
include'config.php'; 

?>


<?php
// Set vars to empty values
$pass = $user_id = '';
$passErr = $user_idErr = '';
$error_message = '';

// Form submit
if (isset($_POST['submit'])) {
  
  // Validate user_id
  if (empty($_POST['user_id'])) {
    $user_idErr = 'UserID is required';
  } else {
    // $user_id = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  }

  // Validate Password
  if (empty($_POST['pass'])) {
    $passErr = 'Password is required';
  } else {
    $pass = filter_input(INPUT_POST,'pass',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  }


  if (empty($passErr) && empty($user_idErr)) {
    
    $sql = "select *from `dbip.login_info` where user_id = '$user_id' and password = '$pass'";
    $result = mysqli_query($conn, $sql);  
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
    $count = mysqli_num_rows($result);

    if($count > 0){
        print('count pass...');
        if($row['user_type'] == 'admin'){

            $_SESSION['id'] = $row['user_id'];
            header('location:homepage.php');
            $error_message = '';

        }elseif($row['user_type'] == 'user'){

            $_SESSION['id'] = $row['user_id'];
            header('location:user/user_homepage.php');
            $error_message = '';
   
        }else{
            $error_message = 'No user found!';
        }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Investigation Paper Tracking System</title>

<style>
body{
  background-image: url('https://scontent.fkul2-3.fna.fbcdn.net/v/t39.30808-6/243165409_226915506128649_6344640135508890664_n.jpg?stp=dst-jpg_p960x960&_nc_cat=110&ccb=1-7&_nc_sid=e3f864&_nc_ohc=ae44xfRTXz8AX_XchEj&_nc_ht=scontent.fkul2-3.fna&oh=00_AT__b_FugcFVZ8iI4AH3Wy2YXGCpFsHtKttDsuiVvNrrQg&oe=62F24C1E');
  background-repeat: no-repeat; 
  background-attachment: fixed;  
  background-size: cover;
  font-family: "Lato", sans-serif;
}
  

</style>
</head>
<body >

<nav class=" navbar-fixed-top"  style=" background-color: 	#F7FEFA;" >
  <div class="container-fluid" >
    <div class="navbar-header">  
      <div>
        <ul class="nav navbar-nav">
        <div>
              <a href="#" class="nav justify-content-center" >
              <img src="images\SFD_Logo2.png" width="64px" style="justify-content: center" ></a>
              <div style = "text-align: center"><b>Sabah Forestry Department</b></div>
        </div>
      </div>
    </nav>

<main>
  <div class="container d-flex flex-column align-items-center">
    <form action="<?php echo $_SERVER['PHP_SELF']?>" method ="POST"class="mt-4 w-55" style = "background: #fff ; padding: 30px;">
    <h2 style = "text-align: center">Investigation Paper Reporting System</h2>

      <div class="mb-3">
        <label for="userid" class="form-label">User ID</label>
          <input type="text" class="form-control <?php echo $user_idErr ? 'is-invalid' : null; ?>" id="user_id" name="user_id" placeholder="Enter your ID">
            <div class = "invalid-feedback">
              <?php echo $user_idErr;?>
            </div>
      </div>

      <div class="mb-3">
        <label for="passsordd" class="form-label">Password</label>
          <input type="password" class="form-control <?php echo $passErr ? 'is-invalid' : null; ?>" id="pass" name="pass" placeholder="Enter your password">
            <div class = "invalid-feedback">
              <?php echo $passErr;?>
            </div>
      </div>
      
      <div class="mb-3">
        <input type="submit" name="submit" value="Login" class="btn btn-dark w-100">
      </div>

      <footer class="text-center mt-5" style =  "text-align: center; padding: 3px;">
        Copyright &copy; Sabah Forestry Department 2022. All Rights Reserved.
        <div>
          Any Enquiries?Please<a href="https://jpkn.sabah.gov.my/">Contact us</a>
        </div>
      </footer>
    </form>
  </div>
</main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>