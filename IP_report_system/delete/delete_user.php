<?php
    include'delete_header.php';
    include'../function.php';
    
    if(isset($_GET['user_id'])){
        $user_id = $_GET['user_id'];
        $query_del = "DELETE FROM `dbip.login_info` WHERE user_id = '$user_id'";
        if(!mysqli_query($conn, $query_del)){
            echo 'Error' . mysqli_error($conn);
        }else{
            header('Location: ../user_id.php');
        }
    }
?>
<?php include'delete_footer.php';?>