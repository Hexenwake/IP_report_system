<?php

include'header.php';
include'function.php';
require_once 'Paginator.class.php';

$limit      = ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 10;
$page       = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
$links      = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 7;


if(isset($_POST['previous_button'])){
    header('Location:homepage.php');
}

if(isset($_POST['next_button'])){
  header('Location:add_second_page.php');
}

if (empty($_SESSION['valueToSearch'])){
    $data['valueToSearch'] = '';
}else{
    $data['valueToSearch'] = $_SESSION['valueToSearch'];
}

if (empty($_SESSION['starting'])){
    $data['starting'] = '';
}else{
    $data['starting'] = $_SESSION['starting'];
}

if (empty($_SESSION['ending'])){
    $data['ending'] = '';
}else{
    $data['ending'] = $_SESSION['ending'];
}

if (empty($_SESSION['search_offenses_nature'])){
    $data['search_offenses_nature'] = '';
}else{
    $data['search_offenses_nature'] = $_SESSION['search_offenses_nature'];
}

if (empty($_SESSION['search_sub_offenses'])){
    $data['search_sub_offenses'] = '';
}else{
    $data['search_sub_offenses'] = $_SESSION['search_sub_offenses'];
}

if(isset($_POST['search'])){
    //check for year range value
    if(!empty($_POST['starting'])){
        $data['starting'] = $_POST['starting'];
        $_SESSION['starting'] = $_POST['starting'];
    }else{
        $data['starting'] = '';
        $_SESSION['starting']='';
    }

    if(!empty($_POST['ending'])){
        $data['ending'] = $_POST['ending'];
        $_SESSION['ending'] = $_POST['ending'];
    }else{
        $data['ending'] = '';
        $_SESSION['ending']='';
    }

    if(!empty($_POST['valueToSearch'])){
        $data['valueToSearch'] = $_POST['valueToSearch'];
        $_SESSION['valueToSearch'] = $_POST['valueToSearch'];
    }else{
        $data['valueToSearch'] = '';
        $_SESSION['valueToSearch']='';
    }

    if(!empty($_POST['search_offenses_nature'])){
        $data['search_offenses_nature'] = $_POST['search_offenses_nature'];
        $_SESSION['search_offenses_nature'] = $_POST['search_offenses_nature'];
    }else{
        $data['search_offenses_nature'] = '';
        $_SESSION['search_offenses_nature']='';
    }

    if(!empty($_POST['search_sub_offenses'])){
        $data['search_sub_offenses'] = $_POST['search_sub_offenses'];
        $_SESSION['search_sub_offenses'] = $_POST['search_sub_offenses'];
    }else{
        $data['search_sub_offenses'] = '';
        $_SESSION['search_sub_offenses']='';
    }

    //retrieve ip containing the offenses search
    
    //---------------------sql function-------------------------//

    if(!empty($_POST['search_sub_offenses'])){
        $search = $_POST['search_sub_offenses'];
        $query = "SELECT * FROM `dbip.reported_cases` INNER JOIN `dbip.offenses_nature` ON `dbip.reported_cases`.`no_ip` = `dbip.offenses_nature`.`no_ip` WHERE `sub_offenses`='$search'";
        $Paginator  = new Paginator( $conn, $query );
        $results    = $Paginator->getData( $limit, $page );
    }
    elseif(!empty($_POST['valueToSearch'] )){
        $valueToSearch = $_POST['valueToSearch'];
        $query = "SELECT * FROM `dbip.reported_cases` WHERE CONCAT(`no_ip`, `investigator` , `case_status`)LIKE '%".$valueToSearch."%'";
        $Paginator  = new Paginator( $conn, $query );
        $results    = $Paginator->getData( $limit, $page );
    }
    elseif(!empty($_POST['starting']) && !empty($_POST['ending'])){
        $start = $_POST['starting'];
        $end = $_POST['ending'];
        $query = "SELECT * FROM `dbip.reported_cases` WHERE substring(substring_index(no_ip, '/', -1), 1, 4) >= '$start' and substring(substring_index(no_ip, '/', -1), 1, 4) <= '$end' ";
        $Paginator  = new Paginator( $conn, $query );
        $results    = $Paginator->getData( $limit, $page );
    }
    elseif(!empty($_POST['starting']) && !empty($_POST['ending']) && !empty($_POST['valueToSearch'])){
        $start = $_POST['starting'];
        $end = $_POST['ending'];
        $valueToSearch = $_POST['valueToSearch'];
        $query = "SELECT * FROM `dbip.reported_cases` WHERE substring(substring_index(no_ip, '/', -1), 1, 4) >= $start and substring(substring_index(no_ip, '/', -1), 1, 4) <= $end and CONCAT(`no_ip`, `investigator` , `case_status`) LIKE '%".$valueToSearch."%'";
        $Paginator  = new Paginator( $conn, $query );
        $results    = $Paginator->getData( $limit, $page );
    }else{
        $query = "SELECT * FROM `dbip.reported_cases`";
        $Paginator  = new Paginator( $conn, $query );
        $results    = $Paginator->getData( $limit, $page );
    }

}elseif(!empty($data['valueToSearch']) && empty($data['starting']) && empty($data['ending'])){
    $valueToSearch = $data['valueToSearch'];
    $query = "SELECT * FROM `dbip.reported_cases` WHERE CONCAT(`no_ip`, `investigator` , `case_status`)LIKE '%".$valueToSearch."%'";
    $Paginator  = new Paginator( $conn, $query );
    $results    = $Paginator->getData( $limit, $page );

}elseif(!empty($data['valueToSearch']) && !empty($data['starting']) && !empty($data['ending'])){
    $valueToSearch = $data['valueToSearch'];
    $start = $data['starting'];
    $end = $data['ending'];
    $query = "SELECT * FROM `dbip.reported_cases` WHERE substring(substring_index(no_ip, '/', -1), 1, 4) >= $start and substring(substring_index(no_ip, '/', -1), 1, 4) <= $end and CONCAT(`no_ip`, `investigator` , `case_status`) LIKE '%".$valueToSearch."%'";
    $Paginator  = new Paginator( $conn, $query );
    $results    = $Paginator->getData( $limit, $page );

}elseif(empty($data['valueToSearch']) && !empty($data['starting']) && !empty($data['ending'])){
    $start = $data['starting'];
    $end = $data['ending'];
    $query = "SELECT * FROM `dbip.reported_cases` WHERE substring(substring_index(no_ip, '/', -1), 1, 4) >= $start and substring(substring_index(no_ip, '/', -1), 1, 4) <= $end ";
    $Paginator  = new Paginator( $conn, $query );
    $results    = $Paginator->getData( $limit, $page );

}else{
    $query = "SELECT * FROM `dbip.reported_cases`";
    $Paginator  = new Paginator( $conn, $query );
    $results    = $Paginator->getData( $limit, $page );
}



