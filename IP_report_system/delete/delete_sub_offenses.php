<?php
    include'delete_header.php';
    include'../function.php';
    
    if(isset($_GET['sub_offenses_name'])){
        $sub_offenses_name = $_GET['sub_offenses_name'];
        $query_del = "DELETE FROM `dbip.sub_offenses` WHERE sub_offenses_name = '$sub_offenses_name'";
        if(!mysqli_query($conn, $query_del)){
            echo 'Error' . mysqli_error($conn);
        }else{
            header('Location: ../sub_offenses.php');
        }
    }
?>
<?php include'delete_footer.php';?>