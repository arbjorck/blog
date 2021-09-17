<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
include("../../path.php");
require_once(ROOT_PATH . "/app/controllers/routeur.php");
require_once(ROOT_PATH . "/app/helpers/middleware.php"); 

    $middleware = new Middleware();
    $adminOnly = $middleware->adminOnly();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
        <!-- Font awesome -->
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

        <!-- Google Font -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

        <!-- Custom Styling -->
        <link rel="stylesheet" href="../../assets/css/style.css">

        <!-- Admin Styling -->
        <link rel="stylesheet" href="../../assets/css/admin.css"> 

        <title>Admin - Ajouter Thème</title>
    </head>


    <body>
    <!-- Header -->
    <?php include(ROOT_PATH. "/app/includes/adminheader.php");?>

        <!-- Admin Page Wrapper -->
        <div class="admin-wrapper"> 

            <!-- Left Sidebar -->
            <?php include(ROOT_PATH. "/app/includes/adminsidebar.php");?>

            <!-- Admin Content -->
            <div class="admin-content">
                <div class="button-group">
                    <a href="create.php" class="btn btn-big">Ajouter Thème</a>
                    <a href="index.php" class="btn btn-big">Gérer Thèmes</a>
                </div>

                <div class="content">
                    <h2 class="page-title">Ajouter Thème</h2>
                    <?php include(ROOT_PATH . "/app/helpers/formErrors.php"); ?>
                    <form action="create.php" method="post">
                        <div>
                            <label>Nom</label>
                            <input type="text" name="name" value="<?php echo $name; ?>" class="text-input">
                        </div>
                        <div>
                            <label>Description</label>
                            <textarea name="description" id="body"><?php echo $description; ?></textarea>
                        </div>
                        <div>
                            <button type="submit" name="add-topic" class="btn btn-big">Ajouter Thème</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- // Admin Content -->

        </div>
        <!-- // Admin Page Wrapper -->

        

        <!-- JQuery -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        <!-- Ckeditor -->
        <script src="https://cdn.ckeditor.com/ckeditor5/29.0.0/classic/ckeditor.js"></script>

        <!-- Custom Script -->
        <script src="../../assets/js/scripts.js"></script>

    </body>
</html> 