<?php
include(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . "/app/helpers/middleware.php");
include(ROOT_PATH . "/app/helpers/validatePost.php");

// class PostsController
// {
//     private $dbModel;

//     function __construct()
//     {
//       $this->dbModel = new DbModel();
//     }

//     public function getTopics($table)
//     {
//       // Création d'un objet
//       $topics = $this->dbModel->selectAll($table);
//       // Appel d'une fonction de cet objet
//       return $topics;
//     }

//     public function getPostsForAdmin($table)
//     {
//       // Création d'un objet
//       $getPostsForAdmin = $this->dbModel->getPostsForAdmin($table);
//       // Appel d'une fonction de cet objet
//       return $getPostsForAdmin;
//     }

//     public function getPostsByTopicId($topicId)
//     {
//         $getPostsByTopicId = $this->dbModel->getPostsByTopicId($topicId);
//         return $getPostsByTopicId;
//     }

//     public function searchPosts($term)
//     {
//         $searchPosts = $this->dbModel->searchPosts($term);
//         return $searchPosts;
//     }

//     public function getPublishedPosts($postId)
//     {
//         $getPublishedPosts = $this->dbModel->getPublishedPosts($postId);
//         return $getPublishedPosts;
//     }


// }
// $table = 'posts';



// $errors = array();
// $id = "";
// $title = "";
// $body = "";
// $topic_id = ""; 
// $published = "";  

// if (isset($_GET['id'])) {
//     $post = selectOne($table, ['id' => $_GET['id']]);

//     $id = $post['id'];
//     $title = $post['title'];
//     $body = $post['body'];
//     $topic_id = $post['topic_id']; 
//     $published = $post['published'];
// }

// if (isset($_GET['delete_id'])) {
//     adminOnly();
//     $count = delete($table, $_GET['delete_id']);
//     $_SESSION ['message'] = "Le post a été effacé avec succès.";
//     $_SESSION['type'] = "success";
//     header("location: " . BASE_URL . "/admin/posts/index.php");
//     exit();
// }

// if (isset($_GET['published']) && isset($_GET['published_id'])) {
//     adminOnly();
//     $published = $_GET['published'];
//     $published_id = $_GET['published_id'];
//     $count = update($table, $published_id, ['published' => $published]);
//     $_SESSION ['message'] = "Le statut de publication a été modifié.";
//     $_SESSION['type'] = "success";
//     header("location: " . BASE_URL . "/admin/posts/index.php");
//     exit();
// }

// if(isset($_POST['add-post'])) {
//     adminOnly();
//     $errors = validatePost($_POST);

//     if (!empty($_FILES['image']['name'])) {
//         $image_name = time() . ' ' . $_FILES['image']['name'];
//         $destination = ROOT_PATH . "/assets/images/" . $image_name;

//         $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);

//         if ($result) {
//             $_POST['image'] = $image_name;
//         } else {
//             array_push($errors, "Le téléchargement de l'image a échoué");
//         }

//     } else {
//         array_push($errors, "L'image du post est requise");
//     }

//     if (count($errors) == 0) {
//         unset($_POST['add-post']);
//         $_POST['user_id'] = $_SESSION['id'];
//         $_POST['published'] = isset($_POST['published']) ? 1 : 0;
//         $_POST['body'] = htmlentities($_POST['body']); //pour sécuriser code
    
//         $post_id = create($table, $_POST);
//         $_SESSION ['message'] = "Le post a été créé avec succès";
//         $_SESSION['type'] = "success";
//         header("location: " . BASE_URL . "/admin/posts/index.php");
//     }else {
//         $title = $_POST['title'];
//         $body = $_POST['body'];
//         $topic_id = $_POST['topic_id'];
//         $published = isset($_POST['published']) ? 1 : 0;
//     }
// }     

// if (isset($_POST['update-post'])) {
//     adminOnly();
//     $errors = validatePost($_POST);

//     if (count($errors) == 0) {
//         $id = $_POST['id'];
//         unset($_POST['update-post'], $_POST['id']);
//         $_POST['user_id'] = $_SESSION['id'];
//         $_POST['published'] = isset($_POST['published']) ? 1 : 0;
//         $_POST['body'] = htmlentities($_POST['body']); //pour sécuriser code
    
//         $post_id = update($table, $id, $_POST);
//         $_SESSION ['message'] = "Le post a été actualisé avec succès";
//         $_SESSION['type'] = "success";
//         header("location: " . BASE_URL . "/admin/posts/index.php");
//         exit();
//     }else {
//         $title = $_POST['title'];
//         $body = $_POST['body'];
//         $topic_id = $_POST['topic_id'];
//         $published = isset($_POST['published']) ? 1 : 0;
//     }

//     if (!empty($_FILES['image']['name'])) {
//         $image_name = time() . ' ' . $_FILES['image']['name'];
//         $destination = ROOT_PATH . "/assets/images/" . $image_name;

//         $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);

//         if ($result) {
//             $_POST['image'] = $image_name;
//         } else {
//             array_push($errors, "Le téléchargement de l'image a échoué");
//         }

//     } else {
//         array_push($errors, "L'image du post est requise");
//     }
// }