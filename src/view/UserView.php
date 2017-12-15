<?php


class UserView
{

    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function renderLogin() {
        global $lang;

        if (!isset($_SESSION['userId'])){
            echo "<h3>Login</h3>
<form action=\"/MyGear/showList\" method=\"post\">
    <p>
        <label>Login</label>
        <input name=\"login\">
    </p>
    <p>
        <label>Password</label>
        <input type=\"password\" name=\"pw\">
    </p>
    <p>
        <input type=\"submit\" value=\"Login\">
    </p>
</form>";
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
