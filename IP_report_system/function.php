<?php

function no_ip_run_num($untrim_no_ip){
    //for year - get the position of the last / plus with one then get the next 4 characters
    $trim_no_ip = trim_no_ip($untrim_no_ip);
    $a = strpos($trim_no_ip, "KS") + 3; 
    $b = strrpos($trim_no_ip,"/");
    $run_num = substr($trim_no_ip, $a , $b - $a);
    return $run_num;
}

function no_ip_year($untrim_no_ip){
    //for year - get the position of the last / plus with one then get the next 4 characters
    $trim_no_ip = trim_no_ip($untrim_no_ip);
    $trim_no_ip_year = substr($trim_no_ip, strrpos($trim_no_ip,"/")+1 , 4);
    return $trim_no_ip_year;
}

function no_ip_district_code($untrim_no_ip){
    //for district code - get the length of the a and b where a: the position of the front / of district code (behind JPHTN)
    // and b: the position of the / behind district code (infront KS)
    $trim_no_ip = trim_no_ip($untrim_no_ip);
    $a = strpos($trim_no_ip, "JPHTN") + 6;
    $b = strpos($trim_no_ip, "KS") - 1;
    $district_code = substr($trim_no_ip, $a , $b - $a);
    return $district_code;
}

function trim_no_ip($untrim_no_ip){
    $trim_no_ip = rtrim($untrim_no_ip, '/');
    return $trim_no_ip;
}

function filterTable($query)
{
    $connect = mysqli_connect("localhost", "root", "", "dbip");
    $filter_Result = mysqli_query($connect, $query);
    return $filter_Result;
}

function filter_year($upper, $lower,$result)
{
    $i=1;
    while($row = mysqli_fetch_array($result)){
        $year = no_ip_year($row['no_ip']);
        $no_ip = trim_no_ip($row['no_ip']);
        $district_code = no_ip_district_code($row['no_ip']);
        if($year>=$lower && $year<=$upper){
            echo "<tr>";
            echo "<td>".$i."</td>";
            echo "<td>".$no_ip."</td>";
            echo "<td>".$year."</td>";
            echo "<td>".$district_code."</td>";
            echo "<td><div class='container_table'>".$row["investigator"]."</div></td>";
            echo "<td><div class='container_table'>".$row["case_details"]."</div></td>";
            echo "<td><div class='container_table'>".$row["case_status"]."</div></td>";
            echo "<td><div class='container_table'>".$row["case_no"]."</div></td>";
            echo "<td><div class='container_table'><div class='row'><a class='button-34-edit btn-primary' href='edit_page.php?no_ip=".$no_ip."'><i class='fa fa-pencil'></i></a> </div><br>
            <div class='row'> <a class='button-34-delete btn-primary' onclick='return confirm('Are you sure you want to delete this data?');' href='delete_page.php?no_ip=".$no_ip."'><i class='fa fa-trash'></i>
            </a> </div></div></td>";
            echo "</tr>";
            $i++;
        }
        
    }
}

function populate_table($result){
    $i=1;
    while($row = mysqli_fetch_array($result)){
        $year = no_ip_year($row['no_ip']);
        $no_ip = trim_no_ip($row['no_ip']);
        $district_code = no_ip_district_code($row['no_ip']);
        echo "<tr>";
        echo "<td><div class='container_table'>".$i."</div></td>";
        echo "<td><div class='container_table'>".$no_ip."</div></td>";
        echo "<td><div class='container_table'>".$year."</div></td>";
        echo "<td><div class='container_table'>".$district_code."</div></td>";
        echo "<td><div class='container_table'>".$row["investigator"]."</div></td>";
        echo "<td><div class='container_table'>".$row["case_details"]."</div></td>";
        echo "<td><div class='container_table'>".$row["case_status"]."</div></td>";
        echo "<td><div class='container_table'>".$row["case_no"]."</div></td>";
        echo "<td><div class='container_table'><a class='button-34-edit btn-primary' href='edit_page.php?no_ip=".$no_ip."'><i class='fa fa-pencil'></i></a> </div><br> 
        <a class='button-34-delete btn-primary' onclick='return confirm('Are you sure you want to delete this data?');' href='delete_page.php?no_ip=".$no_ip."'><i class='fa fa-trash'></i>
        </a> </div></div></td>";
        echo "</tr>";
        $i++;
    }
}

