<?php

include'header.php';
include'function.php';
require_once 'Paginator.class.php';

$limit      = ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 10;
$page       = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
$links      = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 7;

$query = "SELECT * FROM `dbip.district_code`";
$Paginator  = new Paginator( $conn, $query );
$results    = $Paginator->getData( $limit, $page );

?>

<div class="container" >

    <div class= "row" style="width:30%;text-align:center;margin:auto;">
        <div style="overflow-x:auto;">
            <table>

                <thead>
                    <tr class="header">
                        <th>Kod Daerah</th>
                        <th>Daerah</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <?php if(!empty($results->data)): ?>
                        <?php for( $i = 0; $i < count($results->data); $i++ ) : ?>
                            <tr>
                                <?php
                                    $code = $results->data[$i]['district_code'];
                                ?>
                                <td><?php echo $results->data[$i]['district_code']; ?></td>
                                <td><?php echo $results->data[$i]['district']; ?></td>
                                <td>
                                    <div class='container_table'>
                                        <div class='row'>
                                            <a class='button-34-edit btn-primary' href='edit/edit_district.php?district_code=<?php echo$code?>'><i class='fa fa-pencil'></i></a>
                                        </div>
                                        <div class='row'>
                                            <a class='button-34-delete btn-primary' onclick="return confirm('Are you sure you want to delete this data?');" href='delete/delete_district.php?district_code=<?php echo$code?>'><i class='fa fa-trash'></i></a>
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

    <div class= "row" style="width:30%;text-align:center;margin:auto;">
        <button class="button-2" onclick="window.location.href='add/add_district.php'">Add</button>
    </div>
</div>

<?php
    include'footer.php';
?>