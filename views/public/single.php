<?php
include("../path.php");
require(ROOT_PATH . "../../index.php");
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
    <link rel="stylesheet" href="../../assets/css/style_media.css">

    <title><?php echo $post['title']; ?> | JeanForteroche</title>
</head>

<body>
    <!-- Header included here -->
    <?php include(ROOT_PATH . "../../app/includes/header.php"); ?>
    <?php include(ROOT_PATH . "../../app/includes/messages.php"); ?>
    <?php include(ROOT_PATH . "../../app/helpers/formErrors.php"); ?>


 
    <!-- Page Wrapper -->
    <div class="page-wrapper"> 

        <!-- Content -->
        <div>
            <div class="content clearfix">

                <!-- Main Content Wrapper -->
                <div class="main-content-wrapper">
                    <div class="main-content single">
                        <h2 class="post-title"><?php echo $post['title']; ?></h2>
                        
                        <div class="post-content">
                            <?php echo html_entity_decode($post['body']); ?>
                        </div>

                    </div>
                </div>
                <!-- // Main Content Wrapper -->


            </div>
            <!-- // Sidebar -->

            <!-- Comments Section -->
            <div class="content clearfix">
                <div class="comments-section">
                    <h3 class="comments-title">Commentaires</h3>

                    <form action="single.php?id=<?php echo $post['id']; ?>" method="post">
                        <div>
                            <label>Ajouter un commentaire</label>
                            <textarea type="textarea" name="comment" value="<?php echo $comment; ?>" class="text-input"></textarea>
                        </div>
                        <div>
                            <button type="submit" name="add-comment" class="btn btn-big comment-btn">Publier</button>
                        </div>
                    </form>

                    <?php foreach ($reportedComments as $comment): ?>
                        <div class="comment clearfix">
                            <div class="comment-preview reported">
                                <i class="far fa-user"> <?php echo $comment['username']; ?></i> 
                                &nbsp;
                                <i class="far fa-calendar"> <?php echo date('F j, Y', strtotime($comment['created_at'])); ?></i>
                                <span class="btn-reported">Signalé</span>
                                <p class="preview-text">
                                    <?php echo html_entity_decode($comment['comment']); ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <?php foreach ($publishedComments as $comment): ?>
                        <div class="comment clearfix">
                            <div class="comment-preview">
                                <i class="far fa-user"> <?php echo $comment['username']; ?></i> 
                                &nbsp;
                                <i class="far fa-calendar"> <?php echo date('F j, Y', strtotime($comment['created_at'])); ?></i>
                                <a href="single.php?id=<?php echo $post['id'] ?>&report=1&comment_id=<?php echo $comment['id'] ?>" class="btn-report">Signaler</a>
                                <p class="preview-text">
                                    <?php echo html_entity_decode($comment['comment']); ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- // Comments Section -->

        </div>
        <!-- // Content -->

    </div>
    <!-- // Page Wrapper -->

    <!-- Footer included here -->
    <?php include(ROOT_PATH . "../../app/includes/footer.php"); ?>

    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
   
    <!-- Custom Script -->
    <script src="/../../assets/js/scripts.js"></script>
</body>

</html>