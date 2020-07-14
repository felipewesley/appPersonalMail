<?php

/**
 * @author Felipe Wesley
 * @link https://github.com/felipewesley/mini-framework-php-mvc
 */

namespace App\Controller;

use MiniFramework\Controller\Action;
use MiniFramework\Controller\Debug;

// use MiniFramework\Controller\Debug;

class PersonalMailController extends Action {

    public function index(){

        /**
         * A busca inicial pelas rotas começa aqui
         * Se a rota requisitada não existir no seu projeto, este método será chamado
         */

        return $this->render('index');
    }

    public function about(){

        $this->view->title = 'About';

        return $this->render('about', 'appMailLayout', ['css' => 'about', 'js' => 'about']);
	}

	public function newMail(){

        return $this->render('newMail');
	}

	public function mailProcess(){

		$m = $this->model('ProcessaMail');
		$m->setData('user', $_POST);

		$email = $m->criaEmail($m->criaMensagem($_POST['destino'],$_POST['assunto'],$_POST['txt-content']));

		return $email;

	}

	public function confirm(){

		$this->view->email = $this->mailProcess();

		$this->render('confirm', 'appMailLayout', ['js' => 'confirm_script']);

		unset($_POST);

		return 1;
	}
}
