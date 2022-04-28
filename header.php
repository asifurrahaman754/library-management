<?php 
include "connection.php";
include "utility.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <!-- boostrap style -->
    <link rel="stylesheet" href="<?php echo base_url()?>asset/css/bootstrap.min.css">

    <!-- fontawesome -->
    <link rel="stylesheet" href="<?php echo base_url()?>asset/css/fontawesome.min.css">

    <!-- simple datatables library -->
    <link rel="stylesheet" href="<?php echo base_url()?>asset/css/datatables-style.css">

    <!-- carousel -->
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

    <!-- cusom styles -->
    <link rel="stylesheet" href="<?php echo base_url()?>asset/css/home-style.css">
    <link rel="stylesheet" href="<?php echo base_url()?>asset/css/signup-style.css">
    <link rel="stylesheet" href="<?php echo base_url()?>asset/css/admin-style.css">
    <link rel="stylesheet" href="<?php echo base_url()?>asset/css/user_home.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uuid/8.3.2/uuidv1.min.js"></script>


    <style>
    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }
    </style>
</head>

<body>
    <main>