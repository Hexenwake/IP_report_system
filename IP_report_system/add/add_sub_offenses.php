<?php
include'add_header.php';
include'../function.php';


if(isset($_POST['add'])){
    if(!empty($_POST['sub_offenses_name'])){
        $sub_offenses_name = $_POST['sub_offenses_name'];
        $query = "INSERT INTO `dbip.sub_offenses`(`sub_offenses_name`) VALUES ('$sub_offenses_name')";
        if(mysqli_query($conn, $query)){
            header('Location: ../sub_offenses.php');
        }else{
            echo 'Error' . mysqli_error($conn);
        }
    }
}

if(isset($_POST['back'])){
    header('Location: ../sub_offenses.php');
}
?>

<div class="container">
    <form action="<?php echo $_SERVER['PHP_SELF']?>" class="form-horizontal" method="POST">
        <h3>Add Sub-Offences</h3>

        <div class="row">
            <div class="col-25">
                <div style="margin-left:10px;">
                <label for="lname">Sub offences Name</label>
                </div>
            </div>
            <div class="col-25">
                <input type="text" id="sub_offenses_name" name="sub_offenses_name" style="text-align:center;"
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