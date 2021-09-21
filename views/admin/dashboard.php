<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
session_start();
include("../path.php");
$errors = array();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include(ROOT_PATH . "../../app/includes/adminHead.php"); ?>
        
        <!-- Custom Styling -->
        <link rel="stylesheet" href="../../assets/css/style.css">
        <link rel="stylesheet" href="../../assets/css/style_media.css">

        <!-- Admin Styling -->
        <link rel="stylesheet" href="../../assets/css/admin.css"> 
        <link rel="stylesheet" href="../../assets/css/admin_media.css">

        <title>Admin - Tableau de Bord</title>
    </head>


    <body>
    <!-- Header -->
    <?php include(ROOT_PATH. "../../app/includes/adminheader.php");?>

        <!-- Admin Page Wrapper -->
        <div class="admin-wrapper"> 

            <!-- Left Sidebar -->
            <?php include(ROOT_PATH. "../../app/includes/adminsidebar.php");?>

            <!-- Admin Content -->
            <div class="admin-content">

                <div class="content">
                    <h2 class="page-title">Tableau de Bord</h2>

                    <?php include(ROOT_PATH . '../../app/includes/messages.php'); ?>
                </div>
            </div>
            <!-- // Admin Content -->

        </div>
        <!-- // Admin Page Wrapper -->

        <!-- Foot -->
        <?php include(ROOT_PATH . "../../app/includes/adminFoot.php"); ?>

        <!-- Custom Script -->
        <script src="../../assets/js/scripts.js"></script>

    </body>
</html> 