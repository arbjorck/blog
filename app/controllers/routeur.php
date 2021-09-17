<?php
session_start();
require_once(ROOT_PATH . "/app/controllers/topics.php");
require_once(ROOT_PATH . "/app/controllers/posts.php");
require_once(ROOT_PATH . "/app/controllers/comments.php");
require_once(ROOT_PATH . "/app/controllers/users.php");
require_once(ROOT_PATH . "/app/helpers/middleware.php");
require_once(ROOT_PATH . "/app/helpers/validateTopic.php");
require_once(ROOT_PATH . "/app/helpers/validateComments.php");
require_once(ROOT_PATH . "/app/helpers/validateUser.php");

try {

  $errors = array();
  $id = '';
  $name = '';
  $description = '';
  
  $posts = array();
  $postsTitle = 'Récents';

  //Users Variables
  $username ='';
  $admin = '';
  $email ='';
  $password ='';
  $passwordConf ='';

  // if(isset($_SESSION[$user]))
  // {
  //   $usersController = new UsersController();
  //   $loggedUser = $usersController->loggedUser($user);
  // }


  // Posts Admin

  if (isset($_GET['edit_post_id'])) {
    $postsController = new PostsController();
    $post = $postsController->selectOnePost('topics', ['id' => $_GET['edit_topic_id']]);
    $id = $topic['id'];
    $name = $topic['name'];
    $description = $topic['description'];
  }

  // Comments Admin

  // Topics Admin

  if (isset($_GET['edit_topic_id'])) {
    $topicsController = new TopicsController();
    $topic = $topicsController->selectOneTopic('topics', ['id' => $_GET['edit_topic_id']]);
    $id = $topic['id'];
    $name = $topic['name'];
    $description = $topic['description'];
  }


  // Users Admin

  if (isset($_GET['delete_id'])) {
    $middleware = new Middleware();
    $adminOnly = $middleware->adminOnly();

    $usersController = new UsersController();
    $deleteUser = $usersController->deleteUser('users', $_GET['delete_id']);
}

  if (isset($_POST['update-user'])) {
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

        //$count = update($table, $id, $_POST);
        
    } else { // keep the well filled inputs in the form
        $username = $_POST['username'];
        $admin = isset($_POST['admin']) ? 1 : 0;
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordConf = $_POST['passwordConf'];
    }
  }

  if (isset($_GET['edit_user_id'])) {
    $usersController = new UsersController();
    $user = $usersController->selectOneUser('users', ['id' => $_GET['edit_user_id']]);
    $id = $user['id'];
    $username = $user['username'];
    $email = $user['email'];
    $password = $user['password'];
    $passwordConf = $user['password'];
    $admin = $user['admin'] == 1 ? 1 : 0;
  }

  if ($_GET['admin'] = 'users') {
    $usersController = new UsersController();
    $adminUsers = $usersController->selectAllUsers('users');
  }


  // Users

  if (isset($_POST['login-btn'])) {
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
  }

  if (isset($_POST['register-btn'])) {
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
            // $usersController = new UsersController();
            $user = $usersController->selectOneUser('users', ['id' => $user_id]);
            // $usersController = new UsersController();
            $loggedUser = $usersController->loggedUser($user);

        }
    } else { // keep the well filled inputs in the form
        $username = $_POST['username'];
        $admin = isset($_POST['admin']) ? 1 : 0;
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordConf = $_POST['passwordConf'];
    }
  }

  if (isset($_POST['create-admin'])) {
    $validateUser = new ValidateUser($_POST);
    $errors = $validateUser->validateUser($_POST);
    
    if (count($errors) === 0) {
        unset($_POST['passwordConf'], $_POST['create-admin']);    
        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        if (isset($_POST['admin'])) {
            $_POST['admin'] = 1;
            $usersController = new UsersController();
            $user_id = $usersController->createUser('users', $_POST);
        } else {
            $_POST['admin'] = 0;
            $usersController = new UsersController();
            $userCreate = $usersController->createAdmin('users', $_POST);
            $usersController = new UsersController();
            $user = $usersController->selectOneUser('users', ['id' => $user_id]);
            // loginUser($user);
            header('location: ' . BASE_URL . '/admin/users/index.php');
        }
    } else { // keep the well filled inputs in the form
        $username = $_POST['username'];
        $admin = isset($_POST['admin']) ? 1 : 0;
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordConf = $_POST['passwordConf'];
    }
  }

  if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $middleware = new Middleware();
    $adminOnly = $middleware->adminOnly();

    $commentsController = new CommentsController();
    $comment = $commentsController->deleteComment('comments', $comment_id);
  }

  if (isset($_GET['id']) && isset($_GET['report']) && isset($_GET['comment_id'])) {
    $middleware = new Middleware();
    $adminOnly = $middleware->usersOnly();

    $report = $_GET['report'];
    $comment_id = $_GET['comment_id'];

    $commentsController = new CommentsController();
    $update = $commentsController->updateComment('comments', $comment_id, ['reported' => $report]);
    $_SESSION ['message'] = "Le commentaire a été signalé. Nous allons le traiter. Merci pour votre collaboration.";
    $_SESSION['type'] = "success";
    header("location: " . BASE_URL . "/single.php?id=" . $_GET['id']);
    exit();
  }

  if(isset($_POST['add-comment'])) {
    $middleware = new Middleware();
    $adminOnly = $middleware->usersOnly();

    $validateComment = new ValidateComment();
    $errors = $validateComment->validateComment($_POST['comment']);

    if (count($errors) == 0) {
        unset($_POST['add-comment']);
        $_POST['user_id'] = $_SESSION['id'];
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
  }

  if (isset($_GET['published']) && isset($_GET['published_id'])) {
    $middleware = new Middleware();
    $adminOnly = $middleware->adminOnly();

    $published = $_GET['published'];
    $published_id = $_GET['published_id'];
    $commentsController = new CommentsController();
    $updateComment = $commentsController->updateComment('comments', $published_id, ['published' => $published]);

    $_SESSION ['message'] = "Le statut de publication a été modifié.";
    $_SESSION['type'] = "success";
    header("location: " . BASE_URL . "/admin/comments/index.php");
    exit();
  }

  if (isset($_GET['reported']) && isset($_GET['reported_id'])) {
    $middleware = new Middleware();
    $adminOnly = $middleware->adminOnly();

    $reported = $_GET['reported'];
    $reported_id = $_GET['reported_id'];
    $commentsController = new CommentsController();
    $updateComment = $commentsController->updateComment('comments', $reported_id, ['reported' => $reported]);

    $_SESSION ['message'] = "Le statut de publication a été modifié.";
    $_SESSION['type'] = "success";
    header("location: " . BASE_URL . "/admin/comments/index.php");
    exit();
  }

   // Attention GET a été changé !
  if (isset($_GET['comment_id'])) {
    $comment_id = $_GET['comment_id'];

    $commentsController = new CommentsController();
    $comment = $commentsController->selectOneComment($table, $comment_id);

    $id = "";
    $user_id = ""; 
    $post_id = "";
    $comment = ""; 

    $id = $comment['id'];
    $user_id = $comment['user_id'];
    $post_id = $comment['post_id'];
    $comment = $comment['comment'];
  }
  
  if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $postsController = new PostsController();
    $post = $postsController->selectOnePost('posts', ['id' => $id]);

    $topicsController = new TopicsController();
    $topics = $topicsController->getTopics('topics');

    $postsController = new PostsController();
    $PublishedPosts = $postsController->getPublishedPosts();

    $commentsController = new CommentsController();
    $reportedComments = $commentsController->getReportedComments($id);

    $commentsController = new CommentsController();
    $publishedComments = $commentsController->getPublishedComments($id);
  }
  
  // !!! Problème avec fonction executeQuery (create) !!!
  if (isset($_POST['add-topic'])) {
    // Création d'un objet
    $middleware = new Middleware();
    // Appel d'une fonction de cet objet
    $adminOnly = $middleware->adminOnly();
  
    $validateTopic = new ValidateTopic();
    $errors = $validateTopic->validateTopic($_POST);
  
    if (count($errors) === 0) {
      unset($_POST['add-topic']);
      $topicsController = new TopicsController();
      $topic_id = $topicsController->create('topics', $_POST);
    } else {
      $name = $_POST['name'];
      $description = $_POST['description'];
    }
  } 
  
  // Attention GET a été changé !
  if (isset($_GET['id-topic'])) {
    $id = $_GET['id'];
    $topicsController = new TopicsController();
    $topic = $topicsController->selectOneTopic('topics', ['id' => $id]);
  
    $id = $topic['id'];
    $name = $topic['name'];
    $description = $topic['description'];
  }
  
  
  if (isset($_GET['del_id'])) {
    $middleware = new Middleware();
    $adminOnly = $middleware->adminOnly();
  
    $id = $_GET['del_id'];
    $topicsController = new TopicsController();
    $deleteTopic = $topicsController->deleteTopic('topics', $id);
  }
  
  if (isset($_POST['update-topic'])) {
    $middleware = new Middleware();
    $adminOnly = $middleware->adminOnly();
  
    $validateTopic = new ValidateTopic();
    $errors = $validateTopic->validateTopic($_POST);
  
    if (count($errors) === 0) {
      $id = $_POST['id'];
      unset($_POST['update-topic'], $_POST['id']);
  
      $topicsController = new TopicsController();
      $topicUpdate = $topicsController->update('topics', $id, $_POST);
    } else {
      $id = $_POST['id'];
      $name = $_POST['name'];
      $description = $_POST['description'];
    }
  }
  
  if (isset($_GET['t_id'])) {
    $postsController = new PostsController();
    $getPostsByTopicId = $postsController->getPostsByTopicId($_GET['t_id']);
    $postsTitle = "Vous avez recherché ''" . $_GET['name'] . "''";
  } elseif (isset($_POST['search-term'])) {
    $postsTitle = "Vous avez recherché ''" . $_POST['search-term'] . "''";
    $postsController = new PostsController();
    $searchPosts = $postsController->searchPosts($_POST['search-term']);
  } else {
    $postsController = new PostsController();
    $getPublishedPosts = $postsController->getPublishedPosts();
  
    $topicsController = new TopicsController();
    $topics = $topicsController->getTopics('topics');    
  }
} catch (Exception $e) {
  $errors = $e->getMessage();
  echo($errors);
}