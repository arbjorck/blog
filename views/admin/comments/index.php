<?php
include("../../path.php");
include(ROOT_PATH . "../../index.php");
?>

<!DOCTYPE html>
<html lang="en"> 
    <head>
        <?php include(ROOT_PATH . "../../app/includes/adminHead.php"); ?>

        <title>Admin - Gérer Commentaires</title>
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
                    <h2 class="page-title">Gérer Commentaires</h2>

                    <?php include(ROOT_PATH . "../../app/includes/messages.php"); ?>
                    <table>
                        <thead>
                            <th>SN</th>
                            <th>Post</th>
                            <th>Commentaire</th>
                            <th>Auteur</th>
                            <th colspan="3">Action</th>
                        </thead>
                        <tbody>
                            <?php foreach($getCommentsForAdmin as $key => $comment): ?>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo $comment['title'] ?></td>
                                    <td><?php echo $comment['comment'] ?></td>
                                    <td><?php echo $comment['username'] ?></td>
                                    <td><a href="index.php?delete_id_comment=<?php echo $comment['id']; ?>" class="delete">Effacer</a></td>
                                    <?php if ($comment['reported']): ?>
                                        <td><a href="index.php?reported=0&reported_id=<?php echo $comment['id'] ?>" class="reported">Ignorer</a></td>
                                    <?php else:?>
                                        <td><a href="index.php?reported=1&reported_id=<?php echo $comment['id'] ?>" class="report">Signaler</a></td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- // Admin Content -->

        </div> 
        <!-- // Admin Page Wrapper -->

        <!-- Foot -->
        <?php include(ROOT_PATH . "../../app/includes/adminFoot.php"); ?>

    </body>
</html> 