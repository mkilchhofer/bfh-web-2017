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
    public function renderRegisterForm() {
        global $lang;

        TemplateHelper::renderHeader();

        echo <<< REGISTERFORM
        <h3>{$lang['register']}</h3>
        <form action="processRegistration" method="post">
            <div class="form-group">
                <label for="login">{$lang['userName']}</label>
                <input type="text" class="form-control" name="userName" required>
            </div>
            
            <div class="form-group">
                <label for="password">{$lang['password']}</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            
            <div class="form-group">
                <label for="password">{$lang['password_confirm']}</label>
                <input type="password" class="form-control" name="passwordConfirmation" required>
            </div>
            
            <div class="form-group">
                <label for="text">{$lang['firstName']}</label>
                <input type="text" class="form-control" name="firstName" required>
            </div>
            
            <div class="form-group">
                <label for="text">{$lang['lastName']}</label>
                <input type="text" class="form-control" name="lastName"required>
            </div>
            
            <div class="form-group">
                <label for="text">{$lang['email']}</label>
                <input type="text" class="form-control" name="email"required>
            </div>
            
            <div class="form-group">
                <label for="text">{$lang['street']}</label>
                <input type="text" class="form-control" name="street"required>
            </div>
            
            <div class="form-group">
                <label for="text">{$lang['zip']}</label>
                <input type="text" class="form-control" name="zip" required>
            </div>
            
            <div class="form-group">
                <label for="text">{$lang['city']}</label>
                <input type="text" class="form-control" name="city" required>
            </div>
        
            <button type="submit" class="btn btn-default">{$lang['register']}</button>
        </form>
REGISTERFORM;

        TemplateHelper::renderFooter();
    }

    public function renderRegisterConfirmation() {

        TemplateHelper::renderHeader();
        echo "<h3>Registration Confirmation</h3>";
        TemplateHelper::renderFooter();
    }

}
