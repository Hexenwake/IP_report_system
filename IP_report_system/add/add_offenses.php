<?php
include'add_header.php';
include'../function.php';


if(isset($_POST['add'])){
    if(!empty($_POST['offenses_name'])){
        $offenses_name = $_POST['offenses_name'];
        $query = "INSERT INTO `dbip.offenses_list`(`offenses_name`) VALUES ('$offenses_name')";
        if(mysqli_query($conn, $query)){
            header('Location: ../offenses.php');
        }else{
            echo 'Error' . mysqli_error($conn);
        }
    }
}

if(isset($_POST['back'])){
    header('Location: ../offenses.php');
}
?>

<div class="container">
    <form action="<?php echo $_SERVER['PHP_SELF']?>" class="form-horizontal" method="POST">
        <h3>Add offenses</h3>

        <div class="row">
            <div class="col-25">
                <div style="margin-left:10px;">
                <label for="lname">offenses Name</label>
                </div>
            </div>
            <div class="col-25">
                <input type="text" id="offenses_name" name="offenses_name" style="text-align:center;"
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