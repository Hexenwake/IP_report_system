<?php
    include'edit_header.php';
    include'../function.php';
    
    if(isset($_GET['no_ip'])){
        $no_ip = $_GET['no_ip'];

        $row = dbip_reported_cases('select', $conn, $no_ip, 0 , 0 , 0 ,0 ,0 ,0, 0, 0);
        // $row['year'] = no_ip_year($row['no_ip']);
        // $row['district_code'] = no_ip_district_code($row['no_ip']);

        $row2 = dbip_people_arrested('select',$conn, $no_ip, 0, 0 , 0 ,0);
        if(empty($row2['arrested_people_status'])){
          $row2['arrested_people_status'] = '';
          $row2['num_local_people'] = '';
          $row2['num_nonlocal_people'] = '';
          $row2['notes_people_arrested'] = '';
        }

        $row3 = dbip_seizure_log('select', $conn, $no_ip, 0, 0, 0, 0 ,0);
        if(empty($row3['num_converted_timber']) && empty($row3['num_logs'])){
          $row3['log_type'] = '';
          $row3['volume'] = '';
          $row3['value_seizure_log'] = '';
          $row3['notes_seizure_log'] = '';
          $row3['num_logs'] = '';
        }elseif($row3['num_logs'] == 0){
          $row3['log_type'] = 'Converted Timber';
          $row3['num_logs'] = $row3['num_converted_timber'];
        }elseif($row3['num_converted_timber'] == 0){
          $row3['log_type'] = 'Logs';
        }

        $row4 = dbip_seizure_machine_equip('select', $conn, $no_ip, 0, 0 , 0 , 0);
        if(empty($row4['value_seizure_machine'])){
          $row4['value_seizure_machine'] = '';
          $row4['num_seized'] = '';
          $row4['num_forfeited'] = '';
          $row4['notes_seizure_machine'] = '';
          $row4['num_forfeited'] = '';
        }

        $row5 = dbip_fines_collection('select', $conn, $no_ip, 0, 0);
        $row6 = dbip_offenses_nature('select', $conn, $no_ip, 0, 0, 0);
        $row7= dbip_cases_image('select', $conn, $row['no_ip'], 0, 0);


        if(empty($row5)){
          $row5['fines'] = '';
          $row5['notes_fines'] = '';
        }

        if(empty($row6)){
          $row6['offenses_nature'] = '';
          $row6['sub_offenses'] = '';
          $row6['notes_offenses_nature'] = '';
        }

        if(empty($row7)){
          $row7['image_upload_path'] = '';
          $row7['notes_cases_image'] = '';
        }
    }

    if(isset($_POST['editForm'])){

      $old_no_ip = $row['no_ip'];

      $old_filename = $row7['image_upload_path'];
      db_delete($conn, $old_no_ip);
    //   $district_code = filter_input(INPUT_POST, 'district_code', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
    //   $year = filter_input(INPUT_POST, 'year', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
    //   //running number starts at 1 for every new year
    //   $sql_count = "SELECT `no_ip`,SUBSTRING_INDEX(SUBSTRING_INDEX(no_ip, '/', 4), '/', -1) AS `run_num` FROM `dbip.reported_cases`  WHERE CONCAT(`no_ip`) LIKE '%".$year."%' ORDER BY `run_num` ";
    //   $i = $j = 1;
    //   $number = 0;
    //   $result = mysqli_query($conn, $sql_count);
    //   while($test = mysqli_fetch_array($result)){
    //     $no_ip = $test['no_ip'];
    //     $run_num = no_ip_run_num($no_ip);
    //     if($run_num != $i && $j==1){
    //       echo $i;
    //       $number = $i;
    //       $j++;
    //     }else{
    //       $number = $i + 1;
    //     }
    //     $i++;
    //   }
    
    //   if($number<=0){
    //     $number = 1;
    //   }


    // $arr = array("JPHTN", $district_code, "KS", $number, $year);
    // $new_no_ip = join("/", $arr);
      $new_no_ip = filter_input(INPUT_POST, 'no_ip', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $p_report_date = filter_input(INPUT_POST, 'p_report_date', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $p_report_no = filter_input(INPUT_POST, 'p_report_no', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $case_no = filter_input(INPUT_POST, 'case_no', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $investigator = filter_input(INPUT_POST, 'investigator', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $case_details = filter_input(INPUT_POST, 'case_details', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $case_status = filter_input(INPUT_POST, 'case_status', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $keputusan = filter_input(INPUT_POST, 'keputusan', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $notes_1 = filter_input(INPUT_POST, 'notes_1', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $arrested_people_status = filter_input(INPUT_POST, 'arrested_people_status', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $num_local_people = filter_input(INPUT_POST, 'num_local_people', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $num_nonlocal_people = filter_input(INPUT_POST, 'num_nonlocal_people', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $notes_2 = filter_input(INPUT_POST, 'notes_2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $log_type = filter_input(INPUT_POST, 'log_type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $num_log = filter_input(INPUT_POST, 'num_log', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $volume = filter_input(INPUT_POST, 'volume', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $value_log = filter_input(INPUT_POST, 'value_log', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $notes_3 = filter_input(INPUT_POST, 'notes_3', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $num_seized = filter_input(INPUT_POST, 'num_seized', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $num_forfeited = filter_input(INPUT_POST, 'num_forfeited', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $value_equipment = filter_input(INPUT_POST, 'value_equipment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $notes_seizure_machine = filter_input(INPUT_POST, 'notes_seizure_machine', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $fines = filter_input(INPUT_POST, 'fines', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $notes_fines = filter_input(INPUT_POST, 'notes_fines', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $offenses_nature = filter_input(INPUT_POST, 'offenses_nature', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $sub_offenses = filter_input(INPUT_POST, 'sub_offenses', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $notes_offenses_nature = filter_input(INPUT_POST, 'notes_offenses_nature', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $notes_cases_image = filter_input(INPUT_POST, 'notes_cases_image', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


      $new_filename = $_FILES["uploadfile"]["name"];
      $new_tempname = $_FILES["uploadfile"]["tmp_name"];
      $new_image_upload_path = "../images/".$new_filename;
      

      if($new_filename != ''){
        // move file to path
        if (move_uploaded_file($new_tempname, $new_image_upload_path)) {
          echo "<h3>  Image uploaded successfully!</h3>";
        } else {
            echo "<h3>  Failed to upload image!</h3>";
        }

        $path = '../images/'.$old_filename;
        chown($path, 666);
        if (unlink($path)) {
            echo 'success';
        } else {
            echo 'fail';
        }

        $filename = $new_filename;
      }else{
        $filename = $old_filename;
      }
      
      
      dbip_reported_cases('insert', $conn, $new_no_ip, $p_report_date, $p_report_no, $case_no, $investigator, $case_details, $case_status, $keputusan, $notes_1);
      dbip_people_arrested('insert', $conn, $new_no_ip, $arrested_people_status, $num_local_people, $num_nonlocal_people, $notes_2);  
      dbip_seizure_log('insert', $conn, $new_no_ip, $num_log, $log_type, $volume, $value_log, $notes_3);
      dbip_seizure_machine_equip('insert', $conn, $new_no_ip, $num_seized, $num_forfeited, $value_equipment, $notes_seizure_machine);
      dbip_fines_collection('insert', $conn, $new_no_ip, $fines, $notes_fines);
      dbip_offenses_nature('insert', $conn, $new_no_ip, $offenses_nature,  $sub_offenses, $notes_offenses_nature); // send to dbip.offenses_nature
      dbip_cases_image('insert', $conn, $new_no_ip, $filename, $notes_cases_image);

      header('Location: ../update_page.php');

    }

    if(isset($_POST['back'])){
        header('Location: ../update_page.php');
    }

    //district db
    $sql_district = "SELECT * FROM `dbip.district_code` ";
    $district = mysqli_query($conn, $sql_district );

?>
<div class="container">
    <form method="POST" action="edit_page.php?no_ip=<?php echo $row['no_ip']?>" enctype="multipart/form-data">
        <h3>Edit Form</h3>
        
          <!-- <div class="row">
              <div class="col-25">
                  <div style="margin-left:10px;">
                      <strong><p style="color:#FF0000">IP NO : <?= $row['no_ip']?></p></strong>
                  </div>
              </div>
          </div>    -->

          <!-- <div class="row">

              <div class="col-25">
                  <div style="margin-left:10px;">
                  <label for="lname">Tahun</label>
                  </div>
              </div>
              <div class="col-25">
                  <input type="text" class="form-control" id="year" name="year" style="text-align:center;"
                  autocomplete="off" placeholder="" value="<?= $row['year']?>">
              </div>


              <div class="col-25">
                  <div style="margin-left:10px;">
                  <label for="district">Daerah</label>
                  </div>
              </div>
              <div class="col-25">
                  <select id="district_code" name="district_code" style="text-align:center;">
                      <?php echo "<option value = ".$row['district_code']."> ". $row['district_code']." </option>"; ?>
                      <?php
                      while($select = mysqli_fetch_array($district)){
                          echo "<option value = '".$select['district_code']."'> ". $select['district']." </option>";
                      }
                      ?> 
                  </select> 
              </div>
          </div> -->

          <!-- Row 1 -->
          <div class="row">
            <div class="col-25">
                <div style="margin-left:10px;">
                <label for="lname">No IP: </label>
                </div>
            </div>
            <div class="col-25">
                <input type="text" id="no_ip" name="no_ip" style="text-align:center;"
                placeholder="" style="text-align:center;" value="<?= $row['no_ip']?>">
            </div>
          </div>

          <!-- Row 2 -->
          <div class="row">
            <div class="col-25">
                <div style="margin-left:10px;">
                <label for="lname">Tarikh Laporan Polis</label>
                </div>
            </div>
            <div class="col-25">
                <input type="date" id="p_report_date" name="p_report_date" style="text-align:center;"
                placeholder="" style="text-align:center;" value="<?= $row['p_report_date']?>">
            </div>

            <div class="col-25">
                <div style="margin-left:10px;">
                <label for="lname">No. Laporan Polis</label>
                </div>
            </div>
            <div class="col-25">
                <input type="text" class="form-control" id="p_report_no" name="p_report_no" style="text-align:center;"
                autocomplete="off" placeholder="" value="<?= $row['p_report_no']?>">
            </div>
          </div>

          
          <!-- Row 3 -->
          <div class="row">
            <div class="col-25">
                <div style="margin-left:10px;">
                <label for="lname">No. Kes/TPR</label>
                </div>
            </div>
            <div class="col-25">
                <input type="text" class="form-control" id="case_no" name="case_no" style="text-align:center;"
                autocomplete="off" placeholder="" value="<?= $row['case_no']?>">
            </div>


            <div class="col-25">
                <div style="margin-left:10px;">
                <label for="lname">Pegawai Penyiasat</label>
                </div>
            </div>
            <div class="col-25">
                <input type="text" class="form-control" id="investigator" name="investigator" style="text-align:center;"
                autocomplete="off" placeholder="" value="<?=$row['investigator']?>">
            </div>
          </div>

          <!-- Row 4 -->
          <div class="row">
            <div class="col-25">
                <div style="margin-left:10px;">
                <label for="lname">Status Kes</label>
                </div>
            </div>
            <div class="col-25">
                <select id="case_status" name="case_status" style="margin-top: 6px;text-align: center;">
                    <option value="<?=$row['case_status']?>"><?=$row['case_status']?></option>
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
                autocomplete="off" placeholder="" value="<?=$row['keputusan']?>">
            </div>
          </div>

          <!-- Row 5 -->
          <div class="row">
            <div class="col-25">
                <div style="margin-left:10px;">
                <label for="lname">Kesalahan/Fakta/Kes/Lokasi</label>
                </div>
            </div>
            <div class="col-75">
                <textarea class="form-control" name="case_details" id="case_details" rows="5"><?= $row['case_details']?></textarea>
            </div>
          </div>
          
          <!-- Row 5 -->
          <div class="row">
            <div class="col-25">
                <div style="margin-left:10px;">
                <label for="lname">Notes</label>
                </div>
            </div>
            <div class="col-75">
                <textarea class="form-control" name="notes_1" id="notes_1" rows="5"><?= $row['notes']?></textarea>
            </div>
          </div>

          <div class="w1-container w3-grey">
          <h6><b> Part 2: Number of poeple arrested and convicted</b> </h6>
          </div>

          <!-- Row 6 -->
          <div class="row">
            <div class="col-25">
              <div style="margin-left:10px;">
                  <label for="lname">Status of People Arrested</label>
              </div>
            </div>

            <div class="col-25">
              <select id="arrested_people_status" name="arrested_people_status" style="margin-top: 6px;text-align: center;">
                  <option value="<?=$row2['arrested_people_status']?>"><?=$row2['arrested_people_status']?></option>
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
                autocomplete="off" placeholder="" value="<?= $row2['num_local_people']?>">
            </div>
          </div>

          <!-- Row 7 -->
          <div class="row">
            <div class="col-25">
              <div style="margin-left:10px;">
              <label for="NoOfNonLocal" class="form-label">Number of Non-Local Involved:</label>
              </div>
            </div>

            <div class="col-25">
                <div style="margin:auto;">
                <input type="text" class="form-control" id="num_nonlocal_people" name="num_nonlocal_people" 
                autocomplete="off" placeholder="" value="<?= $row2['num_nonlocal_people']?>">
                </div>
            </div>
          </div>


          <!-- Row 8 -->
          <div class="row">
            <div class="col-25">
              <div style="margin-left:10px;">
                  <label for="notesF2" class="form-label">Notes:</label>
              </div>
            </div>

            <div class="col-75">
                <textarea class="form-control" id="notes_2" name="notes_2"
                autocomplete="off" style="height:100px" ><?= $row2['notes_people_arrested']?></textarea>
            </div>
          </div>

          <!-- Row 9 -->
          <div class="row">
            <div class="col-25">
              <div style="margin-left:10px;">
                <label for="type">Type</label>
              </div>  
            </div>

            <div class="col-25">
              <select id="log_type" name="log_type" style="text-align: center;margin-top: 6px;">
                  <option value="<?=$row3['log_type']?>"><?=$row3['log_type']?></option>
                  <option value="Logs">Logs</option>
                  <option value="Converted Timber">Converted Timber</option>
              </select>
            </div>
            <div class="col-25">
              <div style="margin-left:10px;">
                <label for="pieces">Number of pieces</label>
              </div>
            </div>

            <div class="col-25">
              <input type="text" id="num_log" name="num_log" 
              autocomplete="off" placeholder="" value="<?=$row3['num_logs']?>">
            </div>
          </div>

          <!-- Row 10 -->
          <div class="row">
            <div class="col-25">
              <div style="margin-left:10px;">
                <label for="volume">Volume of Logs (m3)</label>
              </div>
            </div>
            <div class="col-25">
              <input type="text" id="volume" name="volume" 
              autocomplete="off" placeholder="" value="<?=$row3['volume']?>">
            </div>

            <div class="col-25">
              <div style="margin-left:10px;">
                <label for="valueLog">Value of Logs</label>
              </div>
            </div>
            <div class="col-25">
              <input type="text" id="value_log" name="value_log"
              autocomplete="off" placeholder="" value="<?=$row3['value_seizure_log']?>">
            </div>
          </div>

          <!-- Row 10 -->
          <div class="row">
            <div class="col-25">
            <div style="margin-left:10px;">
              <label for="noteF3">Notes</label>
            </div>
            </div>
            <div class="col-75">
              <textarea type="text" id="notes_3" name="notes_3" 
              autocomplete="off" style="height:100px" ><?= $row3['notes_seizure_log']?></textarea>
            </div>
          </div>

          <div class="w1-container w3-grey">
            <h6>Form 4 Equipment Seizures</h6>
          </div>

          <!-- equipments seizures entry -->
          <!-- Row 10 -->
          <div class="row">
            <div class="col-25">
              <div style="margin-left:10px;">
                <label for="equipment">Number of Equipment suizeres</label>
              </div>
            </div>
            <div class="col-25">
              <input type="text" id="num_seized" name="num_seized" 
              autocomplete="off" placeholder="" value="<?= $row4['num_seized']?>">
            </div>

            <div class="col-25">
              <div style="margin-left:10px;">
                <label for="forfeited">Number of Forfeited/Auctioned</label>
              </div>
            </div>
            <div class="col-25">
              <input type="text" id="num_forfeited" name="num_forfeited" 
              autocomplete="off" placeholder="" value="<?= $row4['num_forfeited']?>">
            </div>
          </div>

          <!-- Row 11 -->
          <div class="row">
            <div class="col-25">
              <div style="margin-left:10px;">
                <label for="valueEquipment">Value of Equipment</label>
              </div>
            </div>
            <div class="col-25">
              <input type="text" id="value_equipment" name="value_equipment"
              autocomplete="off" placeholder="" value="<?= $row4['value_seizure_machine']?>">
            </div>
          </div>

          <!-- Row 12 -->
          <div class="row">
            <div class="col-25">
              <div style="margin-left:10px;">
                <label for="noteF4">Notes</label>
              </div>
            </div>
            <div class="col-75">
              <textarea type="text" id="notes_seizure_machine" name="notes_seizure_machine" 
              autocomplete="off" style="height:100px" ><?= $row4['notes_seizure_machine']?></textarea>
            </div>
          </div>

          <!-- Row 13 -->
          <div class="row">
            <div class="col-25">
              <label for="fines">Fines Values</label>
            </div>
            <div class="col-25">
              <input type="text" id="fines" name="fines" 
              autocomplete="off" placeholder="" value="<?= $row5['fines']?>">
            </div>
          </div>

          <!-- Row 14 -->
          <div class="row">
            <div class="col-25">
              <label for="notes_fines">Notes</label>
            </div>
            <div class="col-75">
              <textarea id="notes_fines" name="notes_fines" 
              autocomplete="off" style="height:50px" ><?= $row5['notes_fines']?></textarea>
            </div>
          </div>

          <!-- nature of offense entry -->
          <div class="w1-container w3-grey">
            <h6>Nature of Offenses</h6>
          </div>

          <div class="row">
            <div class="col-25">
              <label for="country">Type of Offenses</label>
            </div>
            <div class="col-75">
              <select id="offenses_nature" name="offenses_nature" style="text-align:center; ">
              <option value="<?php echo $row6['offenses_nature']?>"><?php echo $row6['offenses_nature']?></option> 
                <?php
                  $query_offenses_code = "SELECT * FROM `dbip.offenses_list`";
                  $result = mysqli_query($conn, $query_offenses_code);
                  while($row = mysqli_fetch_array($result)){
                    echo "<option value ='".$row['offenses_name']."'> ". $row['offenses_name']." </option>";
                  }
                ?>
              </select>
            </div>
          </div>

          <div class="row">
            <div class="col-25">
              <label for="country">Sub-Offenses</label>
            </div>
            <div class="col-75">
              <select id="sub_offenses" name="sub_offenses" style="text-align:center; ">
              <option value="<?php echo $row6['sub_offenses']?>"><?php echo $row6['sub_offenses']?></option> 
                <?php
                  $query_offenses_code = "SELECT * FROM `dbip.sub_offenses`";
                  $result = mysqli_query($conn, $query_offenses_code);
                  while($row = mysqli_fetch_array($result)){
                    echo "<option value ='".$row['sub_offenses_name']."'>". $row['sub_offenses_name']." </option>";
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
              autocomplete="off" style="height:50px" ><?= $row6['notes_offenses_nature']?></textarea>
            </div>
          </div>

          <!-- Cases Image Upload -->
          <div class="w1-container w3-grey">
            <h6>Cases Image Upload</h6>
          </div>

          <div class="row">
            <div class="col-25">
              <label for="image_upload_path">Upload Image</label>
            </div>
            <div class="col-75">
              <input type="file" id="uploadfile" name="uploadfile" 
              autocomplete="off"></input>
            </div>
          </div>

          <div class="row">
            <div class="col-25">
              <label for="notes_cases_image">Notes</label>
            </div>
            <div class="col-75">
              <textarea id="notes_cases_image" name="notes_cases_image" 
              autocomplete="off" style="height:50px" ><?= $row7['notes_cases_image']?></textarea>
            </div>
          </div>

          <div class="row">
            <div class="col-25">
                  <p>Uploaded Images<p>
            </div>
          </div>

          <div class="row">
            <div style="alignment:center;">
              <table>
                <tr>
                  <td><img src="../images/<?php echo $row7['image_upload_path']; ?>"width="150px"height="auto"/></td>
                <tr>
                <tr>
                  <td>
                    <div class='row'>
                        <a class='button-34-edit btn-primary' href='../images/<?php echo $row7['image_upload_path']; ?>' download><i class='fa fa-download'></i></a>
                    </div>
                  </td>
                <tr>
              </table>
            </div>
          </div>

          <div class="row">
              <input class="button-40" type="submit" style= "float:right;" name="editForm" value="submit" onclick="return confirm('Are you sure you want to submit this form?');" class="btn btn-primary btn-block">
              <input class="button-2" type="submit" style= "float:left;" name="back" value="Back"  class="btn btn-primary btn-block">
          </div>
    </form>
</div>
</body>
</html>

<?php
  include'../footer.php';
  ?>
  