function populate_table_district($result){
    $i=1;
    while($row = mysqli_fetch_array($result)){
        echo "<tr>";
        echo "<td><div class='container_table'>".$i."</div></td>";
        echo "<td><div class='container_table'>".$row['district_code']."</div></td>";
        echo "<td><div class='container_table'>".$row['district']."</div></td>";
        echo "<td><div class='container_table'>
        <a class='button-34-edit btn-primary' href='edit_district.php?district_code=".$row['district_code']."'><i class='fa fa-pencil'></i></a></div>
        <br>
        <a class='button-34-delete btn-primary' onclick='return confirm('Are you sure you want to delete this data?');' href='delete_district.php?district_code=".$row['district_code']."'>
        <i class='fa fa-trash'></i></a> </div></div></td>";
        echo "</tr>";
        $i++;
    }
}


//--------------data entry pages functions-------------//

function set_data_page_3(){
    $_SESSION['fines'] = $_POST['fines'];
    $_SESSION['notes_fines'] = $_POST['notes_fines'];
  
    $_SESSION['offenses_nature'] = $_POST['offenses_nature'];
    $_SESSION['sub_offenses'] = $_POST['sub_offenses'];
    $_SESSION['notes_offenses_nature'] = $_POST['notes_offenses_nature'];
  
    $_SESSION['image_upload_path'] = $_POST['image_upload_path'];
    $_SESSION['notes_cases_image'] = $_POST['notes_cases_image'];
}

function set_data_page_2(){
    $_SESSION['log_type'] = $_POST['log_type'];
    $_SESSION['num_log'] = $_POST['num_log'];
    $_SESSION['volume'] = $_POST['volume'];
    $_SESSION['value_log'] = $_POST['value_log'];
    $_SESSION['notes_3'] = $_POST['notes_3'];
  
    $_SESSION['num_seized'] = $_POST['num_seized'];
    $_SESSION['num_forfeited'] = $_POST['num_forfeited'];
    $_SESSION['value_equipment'] = $_POST['value_equipment'];
    $_SESSION['notes_4'] = $_POST['notes_4'];
}

function set_data_page_1(){
    // $_SESSION['year'] = $_POST['year'];
    // $_SESSION['district_code'] = $_POST['district_code'];
  
    // $_SESSION['no_ip_3'] = $_POST['no_ip_3'];
    // $_SESSION['no_ip_4'] = $_POST['no_ip_4'];
    // $_SESSION['no_ip_5'] = $_POST['no_ip_5'];

    $_SESSION['no_ip'] = $_POST['no_ip'];

    $_SESSION['p_report_date'] = $_POST['p_report_date'];
    $_SESSION['p_report_no'] = $_POST['p_report_no'];
    $_SESSION['case_no'] = $_POST['case_no'];
    $_SESSION['investigator'] = $_POST['investigator'];
    $_SESSION['keputusan'] = $_POST['keputusan'];
    
    $_SESSION['case_details'] = $_POST['case_details'];
    $_SESSION['case_status'] = $_POST['case_status'];
    $_SESSION['notes_1'] = $_POST['notes_1'];
  
    $_SESSION['arrested_people_status'] = $_POST['arrested_people_status'];
    $_SESSION['num_local_people'] = $_POST['num_local_people'];
    $_SESSION['num_nonlocal_people'] = $_POST['num_nonlocal_people'];
    $_SESSION['notes_2'] = $_POST['notes_2'];
}


//-------------db functions--------------//


function dbip_reported_cases($status, $conn, $no_ip, $p_report_date, $p_report_no, $case_no, $investigator, $case_details, $case_status, $keputusan, $notes_1){
    if($status == 'insert'){
        $query = "INSERT INTO `dbip.reported_cases`(`no_ip`, `p_report_date`, `p_report_no`, `case_no`, `investigator`, `case_details`, `case_status`, `keputusan`, `notes`) 
        VALUES ('$no_ip','$p_report_date','$p_report_no','$case_no','$investigator','$case_details','$case_status', '$keputusan', '$notes_1')";
        if(mysqli_query($conn, $query)){
            header('Location: update_page.php');
        }else{
            echo 'Error' . mysqli_error($conn);
        }
    }elseif($status == 'update'){
        $query = "UPDATE `dbip.reported_cases` SET `no_ip`='$no_ip',`p_report_date`='$p_report_date',`p_report_no`='$p_report_no',`case_no`='$case_no',`investigator`='$investigator',`case_details`='$case_details',`case_status`='$case_status' 
        WHERE no_ip = '$no_ip'";
        if(mysqli_query($conn, $query)){
            header('Location: update_page.php');
        }else{
            echo 'Error' . mysqli_error($conn);
        }
    }elseif($status == 'select'){
        $query = "SELECT * FROM `dbip.reported_cases` WHERE no_ip = '$no_ip'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);
        return $row;
    }else{
        echo "Invalid Status";
        $err = "Error";
    }
}

