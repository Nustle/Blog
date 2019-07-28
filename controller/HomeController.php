<?php

namespace controller;

use model\PostModel;
use core\DBconnector;
use core\DBDriver;
use core\Validator;
use core\Exception\ModelException;
//use core\Exception\ValidatorException;

class HomeController extends BaseController
{
  public function indexAction()
  {
    $mPost = new PostModel(
      new DBDriver(DBConnector::getConnect()),
      new Validator()
    );

    $posts = $mPost->getAll();

    $this->content = $this->template('Home', 'home', ['posts' => $posts]);
  }

  public function postAction()
  {
    $this->title = 'Просмотр сообщения';
    $id = $this->request->get('id');

    $mPost = new PostModel(
      new DBDriver(DBConnector::getConnect()),
      new Validator()
    );

    $post = $mPost->getById($id);

    $this->content = $this->template(
      'Post', 'post',
      [
        'title' => $post['name'],
        'content' => $post['content'],
        'data' => $post['data']
      ]
    );
  }

  public function addAction()
  {
    $this->title = 'Добавление статьи';
    $errors = [];

    if ($this->request->isPost()) {
      $mPost = new PostModel(
        new DBDriver(DBConnector::getConnect()),
        new Validator()
      );

      try {
        $post = $mPost->add(
            [
              'name' => $this->request->post('name'),
              'content' => $this->request->post('content')
            ]
          );
        
        $this->redirect();
      } catch (ModelException $e) {
          $errors = $e->getErrors();
      }
    }

    $this->content = $this->template(
      'Add', 'add',
      [
        'name' => $this->request->post('name'),
        'content' => $this->request->post('content'),
        'errors' => $this->transfer($errors)
      ]
    );
  }

  public function editAction()
  {
    $this->title = 'Изменение статьи';

    if ($this->request->isPost()) {
      $mPost = new PostModel(
        new DBDriver(DBConnector::getConnect()),
        new Validator()
      );

      try {
        $post = $mPost->edit(
          [
            'name' => $this->request->post('name'),
            'content' => $this->request->post('content')
          ],
          
          [
            'name' => $this->request->post('name')
          ]
        );

        $this->redirect();
      } catch (ModelException $e) {
          $e->getErrors();
      }
    }

    $this->content = $this->template(
      'Edit','edit',
      [
        'name' => $this->request->post('name'),
        'content' => $this->request->post('content')
      ]
    );
  }

  public function deleteAction()
  {
    $this->title = 'Удаление статьи';

    if($this->request->isPost()){
      $mPost = new PostModel(
        new DBDriver(DBConnector::getConnect()),
        new Validator()
      );

      try {
        $post = $mPost->delete(
          [
            'name' => $this->request->post('name')
          ]
        );

        $this->redirect();
      } catch (ModelException $e) {
          $e->getErrors();
      }
    }

    $this->content = $this->template(
      'Delete', 'delete', 
      [
        'name' => $this->request->post('name')
      ]
    );
  }
}