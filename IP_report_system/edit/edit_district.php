<?php
include'edit_header.php';
include'../function.php';

if(isset($_GET['district_code'])){
    $_SESSION['district_code'] = $_GET['district_code'];
    $district_code = $_GET['district_code'];
    $query = "SELECT * FROM `dbip.district_code` WHERE district_code = '$district_code'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
}


if(isset($_POST['submit'])){
    if(!empty($_POST['district_code'] && !empty($_POST['district']))){
        $district_code = $_SESSION['district_code'];
        $district_code_new = $_POST['district_code'];
        $district_new = $_POST['district'];
        //delete old one
        $query_del = "DELETE FROM `dbip.district_code` WHERE district_code = '$district_code'";
        if(!mysqli_query($conn, $query_del)){
            echo 'Error' . mysqli_error($conn);
        }else{
            // //add new one
            $district = $_POST['district'];
            $query = "INSERT INTO `dbip.district_code`(`district_code`, `district`) VALUES ('$district_code_new','$district_new')";
            if(mysqli_query($conn, $query)){
                header('Location: ../district_code.php');
            }else{
                echo 'Error' . mysqli_error($conn);
            }
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
                placeholder="" style="text-align:center;" value="<?= $row['district_code'] ?>">
            </div>

            <div class="col-25">
                <div style="margin-left:10px;">
                <label for="lname">District Name</label>
                </div>
            </div>
            <div class="col-25">
                <input type="text" id="district" name="district" style="text-align:center;"
                autocomplete="off" placeholder="" value="<?= $row['district'] ?>">
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