<?php
include'edit_header.php';
include'../function.php';

if(isset($_GET['offenses_name'])){
    $_SESSION['offenses_name'] = $_GET['offenses_name'];
    $offenses_name = $_GET['offenses_name'];
    $query = "SELECT * FROM `dbip.offenses_list` WHERE offenses_name = '$offenses_name'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
}


if(isset($_POST['submit'])){
    if(!empty($_POST['offenses_name'])){
        $offenses_name = $_SESSION['offenses_name'];
        $offenses_name_new = $_POST['offenses_name'];
        //delete old one
        $query_del = "DELETE FROM `dbip.offenses_list` WHERE offenses_name = '$offenses_name'";
        if(!mysqli_query($conn, $query_del)){
            echo 'Error' . mysqli_error($conn);
        }else{
            //add new one
            $query = "INSERT INTO `dbip.offenses_list`(`offenses_name`) VALUES ('$offenses_name_new')";
            if(mysqli_query($conn, $query)){
                header('Location: ../offenses.php');
            }else{
                echo 'Error' . mysqli_error($conn);
            }
        }
    }
}

if(isset($_POST['back'])){
    header('Location: ../offenses.php');
}

?>

<div class="container">
    <form action="<?php echo $_SERVER['PHP_SELF']?>" class="form-horizontal" method="POST">
        <h3>Edit offenses</h3>

        <div class="row">

            <div class="col-25">
                <div style="margin-left:10px;">
                <label for="lname">offenses Name</label>
                </div>
            </div>
            <div class="col-25">
                <input type="text" id="offenses_name" name="offenses_name" style="text-align:center;"
                autocomplete="off" placeholder="" value="<?= $row['offenses_name'] ?>">
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