if(isset($_POST['refresh'])){
    $_SESSION['valueToSearch'] = '';
    $_SESSION['starting'] = '';
    $_SESSION['ending'] = '';
    $_SESSION['search_sub_offenses'] = '';
    header('Location:update_page.php');
}

?>

<!-- ------- -->
<!-- CONTENT -->
<!-- ------- -->

<div id="printableArea">
<form action="<?php echo $_SERVER['PHP_SELF']?>" class="form-horizontal" method="POST">
    <div class="container" >

        <div class="row">
            <div class="col-0" >
                <input type="text" name="valueToSearch" placeholder="Search Items" autocomplete="off"
                value="<?= $data['valueToSearch']?>">
            </div>
            <div class="col-0" style="margin-left:50px;">
                <p>Year:</p>
            </div>
            <div class="col-0" style="width:150px;">
                <input type="text" name="starting" placeholder="starting year" autocomplete="off"
                value="<?= $data['starting']?>">
            </div>
            <div class="col-0">
                <p>to</p>
            </div>
            <div class="col-0" style="width:150px;">
                <input type="text" name="ending" placeholder="ending year" autocomplete="off"
                value="<?= $data['ending']?>">
            </div>

            
        </div>

        <div class="row">
            <!-- <div class="col-0" style="margin-left:0px;">
                <p>Type of Offenses: </p>
            </div> -->

            <!-- <div class="col-0" style="width:700px;">
                <select id="search_offenses_nature" name="search_offenses_nature" style="text-align:center; ">
                <option value="<?php echo $data['search_offenses_nature']?>"><?php echo $data['search_offenses_nature']?></option>
                    <?php
                        $query_offenses_list = "SELECT * FROM `dbip.offenses_list`";
                        $result = mysqli_query($conn, $query_offenses_list);
                        while($row = mysqli_fetch_array($result)){
                        echo "<option value = '".$row['offenses_name']."'> ". $row['offenses_name']." </option>";
                        }
                    ?>
                </select>
            </div> -->

            <div class="col-0" style="margin-left:0px;">
                <p>Sub Offenses: </p>
            </div>

            <div class="col-0" style="width:300px;">
                <select id="search_sub_offenses" name="search_sub_offenses" style="text-align:center; ">
                <option value="<?php echo $data['search_sub_offenses']?>"><?php echo $data['search_sub_offenses']?></option>
                    <?php
                        $query_offenses_list = "SELECT * FROM `dbip.sub_offenses`";
                        $result = mysqli_query($conn, $query_offenses_list);
                        while($row = mysqli_fetch_array($result)){
                        echo "<option value = '".$row['sub_offenses_name']."'> ". $row['sub_offenses_name']." </option>";
                        }
                    ?>
                </select>
            </div>
        </div>

        <div class="row">
            <input style="float:left;" class="button-2" type="submit" name="search" value="Filter">
            <input style="float:left;margin-left:20px;" class="button-2" type="submit" name="refresh" value="Refresh">     
        </div>

    
        <div class="row">
            <?php if($results->total): ?>
                <div class="col-0" style="margin-left:10px;">
                    <p>Total Number of Cases:</p>
                </div>
                <div class="col-0" style="margin-left:30px;">
                    <p><strong><?php echo $results->total; ?></strong></p>
                </div>
            <?php endif; ?>
        </div>

        
        
            <div class="container">
                <div class= "row" >
                    <div style="overflow-x:auto;">
                        <table>
                        <?php echo $Paginator->createLinks( $links, 'pagination pagination-sm' ); ?>
                            <thead>
                                <tr class="header">
                                    <th>NO. IP</th>
                                    <th>TAHUN</th>
                                    <th>KOD DAERAH</th>
                                    <th>PEGAWAI PENYIASAT</th>
                                    <th>FAKTA</th>
                                    <th>STATUS KES</th>
                                    <th>NO. CASE</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($results->data)): ?>
                                    <?php for( $i = 0; $i < count($results->data); $i++ ) : ?>
                                        <tr>
                                            <?php
                                                $year = no_ip_year($results->data[$i]['no_ip']);
                                                $no_ip = trim_no_ip($results->data[$i]['no_ip']);
                                                $district_code = no_ip_district_code($results->data[$i]['no_ip']);
                                            ?>
                                            <td><?php echo $no_ip ?></td>
                                            <td><?php echo $year ?></td>
                                            <td><?php echo $district_code ?></td>
                                            <td><?php echo $results->data[$i]['investigator']; ?></td>
                                            <td><?php echo $results->data[$i]['case_details']; ?></td>
                                            <td><?php echo $results->data[$i]['case_status']; ?></td>
                                            <td><?php echo $results->data[$i]['case_no']; ?></td>

                                            <td>
                                                <div class='container_table'>
                                                    <div class='row'>
                                                        <a class='button-34-edit btn-primary' href='edit/edit_page.php?no_ip=<?php echo $no_ip ?>'><i class='fa fa-pencil'></i></a>
                                                    </div>
                                                    <div class='row'>
                                                        <a class='button-34-delete btn-primary' onclick="return confirm('Are you sure you want to delete this data?');" href='delete/delete_page.php?no_ip=<?php echo $no_ip ?>'><i class='fa fa-trash'></i></a>
                                                    </div>
                                                </div>
                                            </td>
                                            
                                        </tr>
                                    <?php endfor;?>
                                <?php endif;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
</form>

    <div class="container_table">
        <div class= "row">
            <input class="button-2" type="button" onclick="printDiv('printableArea')" value="Print"/>
        </div>
    </div>
    
</div>

<?php
    include'footer.php';
?>