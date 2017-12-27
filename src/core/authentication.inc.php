<?php
session_start();
require_once 'core/db.inc.php';

if(isset($_POST["login"]) && isset($_POST["pw"])) {
    $login = $_POST["login"];
    $pw = $_POST["pw"];

    $check = checklogin($login,$pw);

    if($check["verified"]) {
        $_SESSION["userId"] = $check["userId"];
    }
}
global $language;

if(!isset($_SESSION["userId"])) {
    echo"<!DOCTYPE html>\n";
    echo'<a href="/' . $language . '/User/Login">Please log in</a>.';
    exit;
}

function checklogin($login,$password) {
    // db error checking omitted...

    $db = DB::getInstance();

    $stmt = $db->prepare("SELECT * FROM User WHERE UserName=?");
    $stmt->bind_param('s', $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if(!$result || $result->num_rows !== 1) {
        return array('verified' => false, 'userId' => null);
    }
    $row = $result->fetch_assoc();

    return array('verified' => password_verify($password, $row["Password"]), 'userId' => $row["UserId"]);
}
