<?php


class UserView
{

    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function renderLogin() {
        global $lang;
        global $language;

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

    }

    public function renderLogout() {
        global $lang;

        echo "<h3>Logout</h3>";
    }
    public function renderRegister() {
        global $lang;

        echo "<h3>Register</h3>";
    }

}
