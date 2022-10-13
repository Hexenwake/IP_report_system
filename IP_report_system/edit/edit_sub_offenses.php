<?php
include'edit_header.php';
include'../function.php';

if(isset($_GET['sub_offenses_name'])){
    $_SESSION['sub_offenses_name'] = $_GET['sub_offenses_name'];
    $sub_offenses_name = $_GET['sub_offenses_name'];
    $query = "SELECT * FROM `dbip.sub_offenses` WHERE sub_offenses_name = '$sub_offenses_name'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
}


if(isset($_POST['submit'])){
    if(!empty($_POST['sub_offenses_name'])){
        $sub_offenses_name = $_SESSION['sub_offenses_name'];
        $sub_offenses_name_new = $_POST['sub_offenses_name'];
        //delete old one
        $query_del = "DELETE FROM `dbip.sub_offenses` WHERE sub_offenses_name = '$sub_offenses_name'";
        if(!mysqli_query($conn, $query_del)){
            echo 'Error' . mysqli_error($conn);
        }else{
            //add new one
            $query = "INSERT INTO `dbip.sub_offenses`(`sub_offenses_name`) VALUES ('$sub_offenses_name_new')";
            if(mysqli_query($conn, $query)){
                header('Location: ../sub_offenses.php');
            }else{
                echo 'Error' . mysqli_error($conn);
            }
        }
    }
}

if(isset($_POST['back'])){
    header('Location: ../sub_offenses.php');
}

?>

<div class="container">
    <form action="<?php echo $_SERVER['PHP_SELF']?>" class="form-horizontal" method="POST">
        <h3>Edit sub_offenses</h3>

        <div class="row">

            <div class="col-25">
                <div style="margin-left:10px;">
                <label for="lname">sub_offenses Name</label>
                </div>
            </div>
            <div class="col-25">
                <input type="text" id="sub_offenses_name" name="sub_offenses_name" style="text-align:center;"
                autocomplete="off" placeholder="" value="<?= $row['sub_offenses_name'] ?>">
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