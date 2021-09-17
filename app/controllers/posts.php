<?php

require_once(ROOT_PATH . "/app/database/db.php");
require_once(ROOT_PATH . "/app/helpers/middleware.php");
require_once(ROOT_PATH . "/app/helpers/validatePost.php");

class PostsController
{
    private $dbModel;

    function __construct()
    {
      $this->dbModel = new DbModel();
    }

    public function selectOnePost($table, $conditions)
    {
      // Création d'un objet
      $post = $this->dbModel->selectOne($table, $conditions);
      // Appel d'une fonction de cet objet
      return $post;
    }

    public function getTopics($table)
    {
      $topics = $this->dbModel->selectAll($table);
      return $topics;
    }

    public function getPostsForAdmin($table)
    {
      $getPostsForAdmin = $this->dbModel->getPostsForAdmin($table);
      return $getPostsForAdmin;
    }

    public function getPostsByTopicId($topicId)
    {
        $getPostsByTopicId = $this->dbModel->getPostsByTopicId($topicId);
        return $getPostsByTopicId;
    }

    public function searchPosts($term)
    {
        $searchPosts = $this->dbModel->searchPosts($term);
        return $searchPosts;
    }

    public function getPublishedPosts()
    {
        $getPublishedPosts = $this->dbModel->getPublishedPosts();
        return $getPublishedPosts;
    }
}