<?php

include'add_header.php';
include'../function.php';

// if(isset($_SESSION['year'])){
//   $data['year'] = $_SESSION['year'];
// }else{
//   $data['year'] = '';
// }

// if(isset($_SESSION['district_code'])){
//   $fetchdata = $_SESSION['district_code'];
//   $sql = "SELECT * FROM `dbip.district_code` where district_code = '$fetchdata' ";
//   $result = mysqli_query($conn, $sql);
//   $count = mysqli_num_rows($result);

//   if($count > 0){
//     $row = mysqli_fetch_assoc($result);
//     $data['district_code'] = $row['district_code'];
//     $data['district'] = $row['district'];
//   }
// }else{
//   $data['district_code'] = '';
//   $data['district'] = '---Please choose a district---';
// }

if(isset($_SESSION['no_ip'])){
  $data['no_ip'] = $_SESSION['no_ip'];
}else{
  $data['no_ip'] = '';
}

if(isset($_SESSION['p_report_date'])){
  $data['p_report_date'] = $_SESSION['p_report_date'];
}else{
  $data['p_report_date'] = '';
}

if(isset($_SESSION['p_report_no'])){
  $data['p_report_no'] = $_SESSION['p_report_no'];
}else{
  $data['p_report_no'] = '';
}

if(isset($_SESSION['case_no'])){
  $data['case_no'] = $_SESSION['case_no'];
}else{
  $data['case_no'] = '';
}

if(isset($_SESSION['investigator'])){
  $data['investigator'] = $_SESSION['investigator'];
}else{
  $data['investigator'] = '';
}

if(isset($_SESSION['keputusan'])){
  $data['keputusan'] = $_SESSION['keputusan'];
}else{
  $data['keputusan'] = '';
}

if(isset($_SESSION['case_details'])){
  $data['case_details'] = $_SESSION['case_details'];
}else{
  $data['case_details'] = '';
}

if(isset($_SESSION['case_status']) && $_SESSION['case_status'] != ''){
  $data['case_status'] = $_SESSION['case_status'];
}else{
  $data['case_status'] = '---Choose a status---';
}

if(isset($_SESSION['notes_1'])){
  $data['notes_1'] = $_SESSION['notes_1'];
}else{
  $data['notes_1'] = '';
}

if(isset($_SESSION['arrested_people_status'])){
  $data['arrested_people_status'] = $_SESSION['arrested_people_status'];
}else{
  $data['arrested_people_status'] = '---Choose a status---';
}

if(isset($_SESSION['num_local_people'])){
  $data['num_local_people'] = $_SESSION['num_local_people'];
}else{
  $data['num_local_people'] = '';
}

if(isset($_SESSION['num_nonlocal_people'])){
  $data['num_nonlocal_people'] = $_SESSION['num_nonlocal_people'];
}else{
  $data['num_nonlocal_people'] = '';
}

if(isset($_SESSION['notes_2'])){
  $data['notes_2'] = $_SESSION['notes_2'];
}else{
  $data['notes_2'] = '';
}

if(isset($_POST['next'])){
  set_data_page_1();
  header('Location:add_second_page.php');
}

if(isset($_POST['previous'])){
  header('Location:../homepage.php');
}


// database functions
// calling district's db
$sql_district = "SELECT * FROM `dbip.district_code` ";
$district = mysqli_query($conn, $sql_district );

?>


<!-- ------- -->
<!-- CONTENT -->
<!-- ------- -->

<div class="header" style="height: 30px;">
<h6><b> Part 1: Reported Cases </b></h6>
</div>

