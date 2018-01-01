<?php
require_once(__DIR__ . '/../TemplateHelper.php');

class UserView
{

    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function renderLogin() {
        global $lang;
        global $language;
        TemplateHelper::renderHeader();

        if (!isset($_SESSION['userId'])){
            echo <<< LOGINFORM
<h3>{$lang['login']}</h3>
<form action="/{$language}/MyGear/showList" method="post">
    <div class="form-group">
        <label for="login">{$lang['userName']}</label>
        <input type="text" class="form-control" name="login">
    </div>
    <div class="form-group">
        <label for="password">{$lang['password']}</label>
        <input type="password" class="form-control" name="pw">
    </div>
    <button type="submit" class="btn btn-default">{$lang['login']}</button>
</form>
LOGINFORM;
        }
        else {
            echo "already logged in";
        }
        TemplateHelper::renderFooter();

    }

    public function renderLogout() {
        global $lang;
        global $language;

        session_start();
        $_SESSION=[];
        setcookie(session_name(),'',1);
        setcookie("loggedIn", "false", time() + (86400 / 24), "/");
        header("location:/$language/User/Login");
    }
    public function renderRegister() {
        global $lang;
        TemplateHelper::renderHeader();
        echo "<h3>Register</h3>";
        TemplateHelper::renderFooter();
    }

}
