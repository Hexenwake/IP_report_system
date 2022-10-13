<?php
include'header.php';
include'function.php';
if(empty($data['year'])){
    $data['year'] = 'Overall';
}

$sql = "SELECT substring(substring_index(no_ip, '/', -1), 1, 4) as a_year, COUNT(*) AS num_year FROM `dbip.reported_cases` WHERE `no_ip` NOT LIKE 'kdt' GROUP BY a_year";
$result = mysqli_query($conn, $sql);

if(isset($_POST['filter'])){
    if(!empty($_POST['year'])){
      $data['year'] = $_POST['year'];
      $year = $_POST['year'];
      $res = mysqli_query($conn, "SELECT DISTINCT `year`, `type_of_offenses`, SUM(num_of_offenses) AS num_off
      FROM (
        SELECT * FROM `dbip.old_nature_of_offenses` 
        UNION ALL 
        SELECT substring(substring_index(no_ip, '/', -1), 1, 4) AS `year`, `offenses_nature`, COUNT(offenses_nature) AS `num_offenses` 
        FROM `dbip.offenses_nature` 
        GROUP BY `offenses_nature`
      ) AS `t`
      WHERE `year` = '$year' GROUP BY `type_of_offenses`");
    }else{
      $data['year'] = '';
      $res = mysqli_query($conn, "SELECT DISTINCT `year`, `type_of_offenses`, SUM(num_of_offenses) AS `num_off` 
            FROM (
                SELECT * FROM `dbip.old_nature_of_offenses`

                UNION ALL

                SELECT substring(substring_index(no_ip, '/', -1), 1, 4) AS `year`, `offenses_nature`, COUNT(offenses_nature) AS `num_offenses` 
                FROM `dbip.offenses_nature` 
                GROUP BY `offenses_nature`
            ) AS `t`
            GROUP BY `type_of_offenses`"); 
    }
  }else{
    $res = mysqli_query($conn, "SELECT DISTINCT `year`, `type_of_offenses`, SUM(num_of_offenses) AS `num_off` 
            FROM (
                SELECT * FROM `dbip.old_nature_of_offenses`

                UNION ALL

                SELECT substring(substring_index(no_ip, '/', -1), 1, 4) AS `year`, `offenses_nature`, COUNT(offenses_nature) AS `num_offenses` 
                FROM `dbip.offenses_nature` 
                GROUP BY `offenses_nature`
            ) AS `t`
            GROUP BY `type_of_offenses`"); 
  }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="print.css" media="print">

    <!-- reported cases graph -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(yearly_reported_cases);
      google.charts.setOnLoadCallback(seizure_pf_machineries);
      google.charts.setOnLoadCallback(logs_seizures);
      google.charts.setOnLoadCallback(timber_seizures);
      google.charts.setOnLoadCallback(nature_of_offences);
      
      function yearly_reported_cases() {
        var tempdata = 
        <?php 
            if(mysqli_num_rows($result)>0){
                $arrayData = array();
                $arrayData[] = array(
                    '0' => "Year", 
                    '1' => "Reported Cases", 
                );
              
                while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
                    $arrayData[] = array(
                        '0' =>  $row['a_year'],
                        '1' =>  (double)$row['num_year'],
                    );       
                }
                echo json_encode($arrayData);
            }          
        ?>;          
        var data  = google.visualization.arrayToDataTable(tempdata);
        var view = new google.visualization.DataView(data);
         view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       ]);

        var options = {
            title: 'Reported Cases',
            'width': '100%',
            'height':400,
            // width: 1500,
            // height: 20,
            // bar: {groupWidth: "95%"},
            // legend: { position: "none" },
            // chartArea:{
            //     left:50,
            //     top: 20,
            //     width: '99%',
            //     height: '80%',
            // },
          
        };
        var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
        chart.draw(view, options);
      }

      function seizure_pf_machineries() {
        var tempdata = 
        <?php
            $sql_dbip_seized ="SELECT * FROM `dbip.number_of_machine_seized` GROUP BY `year` ";
            $result_dbip_seized = mysqli_query($conn,$sql_dbip_seized);

            //---------new number of people arrested-----------//
            $query_new = "SELECT substring(substring_index(no_ip, '/', -1), 1, 4) AS `year`, SUM(num_seized) AS `total_seized`, SUM(num_forfeited) AS `total_forfeited` FROM `dbip.seizure_machine_equip` GROUP BY `year`";
            $result_new = mysqli_query($conn, $query_new);
            
            if(mysqli_num_rows($result_dbip_seized)>0){
                $arrayData = array();
                $arrayData[] = array(
                    '0' => "Year", 
                    '1' => "No. of Total Seized", 
                    '2' => "No. of Forfeited/Auctioned", 
                );
              
                while($row = mysqli_fetch_array($result_dbip_seized,MYSQLI_ASSOC)){
                    $arrayData[] = array(
                        '0' =>  $row['year'],
                        '1' =>  (int)$row['total_seized'],
                        '2' => (int)$row['forfeited'],
                    );       
                }

                while($row_new = mysqli_fetch_array($result_new)){
                    $arrayData[] = array(
                        '0' =>  $row_new['year'],
                        '1' =>  (int)$row_new['total_seized'],
                        '2' => (int)$row_new['total_forfeited'],
                    ); 
                }
                echo json_encode($arrayData);
            }          
        ?>;
           
        var data  = google.visualization.arrayToDataTable(tempdata);
    
       var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2,
                       { calc: "stringify",
                         sourceColumn: 2,
                         type: "string",
                         role: "annotation" },]);

        var options = {
            colors: ['#0072f0', '#00b6cb'], 
            'width':'100%',
            'height':400,   
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('seizure_pf_machineries'));
        chart.draw(view, options);
      }

      function logs_seizures() {
        var tempdata = 
        <?php
            $result = mysqli_query($conn, "SELECT * FROM `dbip.number_of_log_seized` WHERE `type` = 'Logs' GROUP BY `year`"); 

            if(mysqli_num_rows($result)>0){
                $arrayData = array();
                $arrayData[] = array(
                    '0' => "Year", 
                    '1' => "No. of Pieces", 
                    '2' => "Volume (m3)", 
                );
              
                while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
                    $arrayData[] = array(
                        '0' =>  $row['year'],
                        '1' =>  (int)$row['no_pieces'],
                        '2' => (double)$row['volume'],
                    );       
                }
                //---------new number of people arrested-----------//
                $query_new = "SELECT substring(substring_index(no_ip, '/', -1), 1, 4) AS `year`, SUM(num_logs) AS `total_logs`, SUM(volume) AS `total_volume`  FROM `dbip.seizure_log` WHERE `num_converted_timber`= 0 GROUP BY `year`";
                $result_new = mysqli_query($conn, $query_new);
                while($row_new = mysqli_fetch_array($result_new)){
                    $arrayData[] = array(
                        '0' =>  $row_new['year'],
                        '1' =>  (int)$row_new['total_logs'],
                        '2' => (int)$row_new['total_volume'],
                    ); 
                }
                echo json_encode($arrayData);
            }          
        ?>;
           
        var data  = google.visualization.arrayToDataTable(tempdata);
    
       var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2,
                       { calc: "stringify",
                         sourceColumn: 2,
                         type: "string",
                         role: "annotation" },]);

        var options = {
            colors: ['#0072f0', '#00b6cb'],
            'width':'100%',
            'height':400,
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('logs_seizures'));
        chart.draw(view, options);
      }

      function timber_seizures() {
        var tempdata = 
        <?php
            $result = mysqli_query($conn, "SELECT * FROM `dbip.number_of_log_seized` WHERE `type` = 'Converted Timber' GROUP BY `year`"); 
            if(mysqli_num_rows($result)>0){
                $arrayData = array();
                $arrayData[] = array(
                    '0' => "Year", 
                    '1' => "No. of Pieces", 
                    '2' => "Volume (m3)", 
                );
              
                while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
                    $arrayData[] = array(
                        '0' =>  $row['year'],
                        '1' =>  (int)$row['no_pieces'],
                        '2' => (double)$row['volume'],
                    );       
                }
                

                //---------new number of people arrested-----------//
                $query_new = "SELECT substring(substring_index(no_ip, '/', -1), 1, 4) AS `year`, SUM(num_converted_timber) AS `total_timber`, SUM(volume) AS `total_volume` FROM `dbip.seizure_log` WHERE `num_logs`= 0 GROUP BY `year`";
                $result_new = mysqli_query($conn, $query_new);
                while($row_new = mysqli_fetch_array($result_new)){
                    $arrayData[] = array(
                        '0' =>  $row_new['year'],
                        '1' =>  (int)$row_new['total_timber'],
                        '2' => (int)$row_new['total_volume'],
                    ); 
                }
                
                echo json_encode($arrayData);
            }          
        ?>;
           
        var data  = google.visualization.arrayToDataTable(tempdata);
    
       var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2,
                       { calc: "stringify",
                         sourceColumn: 2,
                         type: "string",
                         role: "annotation" },]);

        var options = {
            
            colors: ['#0072f0', '#00b6cb'],
            'width':'100%',
            'height':400,
           
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('timber_seizures'));
        chart.draw(view, options);
      }

      function nature_of_offences() {

        var data = google.visualization.arrayToDataTable([
        ['Type of Offenses','Total'],
        <?php 

            while($row = mysqli_fetch_array($res)){
                echo "['".$row['type_of_offenses']."',".$row['num_off']."],";
            }

        ?> 
        ]);

        var view = new google.visualization.DataView(data);
         view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       ]);
       
        var options1 = {
            //title: 'NATURE OF OFFENCES',
            width: '50%',
            height: 400,
            hAxis : { 
                textStyle : {
                    fontSize: 7 // or the number you want
                }
            },
            chartArea:{
                left:50,
                top: 20,
                width: '50%',
                height: '90%',
            },
        };
        var chart1 = new google.visualization.PieChart(document.getElementById('piechart_nature_of_offences'));

        chart1.draw(data, options1);


        var options2 = {
           //title: 'NATURE OF OFFENCES',
           width: 750,
           height: 400,
           bar: { groupWidth: "90%" },
           hAxis : { 
                textStyle : {
                    fontSize: 9,

                }
            },
            vAxis : { 
                textStyle : {
                    fontSize: 10,
                    // bold:true;
                },
            },
            chartArea:{
                left:200,
                top: 20,
                width: '90%',
                height: '90%',
            },
        };

        
        var chart2 = new google.visualization.BarChart(document.getElementById('barchart_div_nature_of_offences'));

        chart2.draw(view, options2);
      }

    </script>
    