<div class="container">
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="form-horizontal" method="POST"> 
      
    <!-- <div class="row">
      <div class="col-25">
        <div style="margin-left:10px;">
          <label for="lname">Tahun</label>
        </div>
      </div>
      <div class="col-25">
        <input type="text" class="form-control" id="year" name="year" style="text-align:center;"
        autocomplete="off" placeholder="" value="<?= $data['year']?>">
      </div>


      <div class="col-25">
        <div style="margin-left:10px;">
          <label for="district">Daerah</label>
        </div>
      </div>
      <div class="col-25">
        <select id="district_code" name="district_code" style="text-align:center;">
            <?php echo "<option value = ".$data['district_code']."> ". $data['district']." </option>"; ?>
            <?php
              while($select = mysqli_fetch_array($district)){
                echo "<option value = '".$select['district_code']."'> ". $select['district']." </option>";
              }
            ?> 
          </select> 
      </div>
    </div> -->

    <div class="row">
      <div class="col-25">
        <div style="margin-left:10px;">
          <label for="lname">No IP : </label>
        </div>
      </div>
      <div class="col-25">
        <input type="text" class="form-control" id="no_ip" name="no_ip" style="text-align:center;"
        autocomplete="off" placeholder="" value="<?= $data['no_ip']?>">
      </div>
    </div>

    <div class="row">
      <div class="col-25">
        <div style="margin-left:10px;">
          <label for="lname">Tarikh Laporan Polis</label>
        </div>
      </div>
      <div class="col-25">
        <input type="date" id="p_report_date" name="p_report_date" style="text-align:center;" autocomplete="off"
        placeholder="" style="text-align:center;" value="<?= $data['p_report_date']?>">
      </div>

      <div class="col-25">
        <div style="margin-left:10px;">
          <label for="lname">No. Laporan Polis</label>
        </div>
      </div>
      <div class="col-25">
        <input type="text" class="form-control" id="p_report_no" name="p_report_no" style="text-align:center;"
        autocomplete="off" placeholder="" value="<?= $data['p_report_no']?>">
      </div>
    </div>

    <!-- 2nd row -->
    <div class="row">
      <div class="col-25">
        <div style="margin-left:10px;">
          <label for="lname">No. Kes/TPR</label>
        </div>
      </div>
      <div class="col-25">
        <input type="text" class="form-control" id="case_no" name="case_no" style="text-align:center;"
        autocomplete="off" placeholder="" value="<?= $data['case_no']?>">
      </div>


      <div class="col-25">
        <div style="margin-left:10px;">
          <label for="lname">Pegawai Penyiasat</label>
        </div>
      </div>
      <div class="col-25">
        <input type="text" class="form-control" id="investigator" name="investigator" style="text-align:center;"
        autocomplete="off" placeholder="" value="<?= $data['investigator']?>">
      </div>
    </div>

    <!-- 3rd row -->
    <div class="row">
      <div class="col-25">
        <div style="margin-left:10px;">
          <label for="lname">Status Kes</label>
        </div>
      </div>
      <div class="col-25">
        <select id="case_status" name="case_status" style="margin-top: 6px;text-align: center;">
            <option value="<?= $data['case_status']?>"><?= $data['case_status']?></option>
            <option value="MSK">MSK</option>
            <option value="S">S</option>
            <option value="SS">SS</option>
            <option value="TB">TB</option>
        </select> 
      </div>

      <div class="col-25">
        <div style="margin-left:10px;">
          <label for="lname">Keputusan</label>
        </div>
      </div>
      <div class="col-25">
        <input type="text" class="form-control" id="keputusan" name="keputusan" style="text-align:center;"
        autocomplete="off" placeholder="" value="<?= $data['keputusan']?>">
      </div>
    </div>

    <div class="row">
      <div class="col-25">
        <div style="margin-left:10px;">
          <label for="lname">Kesalahan/Fakta/Kes/Lokasi</label>
        </div>
      </div>
      <div class="col-75">
        <input type="text" class="form-control" id="case_details" name="case_details" 
        autocomplete="off" placeholder="" value="<?= $data['case_details']?>">
      </div>
    </div>

    <div class="row">
      <div class="col-25">
      <div style="margin-left:10px;">
        <label for="subject">Notes</label>
        </div>
      </div>
      <div class="col-75">
        <textarea class="form-control" id="notes_1" name="notes_1" 
        autocomplete="off" style="height:100px"><?= $data['notes_1']?></textarea>
      </div>
    </div>
</div>

<div class="header" style="height: 30px;">
<h6><b> Part 2: Number of people arrested and convicted</b> </h6>
</div>

<div class="container">
    <div class="row">
      <div class="col-25">
      <div style="margin-left:10px;">
        <label for="lname">Status of People Arrested</label>
      </div>
      </div>
      <div class="col-25">
        <select id="arrested_people_status" name="arrested_people_status" style="margin-top: 6px;text-align: center;">
            <option value="<?= $data['arrested_people_status']?>"><?= $data['arrested_people_status']?></option>
            <option value="Convicted By Court">Convicted By Court</option>
            <option value="Not Charged">Not Charged</option>
            <option value="Pending Court">Pending Court</option>
            <option value=''></option>
        </select> 
      </div>


      <div class="col-25">
      <div style="margin-left:10px;">
        <label for="NoOfLocal" class="form-label ">Number of Local Involved:</label>
      </div>
      </div>
      <div class="col-25">
        <input type="text" class="form-control" id="num_local_people" name="num_local_people" 
        autocomplete="off" placeholder="" value="<?= $data['num_local_people']?>">
      </div>
    </div>

    <div class="row">
      <div class="col-25">
      <div style="margin-left:10px;">
      <label for="NoOfNonLocal" class="form-label">Number of Non-Local Involved:</label>
      </div>
      </div>
      <div class="col-25">
        <div style="margin:auto;">
          <input type="text" class="form-control" id="num_nonlocal_people" name="num_nonlocal_people" 
          autocomplete="off" placeholder="" value="<?= $data['num_nonlocal_people']?>">
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-25">
      <div style="margin-left:10px;">
        <label for="notesF2" class="form-label">Notes:</label>
      </div>
      </div>
      <div class="col-75">
        <textarea class="form-control" id="notes_2" name="notes_2"
        autocomplete="off" style="height:100px" ><?= $data['notes_2']?></textarea>
      </div>
    </div>

    <div class="row">
      <input class="button-2"style= "float:left;" type="submit" name="previous" value="Previous">  
      <input class="button-2" style= "float:right;" type="submit" name="next" value="Next" >  
    </div>
  </form>
</div>


<?php
include'add_footer.php';
?>
