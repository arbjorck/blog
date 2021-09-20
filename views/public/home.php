<?php
// error_reporting(E_ALL);
// ini_set('display_errors', true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include(ROOT_PATH . "../../app/includes/head.php"); ?>

    <!-- Custom Styling -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style_media.css">

    <title>Blog</title>
</head>   


<body>
    <!-- Header included here -->
    <?php include(ROOT_PATH . "../../app/includes/header.php"); ?>
    <?php include(ROOT_PATH . "../../app/includes/messages.php"); ?>
 
    <!-- Page Wrapper -->
    <div class="page-wrapper"> 

        <!-- // Post Slider -->

        <!-- Content -->
        <div class="content clearfix">

            <!-- Main Content -->
            <div class="main-content">
                <h2 class="recent-post-title"><?php echo $postsTitle ?></h2>
                
                <?php 
                    $posts = $getPublishedPosts;
                    foreach ($posts as $post): ?>
                    <div class="post clearfix">
                        <img src="<?php echo BASE_URL .'/assets/images/' . $post['image']; ?>" alt="" class="post-image">
                        <div class="post-preview">
                            <h3><a href="views/public/single.php?id=<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a></h3>
                            <i class="far fa-user"><?php echo $post['username']; ?></i>
                            <!-- &nbsp; -->
                            <i class="far fa-calendar"><?php echo date('F j, Y', strtotime($post['created_at'])); ?></i>
                            <p class="preview-text">
                                <?php echo html_entity_decode(substr($post['body'], 0, 200) . '...'); ?>
                            </p>
                            <a href="views/public/single.php?id=<?php echo $post['id']; ?>" class="btn read-more">Lire</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
        <!-- // Content -->

    </div>
    <!-- // Page Wrapper -->

    <!-- Footer included here -->
    <?php include(ROOT_PATH . "../../app/includes/footer.php"); ?>

    <!-- Foot -->
    <?php include(ROOT_PATH . "../../app/includes/foot.php"); ?>

    <!-- Custom Script -->
    <script src="assets/js/scripts.js"></script>

</body>
</html>