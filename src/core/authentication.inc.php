<?php
require_once 'core/db.inc.php';

if(isset($_POST["login"]) && isset($_POST["pw"])) {
    $login = $_POST["login"];
    $pw = $_POST["pw"];

    $check = checklogin($login,$pw);

    if($check["verified"]) {
        $_SESSION["userId"] = $check["userId"];
        setcookie("loggedIn", "true", time() + (86400 / 24), "/");
    }
}
global $language;

if(!isset($_SESSION["userId"])) {
    header("location:/$language/User/Login");
    exit;
}

function checklogin($userName,$password) {
    // db error checking omitted...

    $db = DB::getInstance();

    $stmt = $db->prepare("SELECT * FROM User WHERE userName=?");
    $stmt->bind_param('s', $userName);
    $stmt->execute();
    $result = $stmt->get_result();

    if(!$result || $result->num_rows !== 1) {
        return array('verified' => false, 'userId' => null);
    }
    $row = $result->fetch_assoc();

    return array('verified' => password_verify($password, $row["password"]), 'userId' => $row["id"]);
}
