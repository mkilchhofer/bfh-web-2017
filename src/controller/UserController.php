<?php

require_once('model/UserModel.php');
require_once('view/UserView.php');

class UserController
{
    private $model;
    private $view;

    public function __construct() {
        $this->model = new UserModel();
        $this->view = new UserView($this->model);
    }

    public function Login() {
        $this->view->renderLogin();
    }

    public function Logout(){
        $this->view->renderLogout();
    }

    public function Register() {
        $this->view->renderRegisterForm();
    }

    public function processRegistration() {
        $regData = $_POST;
        $valid = $this->model->validate($regData);
        echo 'Validation result=';
        var_dump($valid);
        echo '<br />';

        if ($valid) {
            $user = new User(null,
                $regData['userName'],
                $regData['firstName'],
                $regData['lastName'],
                $regData['email'],
                $regData['street'],
                $regData['zip'],
                $regData['city']);
            echo 'Creating User...';
            echo '<br />';
            $result = $this->model->add($user, $regData['password']);
            #$this->view->renderRegisterConfirmation();
            echo 'Insert Result= ';
            var_dump($result);
        } else {
            echo 'User Creation failed';
            echo '<br />';
        }
        echo 'Processing finished';
        echo '<br />';
    }
}
