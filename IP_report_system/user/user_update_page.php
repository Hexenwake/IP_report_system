<?php

include'user_header.php';
include'../function.php';
require_once '../Paginator.class.php';

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

    //---------------------sql function-------------------------//
    
    // if year filter is not null
    if(!empty($_POST['starting']) && !empty($_POST['ending'])){
        $start = $_POST['starting'];
        $end = $_POST['ending'];
        $query = "SELECT * FROM `dbip.reported_cases` WHERE substring(substring_index(no_ip, '/', -1), 1, 4) >= '$start' and substring(substring_index(no_ip, '/', -1), 1, 4) <= '$end' ";
        $Paginator  = new Paginator( $conn, $query );
        $results    = $Paginator->getData( $limit, $page );
    }

    // if search is not null
    if(!empty($_POST['valueToSearch'] )){
        $valueToSearch = $_POST['valueToSearch'];
        $query = "SELECT * FROM `dbip.reported_cases` WHERE CONCAT(`no_ip`, `investigator` , `case_status`)LIKE '%".$valueToSearch."%'";
        $Paginator  = new Paginator( $conn, $query );
        $results    = $Paginator->getData( $limit, $page );
    }

    // if year filter and search is not null
    if(!empty($_POST['starting']) && !empty($_POST['ending']) && !empty($_POST['valueToSearch'])){
        $start = $_POST['starting'];
        $end = $_POST['ending'];
        $valueToSearch = $_POST['valueToSearch'];
        $query = "SELECT * FROM `dbip.reported_cases` WHERE substring(substring_index(no_ip, '/', -1), 1, 4) >= $start and substring(substring_index(no_ip, '/', -1), 1, 4) <= $end and CONCAT(`no_ip`, `investigator` , `case_status`) LIKE '%".$valueToSearch."%'";
        $Paginator  = new Paginator( $conn, $query );
        $results    = $Paginator->getData( $limit, $page );
    }

    if(empty($_POST['valueToSearch']) && empty($_POST['starting']) && empty($_POST['ending'])){
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
    include'user_footer.php';
?>