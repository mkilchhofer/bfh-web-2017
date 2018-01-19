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

    public function Logout() {
        $this->view->renderLogout();
    }

    public function Register() {
        $this->view->renderRegisterForm();
    }

    public function userNameDoesNotExists($userName) {
        if (is_null($this->model->getUserByUserName($userName))) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function emailDoesNotExists($email) {
        if (is_null($this->model->getUserByEmail($email))) {
            echo 1;
        }
        else {
            echo 0;
        }
    }

    public function processRegistration() {
        $regData = array_map('strip_tags', $_POST);
        $valid = $this->model->validate($regData);

        if ($valid) {
            $user = new User();
            $user->userName = $regData['userName'];
            $user->firstName = $regData['firstName'];
            $user->lastName = $regData['lastName'];
            $user->email = $regData['email'];
            $user->street = $regData['street'];
            $user->zip = $regData['zip'];
            $user->city = $regData['city'];

            $this->model->add($user, $regData['password']);
            $this->view->renderRegisterConfirmation();
        } else {
            $this->view->renderRegisterError();
        }
    }
}
