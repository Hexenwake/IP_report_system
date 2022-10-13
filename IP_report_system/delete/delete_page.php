<?php
    include'delete_header.php';
    include'../function.php';
    
    if(isset($_GET['no_ip'])){
        $no_ip = $_GET['no_ip'];
        db_delete($conn, $no_ip);
        header('Location: ../update_page.php');
    }
?>
<?php include'../footer.php';?>