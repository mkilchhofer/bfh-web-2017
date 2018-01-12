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
                <div class="invalid-feedback">Username is not available</div>
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
                <div class="invalid-feedback">Email address is not available</div>
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
        <script>
        $(document).ready(function(){
            $("input[name=userName]").focusout(function(){
                checkUserNameAvailability();
            });
            $("input[name=email]").focusout(function(){
                checkEmailAvailability();
            });
        });
        
        function checkUserNameAvailability(){  
            var userName = $("input[name=userName]").val();
            console.log(userName);
            $.post("/en/User/userNameDoesNotExists/" + userName, { userName: userName },  
                function(result){  
                    console.log(result);
                    $("input[name=userName]").removeClass("is-valid is-invalid");
                    if(result == 1) { 
                        console.log("is available");
                        $("input[name=userName]").addClass("is-valid");
                        
                    } else if (result == 0) {  
                        console.log("is not available");
                        $("input[name=userName]").addClass("is-invalid");
                    }  else {
                        console.log("Did not receive an answer from the server");
                    }
            });  
        }
        
        function checkEmailAvailability(){  
            var email = $("input[name=email]").val();
            console.log(email);
            $.post("/en/User/emailDoesNotExists/" + email, { email: email },  
                function(result){  
                    console.log(result);
                    $("input[name=email]").removeClass("is-valid is-invalid");
                    if(result == 1) { 
                        console.log("is available");
                        $("input[name=email]").addClass("is-valid");
                        
                    } else if (result == 0) {  
                        console.log("is not available");
                        $("input[name=email]").addClass("is-invalid");
                    }  else {
                        console.log("Did not receive an answer from the server");
                    } 
            });  
        }       
        </script>
REGISTERFORM;

        TemplateHelper::renderFooter();
    }

    public function renderRegisterConfirmation() {
        TemplateHelper::renderHeader();
        echo "<div class=\"alert alert-success\" role=\"alert\">Successfully registered user!</div>";
        TemplateHelper::renderFooter();
    }

    public function renderRegisterError() {
        TemplateHelper::renderHeader();
        echo "<div class=\"alert alert-danger\" role=\"alert\">User registration failed, please try again!</div>";
        TemplateHelper::renderFooter();
    }


}
