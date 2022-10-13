<?php

include'add_header.php';
include'../function.php';

if(isset($_SESSION['fines'])){
  $data['fines'] = $_SESSION['fines'];
}else{
  $data['fines'] = '';
}

if(isset($_SESSION['notes_fines'])){
  $data['notes_fines'] = $_SESSION['notes_fines'];
}else{
  $data['notes_fines'] = '';
}

if(isset($_SESSION['offenses_nature'])){
  $data['offenses_nature'] = $_SESSION['offenses_nature'];
}else{
  $data['offenses_nature'] = '';
}

if(isset($_SESSION['sub_offenses'])){
  $data['sub_offenses'] = $_SESSION['sub_offenses'];
}else{
  $data['sub_offenses'] = '';
}

if(isset($_SESSION['notes_offenses_nature'])){
  $data['notes_offenses_nature'] = $_SESSION['notes_offenses_nature'];
}else{
  $data['notes_offenses_nature'] = '';
}

if(isset($_SESSION['image_upload_path'])){
  $data['image_upload_path'] = $_SESSION['image_upload_path'];
}else{
  $data['image_upload_path'] = '';
}

if(isset($_SESSION['notes_cases_image'])){
  $data['notes_cases_image'] = $_SESSION['notes_cases_image'];
}else{
  $data['notes_cases_image'] = '';
}



