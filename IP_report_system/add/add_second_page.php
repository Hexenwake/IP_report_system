<?php

include'add_header.php';
include'../function.php';

if(isset($_SESSION['log_type'])){
  $data['log_type'] = $_SESSION['log_type'];
}else{
  $data['log_type'] = '--Choose a Log Type--';
}

if(isset($_SESSION['num_log'])){
  $data['num_log'] = $_SESSION['num_log'];
}else{
  $data['num_log'] = '';
}

if(isset($_SESSION['volume'])){
  $data['volume'] = $_SESSION['volume'];
}else{
  $data['volume'] = '';
}

if(isset($_SESSION['value_log'])){
  $data['value_log'] = $_SESSION['value_log'];
}else{
  $data['value_log'] = '';
}

if(isset($_SESSION['notes_3'])){
  $data['notes_3'] = $_SESSION['notes_3'];
}else{
  $data['notes_3'] = '';
}

if(isset($_SESSION['num_seized'])){
  $data['num_seized'] = $_SESSION['num_seized'];
}else{
  $data['num_seized'] = '';
}

if(isset($_SESSION['num_forfeited'])){
  $data['num_forfeited'] = $_SESSION['num_forfeited'];
}else{
  $data['num_forfeited'] = '';
}

if(isset($_SESSION['value_equipment'])){
  $data['value_equipment'] = $_SESSION['value_equipment'];
}else{
  $data['value_equipment'] = '';
}

if(isset($_SESSION['notes_4'])){
  $data['notes_4'] = $_SESSION['notes_4'];
}else{
  $data['notes_4'] = '';
}

if(isset($_POST['next'])){
  set_data_page_2();
  header('Location:add_third_page.php');
}

if(isset($_POST['previous'])){
  set_data_page_2();
  header('Location:add_first_page.php');
}

?>

  
<div class="w1-container w3-grey">
<h6>Form 3 Logs/Timber Seizures</h6>
</div>

<!-- logs seizures entry -->
<div class="container">
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="form-horizontal" method="POST">    
  <div class="row">
      <div class="col-25">
      <div style="margin-left:10px;">
      <label for="type">Type</label>
      </div>  
      </div>
      <div class="col-25">
        <select id="log_type" name="log_type" style="text-align: center;margin-top: 6px;">
            <option value="<?= $data['log_type']?>"><?= $data['log_type']?></option>
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
        autocomplete="off" placeholder="" value="<?= $data['num_log']?>">
      </div>
    </div>

    <div class="row">
      <div class="col-25">
      <div style="margin-left:10px;">
        <label for="volume">Volume of Logs (m3)</label>
      </div>
      </div>
      <div class="col-25">
        <input type="text" id="volume" name="volume" 
        autocomplete="off" placeholder="" value="<?= $data['volume']?>">
      </div>


      <div class="col-25">
      <div style="margin-left:10px;">
        <label for="valueLog">Value of Logs</label>
      </div>
      </div>
      <div class="col-25">
        <input type="text" id="value_log" name="value_log"
        autocomplete="off" placeholder="" value="<?= $data['value_log']?>">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
      <div style="margin-left:10px;">
        <label for="noteF3">Notes</label>
      </div>
      </div>
      <div class="col-75">
        <textarea type="text" id="notes_3" name="notes_3" 
        autocomplete="off" style="height:100px" ><?= $data['notes_3']?></textarea>
      </div>
    </div>
 
</div>

<div class="w1-container w3-grey">
<h6>Form 4 Equipment Seizures</h6>
</div>

<!-- equipments seizures entry -->
<div class="container">
    <div class="row">
      <div class="col-25">
      <div style="margin-left:10px;">
        <label for="equipment">Number of Equipment suizeres</label>
      </div>
      </div>
      <div class="col-25">
        <input type="text" id="num_seized" name="num_seized" 
        autocomplete="off" placeholder="" value="<?= $data['num_seized']?>">
      </div>

      <div class="col-25">
      <div style="margin-left:10px;">
        <label for="forfeited">Number of Forfeited/Auctioned</label>
      </div>
      </div>
      <div class="col-25">
        <input type="text" id="num_forfeited" name="num_forfeited" 
        autocomplete="off" placeholder="" value="<?= $data['num_forfeited']?>">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
      <div style="margin-left:10px;">
        <label for="valueEquipment">Value of Equipment</label>
      </div>
      </div>
      <div class="col-25">
        <input type="text" id="value_equipment" name="value_equipment"
        autocomplete="off" placeholder="" value="<?= $data['value_equipment']?>">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
      <div style="margin-left:10px;">
        <label for="noteF4">Notes</label>
      </div>
      </div>
      <div class="col-75">
        <textarea type="text" id="notes_4" name="notes_4" 
        autocomplete="off" style="height:100px" ><?= $data['notes_4']?></textarea>
      </div>
    </div>

    <!-- hidden data -->

    <div class="row">
      <input class="button-2" style= "float:left;" type="submit" name="previous" value="Previous">  
      <input class="button-2" style= "float:right;" type="submit" name="next" value="Next" >  
    </div>
    
  </form>
</div>


<!-- JAVASCRIPTS -->
  <script>
    function openNav() {
      document.getElementById("mySidenav").style.width = "250px";
    }

    function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
    }
  </script>

</body>
</html>