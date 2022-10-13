<?php
include'add_header.php';
include'../function.php';


if(isset($_POST['add'])){
    if(!empty($_POST['district_code'] && !empty($_POST['district']))){
        $district_code = $_POST['district_code'];
        $district = $_POST['district'];
        $query = "INSERT INTO `dbip.district_code`(`district_code`, `district`) VALUES ('$district_code','$district')";
        if(mysqli_query($conn, $query)){
            header('Location: ../district_code.php');
        }else{
            echo 'Error' . mysqli_error($conn);
        }
    }
}

if(isset($_POST['back'])){
    header('Location: ../district_code.php');
}
?>

<div class="container">
    <form action="<?php echo $_SERVER['PHP_SELF']?>" class="form-horizontal" method="POST">
        <h3>Add District</h3>

        <div class="row">
            <div class="col-25">
                <div style="margin-left:10px;">
                <label for="lname">District Code</label>
                </div>
            </div>
            <div class="col-25">
                <input type="text" id="district_code" name="district_code" style="text-align:center;" 
                autocomplete="off" placeholder="" style="text-align:center;" value="">
            </div>

            <div class="col-25">
                <div style="margin-left:10px;">
                <label for="lname">District Name</label>
                </div>
            </div>
            <div class="col-25">
                <input type="text" id="district" name="district" style="text-align:center;"
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