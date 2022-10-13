<?php
include'edit_header.php';
include'../function.php';

if(isset($_GET['user_id'])){
    $_SESSION['user_id'] = $_GET['user_id'];
    $user_id = $_GET['user_id'];
    $query = "SELECT * FROM `dbip.login_info` WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
}


if(isset($_POST['submit'])){
    if(!empty($_POST['user_id'] && !empty($_POST['password']))){
        $user_id = $_SESSION['user_id'];
        $user_id_new = $_POST['user_id'];
        $password_new = $_POST['password'];
        //delete old one
        $query_del = "DELETE FROM `dbip.login_info` WHERE user_id = '$user_id'";
        if(!mysqli_query($conn, $query_del)){
            echo 'Error' . mysqli_error($conn);
        }else{
            // //add new one
            $password = $_POST['password'];
            $query = "INSERT INTO `dbip.login_info`(`user_id`, `password`, `user_type`) VALUES ('$user_id_new','$password_new', 'user')";
            if(mysqli_query($conn, $query)){
                header('Location: ../user_id.php');
            }else{
                echo 'Error' . mysqli_error($conn);
            }
        }
    }
}

if(isset($_POST['back'])){
    header('Location: ../user_id.php');
}

?>

<div class="container">
    <form action="<?php echo $_SERVER['PHP_SELF']?>" class="form-horizontal" method="POST">
        <h3>Edit User</h3>

        <div class="row">
            <div class="col-25">
                <div style="margin-left:10px;">
                <label for="lname">User ID</label>
                </div>
            </div>
            <div class="col-25">
                <input type="text" id="user_id" name="user_id" style="text-align:center;"
                placeholder="" style="text-align:center;" value="<?= $row['user_id'] ?>">
            </div>

            <div class="col-25">
                <div style="margin-left:10px;">
                <label for="lname">Password</label>
                </div>
            </div>
            <div class="col-25">
                <input type="text" id="password" name="password" style="text-align:center;"
                autocomplete="off" placeholder="" value="<?= $row['password'] ?>">
            </div>
        </div>

        <div class="row">
            <input class="button-2" type="submit" name="submit" value="Submit">
            <input class="button-2" type="submit" name="back" value="Back"><br><br>
         </div>

    </form>
</div>



<?php
include'../footer.php';
?>