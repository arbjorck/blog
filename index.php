<?php
// error_reporting(E_ALL);
// ini_set('display_errors', true);
session_start();

require_once("views/path.php");

require_once(ROOT_PATH . "../../app/controllers/posts.php");
require_once(ROOT_PATH . "../../app/controllers/comments.php");
require_once(ROOT_PATH . "../../app/controllers/users.php");
require_once(ROOT_PATH . "../../app/helpers/middleware.php");
require_once(ROOT_PATH . "../../app/helpers/validateComments.php");
require_once(ROOT_PATH . "../../app/helpers/validateUser.php");

try {
  $errors = array();
  $id = '';
  $name = '';
  $description = '';
  
  $posts = array();
  $postsTitle = 'Nos Posts';
  $title = '';
  $body = '';

  //Users Variables
  $username ='';
  $admin = '';
  $password ='';
  // ------------------------------ ADMIN ------------------------------------

  // POSTS ADMIN
  if (isset($_GET['admin']) && $_GET['admin'] === 'posts') {
    $middleware = new Middleware();
    $adminOnly = $middleware->adminOnly();

    $postsController = new PostsController();
    $posts = $postsController->getPostsForAdmin('posts');
  } elseif (isset($_GET['create']) && $_GET['create'] === 'post') {
    $middleware = new Middleware();
    $adminOnly = $middleware->adminOnly();

  } elseif (isset($_GET['edit_post_id'])) {
    $middleware = new Middleware();
    $adminOnly = $middleware->adminOnly();

    $postsController = new PostsController();
    $post = $postsController->selectOnePost('posts', ['id' => $_GET['edit_post_id']]);
    $id = $post['id'];
    $title = $post['title'];
    $body = $post['body'];
    $published = $post['published'];

  } elseif (isset($_POST['update-post'])) {
    $middleware = new Middleware();
    $adminOnly = $middleware->adminOnly();

    $validatePosts = new ValidatePost($_POST);
    $errors = $validatePosts->validatePost($_POST);

    if (!empty($_FILES['image']['name'])) {
      $image_name = time() . ' ' . $_FILES['image']['name'];
      $destination = ROOT_PATH . "../../assets/images/" . $image_name;

      $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);

      if ($result) {
          $_POST['image'] = $image_name;
      } else {
          array_push($errors, "Le téléchargement de l'image a échoué.");
      }
    }

    if (count($errors) == 0) {
        $id = $_POST['id'];
        unset($_POST['update-post'], $_POST['id']);
        $_POST['user_id'] = $_SESSION['id'];
        $_POST['published'] = isset($_POST['published']) ? 0 : 1;
        $_POST['body'] = htmlentities($_POST['body']); //pour sécuriser code
    

        $postsController = new PostsController();
        $postUpdate = $postsController->updatePost('posts', $id, $_POST);
    }else {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $body = $_POST['body'];
        $published = isset($_POST['published']) ? 1 : 0;
    }

    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . ' ' . $_FILES['image']['name'];
        $destination = ROOT_PATH . "../../assets/images/" . $image_name;

        $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);

        if ($result) {
            $_POST['image'] = $image_name;
        } else {
            array_push($errors, "Le téléchargement de l'image a échoué");
        }
    }    
  } elseif (isset($_GET['post_published']) && isset($_GET['post_published_id'])) {
    $middleware = new Middleware();
    $adminOnly = $middleware->adminOnly();

    $published = $_GET['post_published'];
    $published_id = $_GET['post_published_id'];
    $postsController = new PostsController();
    $updatePost = $postsController->updatePost('posts', $published_id, ['published' => $published]);
  } elseif (isset($_POST['add-post'])) {
    $middleware = new Middleware();
    $adminOnly = $middleware->adminOnly();

    $validatePosts = new ValidatePost($_POST);
    $errors = $validatePosts->validatePost($_POST);

    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . ' ' . $_FILES['image']['name'];
        $destination = ROOT_PATH . "../../assets/images/" . $image_name;

        $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);

        if ($result) {
            $_POST['image'] = $image_name;
        } else {
            array_push($errors, "Le téléchargement de l'image a échoué.");
        }
    } else {
        array_push($errors, "L'image du post est requise.");
    }

    if (count($errors) == 0) {
        unset($_POST['add-post']);
        $_POST['user_id'] = $_SESSION['id'];
        $_POST['published'] = isset($_POST['published']) ? 1 : 0;
        $_POST['body'] = htmlentities($_POST['body']); //pour sécuriser code
    
        $postsController = new PostsController();
        $post_id = $postsController->createPost('posts', $_POST);
    }else {
        $title = $_POST['title'];
        $body = $_POST['body'];
        $published = isset($_POST['published']) ? 1 : 0;
    }
  } elseif (isset($_GET['delete_id_post'])) {
    $middleware = new Middleware();
    $adminOnly = $middleware->adminOnly();

    $postsController = new PostsController();
    $deletePost = $postsController->deletePost('posts', $_GET['delete_id_post']);
  } elseif (isset($_GET['admin']) && $_GET['admin'] === 'comments') {
    $middleware = new Middleware();
    $adminOnly = $middleware->adminOnly();

    $commentsController = new CommentsController();
    $getCommentsForAdmin = $commentsController->getCommentsForAdmin();
  } elseif (isset($_GET['comment_published']) && isset($_GET['comment_published_id'])) {
    $middleware = new Middleware();
    $adminOnly = $middleware->adminOnly();

    $published = $_GET['comment_published'];
    $published_id = $_GET['comment_published_id'];

    $commentsController = new CommentsController();
    $updateComment = $commentsController->updateComment('comments', $published_id, ['published' => $published]);
    $getCommentsForAdmin = $commentsController->getCommentsForAdmin();

  } elseif (isset($_GET['reported']) && isset($_GET['reported_id'])) {
    $middleware = new Middleware();
    $adminOnly = $middleware->adminOnly();

    $reported = $_GET['reported'];
    $reported_id = $_GET['reported_id'];
    $commentsController = new CommentsController();
    $updateComment = $commentsController->updateComment('comments', $reported_id, ['reported' => $reported]);

    $_SESSION ['message'] = "Le statut de publication a été modifié.";
    $_SESSION['type'] = "success";
    header("location: " . BASE_URL . "/views/admin/comments/index.php?admin=comments");
    exit();
  } elseif (isset($_GET['admin'])) { 
    $middleware = new Middleware();
    $adminOnly = $middleware->adminOnly();
  
    if (count($errors) === 0) {
      $id = $_POST['id'];
      $name = $_POST['name'];
      $description = $_POST['description'];
    }
  } elseif (isset($_GET['admin']) && $_GET['admin'] === 'users') {
    $middleware = new Middleware();
    $adminOnly = $middleware->adminOnly();

    $usersController = new UsersController();
    $adminUsers = $usersController->selectAllUsers('users');
  } elseif (isset($_GET['create']) && $_GET['create'] === 'user') {
    $middleware = new Middleware();
    $adminOnly = $middleware->adminOnly();
  } elseif (isset($_GET['delete_id_user'])) {
    $middleware = new Middleware();
    $adminOnly = $middleware->adminOnly();

    $usersController = new UsersController();
    $deleteUser = $usersController->deleteUser('users', $_GET['delete_id_user']);
  } elseif (isset($_POST['update-user'])) {
    $middleware = new Middleware();
    $adminOnly = $middleware->adminOnly();

    $validateUser = new ValidateUser($_POST);
    $errors = $validateUser->validateEditUser($_POST);
    if (count($errors) === 0) {
        $id = $_POST['id'];
        unset($_POST['passwordConf'], $_POST['update-user'], $_POST['id']);    
        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $_POST['admin'] = isset($_POST['admin']) ? 1 : 0;

        $usersController = new UsersController();
        $user_id = $usersController->updateUser('users', $id, $_POST);

    } else { // keep the well filled inputs in the form
      //$erro = $errors;
        $id = $_POST['id'];
        $username = $_POST['username'];
        $admin = isset($_POST['admin']) ? 1 : 0;
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordConf = $_POST['passwordConf'];
    }
  } elseif (isset($_GET['edit_user_id'])) {
    $usersController = new UsersController();
    $user = $usersController->selectOneUser('users', ['id' => $_GET['edit_user_id']]);
    $id = $user['id'];
    $username = $user['username'];
    $email = $user['email'];
    $password = $user['password'];
    $passwordConf = $user['password'];
    $admin = $user['admin'] == 1 ? 1 : 0;
  } elseif (isset($_POST['create-admin'])) {
    $validateUser = new ValidateUser($_POST);
    $errors = $validateUser->validateUser($_POST);
    
    if (count($errors) === 0) {
        unset($_POST['passwordConf'], $_POST['create-admin']);    
        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        if (isset($_POST['admin'])) {
            $_POST['admin'] = 1;
            $usersController = new UsersController();
            $user_id = $usersController->createAdmin('users', $_POST);
        } else {
            $_POST['admin'] = 0;
            $usersController = new UsersController();
            $userCreate = $usersController->createAdmin('users', $_POST);
            $user = $usersController->selectOneUser('users', ['id' => $user_id]);
        }
    } else { // keep the well filled inputs in the form
        $username = $_POST['username'];
        $admin = isset($_POST['admin']) ? 1 : 0;
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordConf = $_POST['passwordConf'];
    }
  } elseif (isset($_POST['login-btn'])) {
    $validateUser = new ValidateUser($_POST);
    $errors = $validateUser->validateLogin($_POST);

    if (count($errors) === 0) {      
        $usersController = new UsersController();
        $user = $usersController->selectOneUser('users', ['username' => $_POST['username']]);

        if ($user && password_verify($_POST['password'], $user['password'])) {
          $usersController = new UsersController();
          $loggedUser = $usersController->loggedUser($user);
        }else {
            array_push($errors, "Vos identifiants sont incorrects.");
        }
    }
      $username = $_POST['username'];
      $password = $_POST['password'];
  } elseif (isset($_POST['register-btn'])) {
    $validateUser = new ValidateUser($_POST);
    $errors = $validateUser->validateUser($_POST);
    
    if (count($errors) === 0) {
        unset($_POST['register-btn'], $_POST['passwordConf']);    
        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        if (isset($_POST['admin'])) {
            $_POST['admin'] = 1;
            $usersController = new UsersController();
            $user_id = $usersController->createUser('users', $_POST);
            exit();
        } else {
            $_POST['admin'] = 0;
            $usersController = new UsersController();
            $user_id = $usersController->createUser('users', $_POST);
            $user = $usersController->selectOneUser('users', ['id' => $user_id]);
            $loggedUser = $usersController->loggedUser($user);

        }
    } else { // keep the well filled inputs in the form
        $username = $_POST['username'];
        $admin = isset($_POST['admin']) ? 1 : 0;
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordConf = $_POST['passwordConf'];
    }
  } elseif (isset($_GET['delete_id_comment'])) {
    $middleware = new Middleware();
    $adminOnly = $middleware->adminOnly();

    $delete_id = $_GET['delete_id_comment'];

    $commentsController = new CommentsController();
    $comment = $commentsController->deleteComment('comments', $delete_id);
  } elseif (isset($_GET['id']) && isset($_GET['report']) && isset($_GET['comment_id'])) {
    $report = $_GET['report'];
    $comment_id = $_GET['comment_id'];

    $commentsController = new CommentsController();
    $update = $commentsController->updateComment('comments', $comment_id, ['reported' => $report]);
    $_SESSION ['message'] = "Le commentaire a été signalé. Nous allons le traiter. Merci pour votre collaboration.";
    $_SESSION['type'] = "success";
    header("location: " . BASE_URL . "/views/public/single.php?id=" . $_GET['id']);
    exit();
  } elseif (isset($_POST['add-comment'])) {
    $validateComment = new ValidateComment($_POST['comment']);
    $errors = $validateComment->validateComment($_POST['comment']);

    if (count($errors) == 0) {
        unset($_POST['add-comment']);
        if(isset($_SESSION['id'])){
          $_POST['user_id'] = $_SESSION['id'];
        }
        // else {
        //   $_POST['user_id'] = 1;
        // }
        $_POST['post_id'] = $_GET['id'];
        $_POST['comment'] = htmlentities($_POST['comment']); //pour sécuriser code
        $_POST['published'] = isset($_POST['published']) ? 0 : 1;
        $_POST['reported'] = isset($_POST['reported']) ? 1 : 0;

        $commentsController = new CommentsController();
        $createComment = $commentsController->createComment('comments', $_POST);
    }else {
        $post_id = $_POST['post_id'];
        $comment = $_POST['comment'];
    }
  } elseif (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Création d'un objet
    $postsController = new PostsController();
    // Appel d'une fonction de cet objet
    $post = $postsController->selectOnePost('posts', ['id' => $id]);
 
    $commentsController = new CommentsController();
    // Appel d'une fonction de cet objet
    $reportedComments = $commentsController->getReportedComments($id);
    $publishedComments = $commentsController->getPublishedComments($id);

  } elseif (isset($_GET['login'])) {
    $middleware = new Middleware();
    $adminOnly = $middleware->guestsOnly();

    require(ROOT_PATH . "../../views/public/login.php");
  } elseif (isset($_GET['register'])) {
    $middleware = new Middleware();
    $adminOnly = $middleware->guestsOnly();
    
    require(ROOT_PATH . "../../views/public/register.php");
  } elseif (isset($_GET['dashboard'])) {
    $middleware = new Middleware();
    $adminOnly = $middleware->adminOnly();
    
    require(ROOT_PATH . "../../views/admin/dashboard.php");
  } elseif (isset($_GET['notice'])) { 
    require(ROOT_PATH . "../../views/admin/dashboard.php");
  } else {
    $postsController = new PostsController();
    $getPublishedPosts = $postsController->getPublishedPosts();

    require(ROOT_PATH . "../../views/public/home.php");
  }
} catch (Exception $e) {
  $errors = $e->getMessage();
  echo($errors);
}


