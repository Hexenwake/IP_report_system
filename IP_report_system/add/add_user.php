<?php
include'add_header.php';
include'../function.php';


if(isset($_POST['add'])){
    if(!empty($_POST['user_id'] && !empty($_POST['password']))){
        $user_id = $_POST['user_id'];
        $password = $_POST['password'];
        $query = "INSERT INTO `dbip.login_info`(`user_id`, `password`, `user_type`) VALUES ('$user_id','$password', 'user')";
        if(mysqli_query($conn, $query)){
            header('Location: ../user_id.php');
        }else{
            echo 'Error' . mysqli_error($conn);
        }
    }
}

if(isset($_POST['back'])){
    header('Location: ../user_id.php');
}
?>

<div class="container">
    <form action="<?php echo $_SERVER['PHP_SELF']?>" class="form-horizontal" method="POST">
        <h3>Add User</h3>

        <div class="row">
            <div class="col-25">
                <div style="margin-left:10px;">
                <label for="lname">User ID</label>
                </div>
            </div>
            <div class="col-25">
                <input type="text" id="user_id" name="user_id" style="text-align:center;" 
                autocomplete="off" placeholder="" style="text-align:center;" value="">
            </div>

            <div class="col-25">
                <div style="margin-left:10px;">
                <label for="lname">Password</label>
                </div>
            </div>
            <div class="col-25">
                <input type="text" id="password" name="password" style="text-align:center;"
                autocomplete="off" placeholder="" value="">
            </div>
        </div>

        <div class="row">
            <input class="button-2" type="submit" name="add" value="Add">
            <input class="button-2" type="submit" name="back" value="Back"><br><br>
         </div>

    </form>
</div>



<?php
include'add_footer.php';
?>