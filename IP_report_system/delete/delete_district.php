<?php
    include'delete_header.php';
    include'../function.php';
    
    if(isset($_GET['district_code'])){
        $district_code = $_GET['district_code'];
        $query_del = "DELETE FROM `dbip.district_code` WHERE district_code = '$district_code'";
        if(!mysqli_query($conn, $query_del)){
            echo 'Error' . mysqli_error($conn);
        }else{
            header('Location: ../district_code.php');
        }
    }
?>
<?php include'delete_footer.php';?>