function dbip_people_arrested($status, $conn, $no_ip, $arrested_people_status, $num_local_people, $num_nonlocal_people, $notes_2){
    if($status == 'insert'){
        $query = "INSERT INTO `dbip.people_arrested`(`no_ip`, `arrested_people_status`, `num_local_people`, `num_nonlocal_people`, `notes_people_arrested`) 
        VALUES ('$no_ip','$arrested_people_status','$num_local_people','$num_nonlocal_people','$notes_2')";
        if(mysqli_query($conn, $query)){
            header('Location: update_page.php');
        }else{
            echo 'Error' . mysqli_error($conn);
        }
    }elseif($status == 'update'){
        $query = "UPDATE `dbip.people_arrested` SET `no_ip`='$no_ip',`arrested_people_status`='$arrested_people_status',`num_local_people`='$num_local_people',`num_nonlocal_people`='$num_nonlocal_people',`notes_2`='$notes_2' 
        WHERE no_ip = '$no_ip'";
        if(mysqli_query($conn, $query)){
            header('Location: update_page.php');
        }else{
            echo 'Error' . mysqli_error($conn);
        }
    }elseif($status == 'select'){
        $query = "SELECT * FROM `dbip.people_arrested` WHERE no_ip = '$no_ip'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);
        return $row;
    }else{
        echo "Invalid Status";
        $err = "Error";
    }
}

function dbip_seizure_log($status, $conn, $no_ip, $num_log, $log_type, $volume, $value_log, $notes_3){

    if($log_type == "Logs"){
        $num_log = $num_log;
        $num_converted_timber = 0;
    }elseif($log_type == "Converted Timber"){
        $num_converted_timber = $num_log;
        $num_log = 0;
    }else{
        $num_converted_timber = 0;
        $num_log = 0;
    }

    if($status == 'insert'){
        $query = "INSERT INTO `dbip.seizure_log`(`no_ip`, `num_logs`, `num_converted_timber`, `volume`, `value_seizure_log`, `notes_seizure_log`) 
        VALUES ('$no_ip','$num_log','$num_converted_timber','$volume','$value_log','$notes_3')";
        if(mysqli_query($conn, $query)){
            header('Location: update_page.php');
        }else{
            echo 'Error' . mysqli_error($conn);
        }
    }elseif($status == 'update'){
        $query = "UPDATE `dbip.seizure_log` SET `no_ip`='$no_ip',`num_log`='$num_log',`num_converted_timber`='$num_converted_timber',`volume`='$volume',`value_log`='$value_log' ,`notes_3`='$notes_3' 
        WHERE no_ip = '$no_ip'";
        if(mysqli_query($conn, $query)){
            header('Location: update_page.php');
        }else{
            echo 'Error' . mysqli_error($conn);
        }
    }elseif($status == 'select'){
        $query = "SELECT * FROM `dbip.seizure_log` WHERE no_ip = '$no_ip'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);
        return $row;
    }else{
        echo "Invalid Status";
        $err = "Error";
    }
}

function dbip_seizure_machine_equip($status, $conn, $no_ip, $num_seized, $num_forfeited, $value_equipment, $notes_4){
    if($status == 'insert'){
        $query = "INSERT INTO `dbip.seizure_machine_equip`(`no_ip`, `num_seized`, `num_forfeited`, `value_seizure_machine`, `notes_seizure_machine`) 
        VALUES ('$no_ip','$num_seized','$num_forfeited','$value_equipment','$notes_4')";
        if(mysqli_query($conn, $query)){
            header('Location: update_page.php');
        }else{
            echo 'Error' . mysqli_error($conn);
        }
    }elseif($status == 'update'){
        $query = "UPDATE `dbip.seizure_machine_equip` SET `no_ip`='$no_ip',`num_seized`='$num_seized',`num_forfeited`='$num_forfeited',`value_equipment`='$value_equipment',`notes_4`='$notes_4' 
        WHERE no_ip = '$no_ip'";
        if(mysqli_query($conn, $query)){
            header('Location: update_page.php');
        }else{
            echo 'Error' . mysqli_error($conn);
        }
    }elseif($status == 'select'){
        $query = "SELECT * FROM `dbip.seizure_machine_equip` WHERE no_ip = '$no_ip'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);
        return $row;
    }else{
        echo "Invalid Status";
        $err = "Error";
    }
}