</head>
<body>

<div id="printableArea">
    <!-- <div class="container_report"> -->
        
        <div class='container_report_title' style='background-color: #f2f2f2;'>
            <div class="report_header_con">
                <img src="images/report_header_title.png" style="width:50%;height:60px;">
            </div>


            <div class='container_graph'>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                    <div class="report_header_con"><h3 class="report_header">NATURE OF OFFENCES</h1></div>
                    <div class="row" style="background-color: white;">
                        <div class="col-0" >
                            <p style="font-family:Verdana, serif;" >Year:</p>
                        </div>

                        <div class="col-0">
                            <select name='year' id= 'year' style="margin-top: 6px;text-align: center;">
                                <option value='<?php $data['year'] ?>'><?php echo $data['year']?></option>
                                <?php
                                    $result = mysqli_query($conn, "SELECT DISTINCT `year` FROM `dbip.old_nature_of_offenses` GROUP BY `year` 
                                                                    UNION ALL
                                                                    SELECT DISTINCT substring(substring_index(no_ip, '/', -1), 1, 4) AS `year`
                                                                    FROM `dbip.offenses_nature` 
                                                                    GROUP BY `year`");
                                    while($row = mysqli_fetch_array($result,MYSQLI_ASSOC) ){
                                        echo "<option value = ".$row['year'].">".$row['year']."</option>";
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="col-25">
                            <input class="button-2"  style="margin-top: 6px;" type=submit name="filter" value="Filter">
                        </div>
                        
                    </div>

                    <div class="row" style="background-color: white;">
                        <div style="width:50%;float:left;">
                            <div id="barchart_div_nature_of_offences" ></div>
                        </div>

                        <div style="width:50%;float:left;">
                            <div id="piechart_nature_of_offences"></div>
                        </div>
                    </div>
                </form>
            </div>

            <div class='container_graph'>
                <div class="report_header_con">
                    <h3 class="report_header">YEARLY NUMBER OF REPORTED CASES</h3>
                </div>
                <div id="columnchart_values" class = "example-screen"></div>
            </div>

            <div class='container_graph' style='margin-bottom: 100px;'>
                <div class="report_header_con"><h3 class="report_header">NUMBER OF PEOPLE ARRESTED AND CONVICTED</h1></div>
                <div class="container_table">
                    <table class="table_update">
                        <tr>
                            <th>Status</th>
                            <?php
                                //---------old number of people arrested-----------//
                                $query = "SELECT * FROM `dbip.number_of_people_arrested` GROUP BY `year`";
                                $result = mysqli_query($conn, $query);
                                while($row = mysqli_fetch_array($result)){
                                    echo '<td style="border-top: 1px solid black;border-bottom: 1px solid black;">'.$row['year']."</td>";
                                }
                                
                                //---------new number of people arrested-----------//
                                $query = "SELECT substring(substring_index(no_ip, '/', -1), 1, 4) AS `year` FROM `dbip.people_arrested` GROUP BY `year`";
                                $result = mysqli_query($conn, $query);
                                while($row = mysqli_fetch_array($result)){
                                    echo '<td style="border-top: 1px solid black;border-bottom: 1px solid black;">'.$row['year']."</td>";
                                }
                            ?>
                        </tr>
                        <tr>
                            <th style='border-right: 1px solid black;border-top: 1px solid black;'>Convicted By Court</th>
                            <?php
                                //---------old number of people arrested-----------//
                                $query = "SELECT * FROM `dbip.number_of_people_arrested` WHERE `status_arrested`='Convicted By Court' GROUP BY `year`";
                                $result = mysqli_query($conn, $query);
                                while($row = mysqli_fetch_array($result)){
                                    echo '<td style="border-top: 1px solid black;border-bottom: 1px solid black;">'.$row['total_people']."</td>";
                                }
                                

                                //---------new number of people arrested-----------//
                                $query_new = "SELECT substring(substring_index(no_ip, '/', -1), 1, 4) AS `year`, (num_local_people + num_nonlocal_people) AS `total` FROM `dbip.people_arrested` WHERE `arrested_people_status`='Convicted By Court' GROUP BY `year`";
                                $result_new = mysqli_query($conn, $query_new);
                                while($row_new = mysqli_fetch_array($result_new)){
                                    echo '<td style="border-top: 1px solid black;border-bottom: 1px solid black;">'.$row_new['total']."</td>";
                                }
                            ?>
                        </tr>
                        <tr>
                            <th style='border-right: 1px solid black;'>Not Charged</th>
                            <?php
                                $query = "SELECT * FROM `dbip.number_of_people_arrested` WHERE `status_arrested`='Not Charged' GROUP BY `year`";
                                $result = mysqli_query($conn, $query);
                                while($row = mysqli_fetch_array($result)){
                                    echo '<td style="border-top: 1px solid black;border-bottom: 1px solid black;">'.$row['total_people']."</td>";
                                }

                                //---------new number of people arrested-----------//
                                $query_new = "SELECT substring(substring_index(no_ip, '/', -1), 1, 4) AS `year`, (num_local_people + num_nonlocal_people) AS `total` FROM `dbip.people_arrested` WHERE `arrested_people_status`='Not Charged' GROUP BY `year`";
                                $result_new = mysqli_query($conn, $query_new);
                                while($row_new = mysqli_fetch_array($result_new)){
                                    echo '<td style="border-top: 1px solid black;border-bottom: 1px solid black;">'.$row_new['total']."</td>";
                                }
                            ?>
                        </tr>
                        <tr>
                            <th style='border-right: 1px solid black;'>Pending</th>
                            <?php
                                $query = "SELECT * FROM `dbip.number_of_people_arrested` WHERE `status_arrested`='Pending Court' GROUP BY `year`";
                                $result = mysqli_query($conn, $query);
                                while($row = mysqli_fetch_array($result)){
                                    echo '<td style="border-top: 1px solid black;border-bottom: 1px solid black;">'.$row['total_people']."</td>";
                                }

                                //---------new number of people arrested-----------//
                                $query_new = "SELECT substring(substring_index(no_ip, '/', -1), 1, 4) AS `year`, (num_local_people + num_nonlocal_people) AS `total` FROM `dbip.people_arrested` WHERE `arrested_people_status`='Pending Court' GROUP BY `year`";
                                $result_new = mysqli_query($conn, $query_new);
                                while($row_new = mysqli_fetch_array($result_new)){
                                    echo '<td style="border-top: 1px solid black;border-bottom: 1px solid black;">'.$row_new['total']."</td>";
                                }
                            ?>
                        </tr>
                        <tr>
                            <th style='border-right: 1px solid black;border-bottom: 1px solid black;'>Grand Total</th>
                            <?php
                                $query = "SELECT `total_people`,SUM(total_people) AS total FROM `dbip.number_of_people_arrested` GROUP BY `year`";
                                $result = mysqli_query($conn, $query);
                                while($row = mysqli_fetch_array($result)){
                                    echo '<td style="border-top: 1px solid black;border-bottom: 1px solid black;">'.$row['total']."</td>";
                                }

                                //---------new number of people arrested-----------//
                                $query_new = "SELECT substring(substring_index(no_ip, '/', -1), 1, 4) AS `year`, SUM(num_local_people + num_nonlocal_people) AS `grand_total` FROM `dbip.people_arrested` GROUP BY `year`";
                                $result_new = mysqli_query($conn, $query_new);
                                while($row_new = mysqli_fetch_array($result_new)){
                                    echo '<td style="border-top: 1px solid black;border-bottom: 1px solid black;">'.$row_new['grand_total']."</td>";
                                }
                            ?>
                        </tr>
                        <tr>
                            <th>Local</th>
                            <?php
                                $query = "SELECT `local` FROM `dbip.number_of_people_arrested` GROUP BY `year`";
                                $result = mysqli_query($conn, $query);
                                while($row = mysqli_fetch_array($result)){
                                    echo "<td>".$row['local']."</td>";
                                }

                                //---------new number of people arrested-----------//
                                $query_new = "SELECT substring(substring_index(no_ip, '/', -1), 1, 4) AS `year`, SUM(num_local_people) AS `total` FROM `dbip.people_arrested` GROUP BY `year`";
                                $result_new = mysqli_query($conn, $query_new);
                                while($row_new = mysqli_fetch_array($result_new)){
                                    echo '<td style="border-top: 1px solid black;border-bottom: 1px solid black;">'.$row_new['total']."</td>";
                                }
                            ?>
                        </tr>
                        <tr>
                            <th>Immigrant</th>
                            <?php
                                $query = "SELECT `immigrant` FROM `dbip.number_of_people_arrested` GROUP BY `year`";
                                $result = mysqli_query($conn, $query);
                                while($row = mysqli_fetch_array($result)){
                                    echo "<td>".$row['immigrant']."</td>";
                                }

                                $query_new = "SELECT substring(substring_index(no_ip, '/', -1), 1, 4) AS `year`, SUM(num_nonlocal_people) AS `total` FROM `dbip.people_arrested` GROUP BY `year`";
                                $result_new = mysqli_query($conn, $query_new);
                                while($row_new = mysqli_fetch_array($result_new)){
                                    echo '<td style="border-top: 1px solid black;border-bottom: 1px solid black;">'.$row_new['total']."</td>";
                                }
                            ?>
                        </tr>
                    </table>
                </div>
            </div>

            <div class='container_graph' >
                <div class="report_header_con"><h3 class="report_header">SEIZURES OF LOGGING MACHINERIES: EQUIPMENT/MOTOR VEHICLES/SCOWS/BARGES/BOATS/SAWS/ACCESSORIES/TOOL, ETC.</h1></div>
                <div id="seizure_pf_machineries" class = "example-screen"></div>
            </div>

            <div class='container_graph'>
                <div class="report_header_con"><h3 class="report_header">LOGS SEIZURES (Excluding Minor Forest Products - Poles, Rattan, Etc)</h1></div>
                <div id="logs_seizures" class = "example-screen"></div>
            </div>

            <div class='container_graph' style='margin-bottom: 100px;'>
                <div class="report_header_con"><h3 class="report_header">CONVERTED TIMBER SEIZURES (Excluding Minor Forest Products - Poles, Rattan, Etc)</h1></div>
                <div id="timber_seizures" class = "example-screen"></div>
            </div>


            <div class='container_table'>
                <div class="row">
                    <div style="width:50%;float:left;border:1px solid black;">   <!-- VALUE OF GOODS AUCTIONED OFF-->
                        <div class="report_header_con"><h3 class="report_header">VALUE OF GOODS AUCTIONED OFF</h1></div>

                        <div class="container_table">
                            <div class= "row" >
                                    <table class="table_update">
                                        <tr class="header">
                                            <th>Year</th>
                                            <th>Logs (m3)</th>
                                            <th>Value (RM)</th>
                                            <th>Equipments</th>
                                            <th>Value (RM)</th>
                                        </tr>
                            
                                        <?php
                                            $total_logs = $total_log_value = $total_equipment = $total_equipment_value = 0;
                                            $sql = "SELECT * FROM `dbip.old_value_of_seizure` GROUP BY `year`";
                                            $result = mysqli_query($conn, $sql);
                                            while($row = mysqli_fetch_array($result)){
                                                $total_logs = $total_logs + $row['log_volume'];
                                                $total_log_value = $total_log_value + $row['value_logs'];
                                                $total_equipment = $total_equipment + $row['no_equipment'];
                                                $total_equipment_value = $total_equipment_value + $row['value_equipment'];
                                                echo '<tr>';
                                                echo '<td>'.$row['year']."</td>";
                                                echo '<td>'.$row['log_volume']."</td>";
                                                echo '<td>'.$row['value_logs']."</td>";
                                                echo '<td>'.$row['no_equipment']."</td>";
                                                echo '<td>'.$row['value_equipment']."</td>";
                                                echo '</tr>';
                                            }

                                            echo '<tr class="header">';
                                            echo '<td>'."Grand Total"."</td>";
                                            echo '<td>'.$total_logs."</td>";
                                            echo '<td>'.$total_log_value."</td>";
                                            echo '<td>'.$total_equipment."</td>";
                                            echo '<td>'.$total_equipment_value."</td>";
                                            echo '</tr>';


                                        ?>
                                    </table>
                            </div>
                        </div>

                    </div>

                    <div style="width:50%;float:right;border:1px solid black;"> <!-- FINES & PENALTIES COLLECTION -->
                        <div class="report_header_con"><h3 class="report_header">FINES & PENALTIES COLLECTION</h1></div>

                        <div class="container_table">
                            <div class= "row" >
                                    <table class="table_update">
                                        <tr class="header">
                                            <th>Year</th>
                                            <th>Total (RM)</th>
                                        </tr>
                            
                                        <?php
                                            $sql = "SELECT * FROM `dbip.old_fine_collection` GROUP BY `year`";
                                            $result = mysqli_query($conn, $sql);
                                            while($row = mysqli_fetch_array($result)){
                                                echo '<tr>';
                                                echo '<td>'.$row['year']."</td>";
                                                echo '<td>'.$row['total']."</td>";
                                                echo '</tr>';
                                            }

                                            $query_new = "SELECT substring(substring_index(no_ip, '/', -1), 1, 4) AS `year`, SUM(fines) AS `total` FROM `dbip.fines_collection` GROUP BY `year`";
                                            $result_new = mysqli_query($conn, $query_new);
                                            while($row = mysqli_fetch_array($result_new)){
                                                echo '<tr>';
                                                echo '<td>'.$row['year']."</td>";
                                                echo '<td>'.$row['total']."</td>";
                                                echo '</tr>';
                                            }
                                        ?>

                                        <tr class="header">
                                            <th>Grand Total </th>
                                            <?php
                                                $total_old = 0;
                                                $total_new = 0;
                                                $grand_total = 0;

                                                $sql = "SELECT * FROM `dbip.old_fine_collection` GROUP BY `year`";
                                                $result = mysqli_query($conn, $sql);
                                                while($row = mysqli_fetch_array($result)){
                                                    $total_old = $total_old + $row['total'];
                                                }

                                                $query_new = "SELECT substring(substring_index(no_ip, '/', -1), 1, 4) AS `year`, SUM(fines) AS `total` FROM `dbip.fines_collection` GROUP BY `year`";
                                                $result_new = mysqli_query($conn, $query_new);
                                                while($row = mysqli_fetch_array($result_new)){
                                                    $total_new = $total_new + $row['total'];
                                                }

                                                $grand_total = $total_old + $total_new;
                                                echo '<td>'.$grand_total."</td>";
                                            ?>
                                        </tr>

                                    </table>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
        
        
    <!-- </div> -->
</div>


<div class="container" >
    <div class="row">
        <input class="button-2" style='margin-left: 10%;' type="button" onclick="printDiv('printableArea')" value="Print"/>
    </div>
</div>


</body>
</html>

<?php
    include'footer.php';
?>