<?php

namespace Blog\Controller;

use Blog\Forms\Add;
use Blog\Forms\Edit;
use Blog\Forms\Delete;
use Blog\Core\Exception\ValidatorException;
use Blog\Core\Forms\FormBuilder;

class HomeController extends BaseController
{
  public function indexAction()
  {
    $user = $this->container->get('user');

    $access = $user->checkAccess('ADMIN_PANEL');

    if (!$access) {
      $this->response->redirect(ROOT);
    }

    $posts = $this->container
      ->fabricate('factory.model', 'Post')
      ->getAll();

    $this->content = $this->template('Home', 'home', ['posts' => $posts]);
  }

  public function postAction()
  {
    $this->title = 'Просмотр сообщения';
    $id = $this->request->get()->get('id');

    $post = $this->container
      ->fabricate('factory.model', 'Post')    
      ->getById($id);

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

    $form = new Add();
    $formBuilder = new FormBuilder($form);

    if ($this->request->isPost()) {
      $post = $this->container->fabricate('factory.model', 'Post');

      try {
        $post->add(
          [
            'title' => $this->request->post()->get('title'), // Может быть $this->request->post->get('title), везде также по аналогии
            'content' => $this->request->post()->get('content')
          ]
        );
        
        $this->response->redirect(ROOT); // $this->redirect(ROOT);
      } catch (ValidatorException $e) {
          $form->addErrors($e->getErrors());
      }
    }

    $this->content = $this->template('Add', 'add', ['form' => $formBuilder]);
  }

  public function editAction()
  {
    $this->title = 'Изменение статьи';

    $form = new Edit();
    $formBuilder = new FormBuilder($form);

    if ($this->request->isPost()) {
      $post = $this->container->fabricate('factory.model', 'Post');

      try {
        $post->edit(
          [
            'name' => $this->request->post()->get('name'),
            'content' => $this->request->post()->get('content')
          ],
          sprintf('name="%"', $this->request->post()->get('name')) // Если что, в таком же стиле, только по id (ниже тоже касается, только name)
        );

        $this->response->redirect(ROOT);
      } catch (ValidatorException $e) {
          $form->addErrors($e->getErrors());
      }
    }

    $this->content = $this->template(
      'Edit','edit', ['form' => $formBuilder]
    );
  }

  public function deleteAction()
  {
    $this->title = 'Удаление статьи';

    $form = new Delete();
    $formBuilder = new FormBuilder($form);

    if($this->request->isPost()){
      $post = $this->container->fabricate('factory.model', 'Post');

      try {
        $post->delete(
          [
            'name' => $this->request->post()->get('name') 
          ]
        );

        $this->response->redirect(ROOT);
      } catch (ValidatorException $e) {
        $form->addErrors($e->getErrors());
      }
    }

    $this->content = $this->template(
      'Delete', 'delete', ['form' => $formBuilder]
    );
  }
}