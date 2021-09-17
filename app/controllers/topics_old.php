<?php
include(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . "/app/helpers/middleware.php");
include(ROOT_PATH . "/app/helpers/validateTopic.php");




// if (isset($_POST['add-topic'])) {
//   adminOnly();
//   $errors = validateTopic($_POST);

//   if (count($errors) === 0) {
//     unset($_POST['add-topic']);
//     $topic_id = create($table, $_POST);
//     $_SESSION['message'] = 'Le thème a été créé avec succès';
//     $_SESSION['type'] = 'success';
//     header('location: ' . BASE_URL . '/admin/topics/index.php');
//     exit();
//   } else {
//     $name = $_POST['name'];
//     $description = $_POST['description'];
//   }
// }


// if (isset($_GET['id'])) {
//   $id = $_GET['id'];
//   $topic = selectOne($table, ['id' => $id]);
//   $id = $topic['id'];
//   $name = $topic['name'];
//   $description = $topic['description'];
// }

//

// if (isset($_POST['update-topic'])) {
//   adminOnly();
//   $errors = validateTopic($_POST);

//   if (count($errors) === 0) {
//     $id = $_POST['id'];
//     unset($_POST['update-topic'], $_POST['id']);
//     $topic_id = update($table, $id, $_POST);
//     $_SESSION['message'] = 'Thème actualisé avec succès';
//     $_SESSION['type'] = 'success';
//     header('location: ' . BASE_URL . '/admin/topics/index.php');
//     exit();
//   }else {
//     $id = $_POST['id'];
//     $name = $_POST['name'];
//     $description = $_POST['description'];
//   }
  
//}