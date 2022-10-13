<?php
    include'delete_header.php';
    include'../function.php';
    
    if(isset($_GET['offenses_name'])){
        $offenses_name = $_GET['offenses_name'];
        $query_del = "DELETE FROM `dbip.offenses_list` WHERE offenses_name = '$offenses_name'";
        if(!mysqli_query($conn, $query_del)){
            echo 'Error' . mysqli_error($conn);
        }else{
            header('Location: ../offenses.php');
        }
    }
?>
<?php include'delete_footer.php';?>