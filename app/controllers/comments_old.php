<?php

include(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . "/app/helpers/middleware.php");
include(ROOT_PATH . "/app/helpers/validateComments.php");

// $reportedComments = getReportedComments($_GET['id']);
// $publishedComments = getPublishedComments($_GET['id']);


// $getCommentsForAdmin = getCommentsForAdmin();

// $errors = array();
// $id = "";
// $user_id = "";
// $post_id = "";
// $comment = "";  


// if (isset($_GET['comment_id'])) {
//     $comment = selectOne($table, ['id' => $_GET['id']]);

//     $id = "";
//     $user_id = ""; 
//     $post_id = "";
//     $comment = ""; 

//     $id = $comment['id'];
//     $user_id = $comment['user_id'];
//     $post_id = $comment['post_id'];
//     $comment = $comment['comment'];
// }

// if (isset($_GET['delete_id'])) {
//     adminOnly();
//     $update = delete($table, $_GET['delete_id']);
//     $_SESSION ['message'] = "Le commentaire a été effacé avec succès.";
//     $_SESSION['type'] = "success";
//     header("location: " . BASE_URL . "/admin/comments/index.php");
//     exit();
// }

// if (isset($_GET['published']) && isset($_GET['published_id'])) {
//     adminOnly();
//     $published = $_GET['published'];
//     $published_id = $_GET['published_id'];
//     $update = update($table, $published_id, ['published' => $published]);
//     $_SESSION ['message'] = "Le statut de publication a été modifié.";
//     $_SESSION['type'] = "success";
//     header("location: " . BASE_URL . "/admin/comments/index.php");
//     exit();
// }

// if (isset($_GET['reported']) && isset($_GET['reported_id'])) {
//     adminOnly();
//     $reported = $_GET['reported'];
//     $reported_id = $_GET['reported_id'];
//     $update = update($table, $reported_id, ['reported' => $reported]);
//     $_SESSION ['message'] = "Le statut de publication a été modifié.";
//     $_SESSION['type'] = "success";
//     header("location: " . BASE_URL . "/admin/comments/index.php");
//     exit();
// }

// if (isset($_GET['id']) && isset($_GET['report']) && isset($_GET['comment_id'])) {
//     usersOnly();
//     $report = $_GET['report'];
//     $comment_id = $_GET['comment_id'];
//     $update = update($table, $comment_id, ['reported' => $report]);
//     $_SESSION ['message'] = "Le commentaire a été signalé. Nous allons le traiter. Merci pour votre collaboration.";
//     $_SESSION['type'] = "success";
//     header("location: " . BASE_URL . "/single.php?id=" . $_GET['id']);
//     exit();
// }

// if(isset($_POST['add-comment'])) {
//     usersOnly();
//     $errors = validateComment($_POST['comment']);
//     if (count($errors) == 0) {
//         unset($_POST['add-comment']);
//         $_POST['user_id'] = $_SESSION['id'];
//         $_POST['post_id'] = $_GET['id'];
//         $_POST['comment'] = htmlentities($_POST['comment']); //pour sécuriser code
//         $_POST['published'] = isset($_POST['published']) ? 0 : 1;
//         $_POST['reported'] = isset($_POST['reported']) ? 1 : 0;

//         $comment_id = create($table, $_POST);
//         $_SESSION ['message'] = "Le commentaire a été créé avec succès";
//         $_SESSION['type'] = "success";
//         header("location: " . BASE_URL . "/single.php?id=" . $_POST['post_id']);
//     }else {
//         $post_id = $_POST['post_id'];
//         $comment = $_POST['comment'];
//     }
// }     