function dbip_fines_collection($status, $conn, $no_ip, $fines, $notes_fines){
    if($status == 'insert'){
        $query = "INSERT INTO `dbip.fines_collection`(`no_ip`, `fines`, `notes_fines`) 
        VALUES ('$no_ip','$fines','$notes_fines')";
        if(mysqli_query($conn, $query)){
            header('Location: update_page.php');
        }else{
            echo 'Error' . mysqli_error($conn);
        }
    }elseif($status == 'update'){
        $query = "UPDATE `dbip.fines_collection` SET `no_ip`='$no_ip',`fines`='$fines',`notes_fines`='$notes_fines'
        WHERE no_ip = '$no_ip'";
        if(mysqli_query($conn, $query)){
            header('Location: update_page.php');
        }else{
            echo 'Error' . mysqli_error($conn);
        }
    }elseif($status == 'select'){
        $query = "SELECT * FROM `dbip.fines_collection` WHERE no_ip = '$no_ip'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);
        return $row;
    }else{
        echo "Invalid Status";
        $err = "Error";
    }
}

function dbip_offenses_nature($status, $conn, $no_ip, $offenses_nature,  $sub_offenses, $notes_offenses_nature){
    if($status == 'insert'){
        $query = "INSERT INTO `dbip.offenses_nature`(`no_ip`, `offenses_nature`, `sub_offenses`, `notes_offenses_nature`) 
        VALUES ('$no_ip','$offenses_nature', '$sub_offenses', '$notes_offenses_nature')";
        if(mysqli_query($conn, $query)){
            header('Location: update_page.php');
        }else{
            echo 'Error' . mysqli_error($conn);
        }
        
    }elseif($status == 'select'){
        $query = "SELECT * FROM `dbip.offenses_nature` WHERE no_ip = '$no_ip'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);
        return $row;
    }else{
        echo "Invalid Status";
        $err = "Error";
    }
}

function dbip_cases_image($status, $conn, $no_ip, $image_upload_path, $notes_cases_image){
    if($status == 'insert'){
        $query = "INSERT INTO `dbip.cases_image`(`no_ip`, `image_upload_path`, `notes_cases_image`) 
        VALUES ('$no_ip','$image_upload_path','$notes_cases_image')";
        if(mysqli_query($conn, $query)){
            header('Location: update_page.php');
        }else{
            echo 'Error' . mysqli_error($conn);
        }
    }elseif($status == 'update'){
        $query = "UPDATE `dbip.cases_image` SET `no_ip`='$no_ip',`fines`='$image_upload_path',`notes_fines`='$notes_cases_image'
        WHERE no_ip = '$no_ip'";
        if(mysqli_query($conn, $query)){
            header('Location: update_page.php');
        }else{
            echo 'Error' . mysqli_error($conn);
        }
    }elseif($status == 'select'){
        $query = "SELECT * FROM `dbip.cases_image` WHERE no_ip = '$no_ip'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);
        return $row;
    }else{
        echo "Invalid Status";
        $err = "Error";
    }
}

function db_delete($conn, $no_ip){
    $row = dbip_cases_image('select', $conn, $no_ip, 0, 0);
    $path = $row['image_upload_path'];

    If (unlink('images/'.$path)) {
    // file was successfully deleted
    } else {
    // there was a problem deleting the file
    }

    $sql_reported_cases = "DELETE FROM `dbip.reported_cases` where no_ip = '$no_ip'";
    $sql_people_arrested = "DELETE FROM `dbip.people_arrested` where no_ip = '$no_ip'";
    $sql_seizure_log = "DELETE FROM `dbip.seizure_log` where no_ip = '$no_ip'";
    $sql_seizure_machine_equip = "DELETE FROM `dbip.seizure_machine_equip` where no_ip = '$no_ip'";
    $sql_fines_collection = "DELETE FROM `dbip.fines_collection` where no_ip = '$no_ip'";
    $sql_offenses_nature = "DELETE FROM `dbip.offenses_nature` where no_ip = '$no_ip'";
    $sql_cases_image = "DELETE FROM `dbip.cases_image` where no_ip = '$no_ip'";

    if(mysqli_query($conn, $sql_reported_cases) 
    && mysqli_query($conn, $sql_people_arrested)
    && mysqli_query($conn, $sql_seizure_log)
    && mysqli_query($conn, $sql_seizure_machine_equip)
    && mysqli_query($conn, $sql_fines_collection)
    && mysqli_query($conn, $sql_offenses_nature)
    && mysqli_query($conn, $sql_cases_image)){
        //success
        //header('Location: update_page.php');
    }else{
        echo 'Error' . mysqli_error($conn);
    }
}

//-------------------------------------- district codes ---------------------------------//


?>
