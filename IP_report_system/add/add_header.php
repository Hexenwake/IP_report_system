<?php
ob_start(); 
include'../config.php'; 

$admin_id = $_SESSION['id'];

if(!isset($admin_id)){
   header('location:index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" media="print" href="print.css" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
<style>

  body {
    font-family: Verdana, serif;
    }

/* ----------header.php-------------- */
    .sidenav {
      height: 100%;
      width: 0;
      position: fixed;
      z-index: 1;
      top: 0;
      left: 0;
      background-color: #111;
      overflow-x: hidden;
      transition: 0.5s;
      padding-top: 60px;
    }
    
    .sidenav a {
      padding: 8px 8px 8px 32px;
      text-decoration: none;
      font-size: 19px;
      color: #818181;
      display: block;
      transition: 0.3s;
    }
    
    .sidenav a:hover {
      color: #f1f1f1;
    }
    
    .sidenav .closebtn {
      position: absolute;
      top: 0;
      right: 25px;
      font-size: 36px;
      margin-left: 50px;
    }
    
    @media screen and (max-height: 450px) {
      .sidenav {padding-top: 15px;}
      .sidenav a {font-size: 18px;}
    }
    
    .navbar {
      width: 100%;
      background-color: #555;
      overflow: auto;
    }
    
    /* Navbar links */
    .navbar_a {
      float: left;
      text-align: center;
      padding: 12px;
      color: white;
      text-decoration: none;
      font-size: 10px;
    }
    
    /* Navbar links on mouse-over */
    .active, .navbar_a:hover {
      background-color: #000;
    }

    .header_deco{
      background-color: #0b1b63;
    }
    
    /* Current/active navbar link
    .active {
    background-color: #000;
    } */
    
    /* Add responsiveness - will automatically display the navbar vertically instead of horizontally on screens less than 500 pixels */
    @media screen and (max-width: 500px) {
        .navbar a {
        float: none;
        display: block;
      }
    }

  /* Style the buttons */
  .button {
    border: none;
    outline: none;
    float: left;
    text-align: center;
    padding: 12px;
    color: white;
    text-decoration: none;
    background-color: #555;
    cursor: pointer;
    font-size: 17px;
  }
  /* -----------------report.php------------------ */
  .report_header_con{
    border-radius: 0px;
    margin-top: 0px;
    margin-bottom: 0px;
    text-align:center;
    background-color: #333333;
  }
  

  .report_header{
    color:white;
    font-family: Georgia, serif;
    font-size: 17px;
    margin: auto;
  }

  .left_header{
    color:black;
    font-family: Georgia, serif;
    font-size: 17px;
    margin: auto;
  }

  .middle-header{
    color:black;
    font-family: Georgia, serif;
    font-size: 30px;
    margin: auto;
    
  }

  .example-screen{
    height:85%;
    margin:auto;background-color:white;
    border-style: solid;
    border-color: lightblue;
    margin: auto;
  }

  .container_report_title{
    width: 90%;
    margin-top:20px;
    margin-left:auto;
    margin-right:auto;
    border:1px solid black;
  }

  .container_report {
    border-radius: 0px;
    background-color: #f2f2f2;
    padding: 10px;
  }

  .container_graph{
    width: 80%;
    margin-top:20px;
    margin-left:auto;
    margin-right:auto;
    border:1px solid black;
  }

  .container_table{
    width: 80%;
    margin-top:20px;
    margin-left:auto;
    margin-right:auto;
  }


  .area1{
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    resize: vertical;
    background-color: white;
    }

  /* Style the active class, and buttons on mouse-over */
  .active, .button:hover {
    background-color: #000;
    color: white;
  }

  .btn {
    background-color: DodgerBlue;
    border: none;
    color: white;
    padding: 12px 16px;
    font-size: 16px;
    cursor: pointer;
  }

  /* Darker background on mouse-over */
  .btn:hover {
    background-color: RoyalBlue;
  }

  /* CSS */
  .button-34-edit {
    background: #FFA500;
    border-radius: 999px;
    box-shadow: #5E5DF0 0 10px 20px -10px;
    box-sizing: border-box;
    color: #FFFFFF;
    cursor: pointer;
    font-family: Inter,Helvetica,"Apple Color Emoji","Segoe UI Emoji",NotoColorEmoji,"Noto Color Emoji","Segoe UI Symbol","Android Emoji",EmojiSymbols,-apple-system,system-ui,"Segoe UI",Roboto,"Helvetica Neue","Noto Sans",sans-serif;
    font-size: 16px;
    font-weight: 700;
    line-height: 24px;
    opacity: 1;
    outline: 0 solid transparent;
    padding: 8px 18px;
    user-select: none;
    -webkit-user-select: none;
    touch-action: manipulation;
    width: fit-content;
    word-break: break-word;
    border: 0;
  }

  .button-34-edit:hover {
    background-color: #000000;
  }

  .button-34-delete {
    background: #FF0000;
    border-radius: 999px;
    box-shadow: #5E5DF0 0 10px 20px -10px;
    box-sizing: border-box;
    color: #FFFFFF;
    cursor: pointer;
    font-family: Inter,Helvetica,"Apple Color Emoji","Segoe UI Emoji",NotoColorEmoji,"Noto Color Emoji","Segoe UI Symbol","Android Emoji",EmojiSymbols,-apple-system,system-ui,"Segoe UI",Roboto,"Helvetica Neue","Noto Sans",sans-serif;
    font-size: 16px;
    font-weight: 700;
    line-height: 24px;
    opacity: 1;
    outline: 0 solid transparent;
    padding: 8px 18px;
    user-select: none;
    -webkit-user-select: none;
    touch-action: manipulation;
    width: fit-content;
    word-break: break-word;
    border: 0;
  }

  .button-34-delete:hover {
    background-color: #000000;
  }

  .button-40 {
    background-color: green;
    border: 1px solid transparent;
    border-radius: .75rem;
    box-sizing: border-box;
    color: #FFFFFF;
    cursor: pointer;
    flex: 0 0 auto;
    font-family: "Inter var",ui-sans-serif,system-ui,-apple-system,system-ui,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
    font-size: 1.125rem;
    font-weight: 600;
    line-height: 1.5rem;
    padding: .75rem 1.2rem;
    text-align: center;
    text-decoration: none #6B7280 solid;
    text-decoration-thickness: auto;
    transition-duration: .2s;
    transition-property: background-color,border-color,color,fill,stroke;
    transition-timing-function: cubic-bezier(.4, 0, 0.2, 1);
    user-select: none;
    -webkit-user-select: none;
    touch-action: manipulation;
    width: auto;
  }

  .button-40:hover {
    background-color: #374151;
  }

  .button-40:focus {
    box-shadow: none;
    outline: 2px solid transparent;
    outline-offset: 2px;
  }

  .button-2 {
    background-color: Black;
    border: 1px solid transparent;
    border-radius: .75rem;
    box-sizing: border-box;
    color: #FFFFFF;
    cursor: pointer;
    flex: 0 0 auto;
    font-family: "Inter var",ui-sans-serif,system-ui,-apple-system,system-ui,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
    font-size: 1.125rem;
    font-weight: 600;
    line-height: 1.5rem;
    padding: .75rem 1.2rem;
    text-align: center;
    text-decoration: none #6B7280 solid;
    text-decoration-thickness: auto;
    transition-duration: .2s;
    transition-property: background-color,border-color,color,fill,stroke;
    transition-timing-function: cubic-bezier(.4, 0, 0.2, 1);
    user-select: none;
    -webkit-user-select: none;
    touch-action: manipulation;
    width: auto;
  }

  .button-2:hover {
    background-color: #374151;
  }

  .button-2:focus {
    box-shadow: none;
    outline: 2px solid transparent;
    outline-offset: 2px;
  }

  @media (min-width: 768px) {
    .button-2 {
      padding: .75rem 1.5rem;
    }
  }

  table, th, td {
    border: 1px solid grey;
  }

  .container {
    border-radius: 0px;
    background-color: #f2f2f2;
    padding: 10px;
    font-family: Verdana,serif;
    font-size: 16px;
  }

  .container_header{
    border-radius: 0px;
    background-color: #f2f2f2;
    padding: 10px;
    font-family: Verdana,serif;
    font-size: 16px;
  }

  .container_outer {
    margin: auto;
    width: 80%;
    height: 100%;
    font-family: Verdana,serif;
    font-size: 16px;
    background-color: #0f3284;
    padding: 10px;
  }

  .table_update{
    height:100%;
    background-color: white;
    font-family: Verdana, serif;
  }

  .text_style_1{
    height:100%;
    background-color: white;
    font-family: Verdana, serif;
  }

  .container_table {
    height:15%;
    width:100%;
    margin:auto;
    text-align:center;
    border-radius: 0px;
    background-color: #f2f2f2;
    font-family: Verdana, serif;
    font-size: 13px;
  }

  .container_title {
    height: 20%;
    border-radius: 20px;
    background-color: white;
    padding: 5px;
  }

  .header{
    background-color: #c8e6c9;
  }

  .center{
    /* height: 500px; */
    display: flex;
    align-items: center;
    justify-content: center;
    /* border: 3px solid #dbe4ed; */
  }

  table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    border: 1px solid #ddd;
    font-family: Verdana, serif;
    font-size: 15px;
  }

  img {
    max-width: 100%;
    max-height: 100%;
  }

  @media print {

    body {
      margin: 0;
      color: #000;
      background-color: #fff;
    }
  }

  .box {
    display: flex;
    align-items: stretch;
  }

  ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333333;
  }

  li {
    float: left;
  }

  li a {
    display: block;
    color: white;
    text-align: center;
    padding: 16px;
    text-decoration: none;
  }

  li a:hover {
    background-color: #111111;
  }

  span {
      color: white;
      margin-top: 16px;
      display: inline-block;
  }

  tr:nth-child(even){background-color: #f2f2f2}

</style>
</head>
<body>

<!-- style='background-color: #0b1b63;' -->
<div>
  <img src="../images/test.png" width="100%">
</div>

<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="../district_code.php">Update District Codes</a>
  <a href="../offenses.php">Update Type of Offences</a>
  <a href="../sub_offenses.php">Update Sub Offenses</a>
  <a href="../user_id.php">Update User</a>
</div>

<div class="navbar">
  <div id="myDIV">
    <button class="button" style="font-size:17px;cursor:pointer" onclick="openNav()">&#9776;</button>
    <button class="button" onclick="window.location.href='../homepage.php'"><i class="fa fa-fw fa-home"></i> Home</button>
    <button class="button" onclick="window.location.href='../add/add_first_page.php'"><i class="fa fa-fw fa-plus"></i>Add</button>
    <button class="button" onclick="window.location.href='../update_page.php'"><i class="fa fa-fw fa-pencil"></i> Update</button>
    <button class="button" onclick="window.location.href='../report.php'"><i class="fa fa-fw fa-file"></i> View Reports</button>
    <button class="button-34-delete" style='float:right;margin-top:5px;' onclick="window.location.href='../logout.php'"><i class="fa fa-fw fa-user"></i> Logout</button>
  </div>
</div>