if(isset($_POST['next'])){
  set_data_page_3();

  // //filter inputs
  // $district_code = filter_var($_SESSION['district_code'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  // $year = filter_var($_SESSION['year'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  // //running number starts at 1 for every new year
  // $sql_count = "SELECT `no_ip`,SUBSTRING_INDEX(SUBSTRING_INDEX(no_ip, '/', 4), '/', -1) AS `run_num` FROM `dbip.reported_cases`  WHERE CONCAT(`no_ip`) LIKE '%".$year."%' ORDER BY `run_num` ";
  // $number = '';
  // $i = $j = 1;
  // $result = mysqli_query($conn, $sql_count);
  // while($test = mysqli_fetch_array($result)){
  //   $no_ip = $test['no_ip'];
  //   $run_num = no_ip_run_num($no_ip);
  //   if($run_num != $i && $j==1){
  //     echo $i;
  //     $number = $i;
  //     $j++;
  //   }else{
  //     $number = $i + 1;
  //   }
  //   $i++;
  // }

  // if($number<=0){
  //   $number = 1;
  // }
  // //combining ip from different part
  // $arr = array("JPHTN", $district_code, "KS", $number, $year);
  // $no_ip = join("/", $arr);

  $no_ip = filter_var($_SESSION['no_ip'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $p_report_date = filter_var($_SESSION['p_report_date'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $p_report_no = filter_var($_SESSION['p_report_no'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $case_no = filter_var($_SESSION['case_no'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $investigator = filter_var($_SESSION['investigator'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $case_details = filter_var($_SESSION['case_details'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $case_status = filter_var($_SESSION['case_status'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $keputusan = filter_var($_SESSION['keputusan'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $notes_1 = filter_var($_SESSION['notes_1'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $arrested_people_status = filter_var($_SESSION['arrested_people_status'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $num_local_people = filter_var($_SESSION['num_local_people'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $num_nonlocal_people = filter_var($_SESSION['num_nonlocal_people'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $notes_2 = filter_var($_SESSION['notes_2'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  // seizure_log sanitized
  $log_type = filter_var($_SESSION['log_type'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $num_log = filter_var($_SESSION['num_log'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $volume = filter_var($_SESSION['volume'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $value_log = filter_var($_SESSION['value_log'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $notes_3 = filter_var($_SESSION['notes_3'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $num_seized = filter_var($_SESSION['num_seized'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $num_forfeited = filter_var($_SESSION['num_forfeited'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $value_equipment = filter_var($_SESSION['value_equipment'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $notes_4 = filter_var($_SESSION['notes_4'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $fines = filter_var($_SESSION['fines'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $notes_fines = filter_var($_SESSION['notes_fines'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $offenses_nature = filter_var($_SESSION['offenses_nature'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $sub_offenses = filter_var($_SESSION['sub_offenses'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $notes_offenses_nature = filter_var($_SESSION['notes_offenses_nature'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $notes_cases_image = filter_var($_SESSION['notes_cases_image'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  
  $filename = $_FILES["uploadfile"]["name"];
  $tempname = $_FILES["uploadfile"]["tmp_name"];
  $image_upload_path = "../images/".$filename;

  // move file to path
  if (move_uploaded_file($tempname, $image_upload_path)) {
      echo "<h3>  Image uploaded successfully!</h3>";
  } else {
      echo "<h3>  Failed to upload image!</h3>";
  }

  // send to dbip.reported_cases ---- Passed
  dbip_reported_cases('insert', $conn, $no_ip, $p_report_date, $p_report_no, $case_no, $investigator, $case_details, $case_status, $keputusan, $notes_1);

  // send to dbip.people_arrested ---- Passed
  dbip_people_arrested('insert', $conn, $no_ip, $arrested_people_status, $num_local_people, $num_nonlocal_people, $notes_2);

  //// send to dbip.seizure_log ---- Passed
  dbip_seizure_log('insert', $conn, $no_ip, $num_log, $log_type, $volume, $value_log, $notes_3);

  // send to dbip.seizure_machine_equip
  dbip_seizure_machine_equip('insert', $conn, $no_ip, $num_seized, $num_forfeited, $value_equipment, $notes_4);

  dbip_fines_collection('insert', $conn, $no_ip, $fines, $notes_fines); // send to dbip.fines_collection
  
  dbip_offenses_nature('insert', $conn, $no_ip, $offenses_nature,  $sub_offenses, $notes_offenses_nature); // send to dbip.offenses_nature

  dbip_cases_image('insert', $conn, $no_ip, $filename, $notes_cases_image);

  header('Location:../update_page.php');
}

if(isset($_POST['previous'])){
  set_data_page_3();
  header('Location:add_second_page.php');
}

?>



<div class="w1-container w3-grey">
<h6>Fine and Penalties Collected</h6>
</div>

<div class="container">
<form action="<?php echo $_SERVER['PHP_SELF']?>" class="form-horizontal" method="POST" enctype="multipart/form-data">    
    <div class="row">
      <div class="col-25">
        <label for="fines">Fines Values</label>
      </div>
      <div class="col-25">
        <input type="text" id="fines" name="fines" 
        autocomplete="off" placeholder="" value="<?= $data['fines']?>">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="notes_fines">Notes</label>
      </div>
      <div class="col-75">
        <textarea id="notes_fines" name="notes_fines" 
        autocomplete="off" style="height:50px" ><?= $data['notes_fines']?></textarea>
      </div>
    </div>
</div>


<!-- nature of offense entry -->
<div class="w1-container w3-grey">
<h6>Nature of Offenses</h6>
</div>

<div class="container">
    <div class="row">
      <div class="col-25">
        <label for="country">Type of Offenses</label>
      </div>
      <div class="col-75">
        <select id="offenses_nature" name="offenses_nature" style="text-align:center; ">
        <option value="<?php echo $data['offenses_nature']?>"><?php echo $data['offenses_nature']?></option>
          <?php
            $query_offenses_list = "SELECT * FROM `dbip.offenses_list`";
            $result = mysqli_query($conn, $query_offenses_list);
            while($row = mysqli_fetch_array($result)){
              echo "<option value = '".$row['offenses_name']."'>". $row['offenses_name']."</option>";
            }
          ?>
        </select>
      </div>
    </div>


    <div class="row">
      <div class="col-25">
        <label for="country">Sub offenses</label>
      </div>
      <div class="col-75">
        <select id="sub_offenses" name="sub_offenses" style="text-align:center; ">
        <option value="<?php echo $data['sub_offenses']?>"><?php echo $data['sub_offenses']?></option>
          <?php
            $query_sub_offenses = "SELECT * FROM `dbip.sub_offenses`";
            $result = mysqli_query($conn, $query_sub_offenses);
            while($row = mysqli_fetch_array($result)){
              echo "<option value='".$row['sub_offenses_name']."'>". $row['sub_offenses_name']."</option>";
            }
          ?>
        </select>
      </div>
    </div>

    <div class="row">
      <div class="col-25">
        <label for="notes_offenses_nature">Notes</label>
      </div>
      <div class="col-75">
        <textarea id="notes_offenses_nature" name="notes_offenses_nature" 
        autocomplete="off" style="height:50px" ><?= $data['notes_offenses_nature']?></textarea>
      </div>
    </div>

</div>


<!-- Cases Image Upload -->
<div class="w1-container w3-grey">
<h6>Cases Image Upload</h6>
</div>

<div class="container">
    <div class="row">
      <div class="col-25">
        <label for="uploadfile">Upload Image</label>
      </div>
      <div class="col-75">
        <input type=file id="uploadfile" name="uploadfile" 
        autocomplete="off" ><?= $data['image_upload_path']?></input>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="notes_cases_image">Notes</label>
      </div>
      <div class="col-75">
        <textarea id="notes_cases_image" name="notes_cases_image" 
        autocomplete="off" style="height:50px" ><?= $data['notes_cases_image']?></textarea>
      </div>
    </div>
    <div class="row">
      <input class="button-2" style= "float:left;" type="submit" name="previous" value="Previous">  
      <input class="button-40" style= "float:right;" type="submit" name="next" onclick="return confirm('Are you sure you want to submit this form?');" value="Submit" >  
    </div>
  </form>
</div>




<?php
include'add_footer.php';
?>