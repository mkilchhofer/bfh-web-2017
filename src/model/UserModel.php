<?php

require_once 'core/db.inc.php';

class User {
    public $id, $userName, $firstName, $lastName, $email, $street, $zip, $city;

    function __construct($id, $userName, $firstName, $lastName, $email, $street, $zip, $city) {
        $this->id = $id;
        $this->userName = $userName;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->street = $street;
        $this->zip = $zip;
        $this->city = $city;
    }
}


class UserModel {

    private static function areNotNullOrEmpty($values) {
        $values = func_get_args();
        foreach ($values as $value) {
            if (!isset($value) || trim($value) === '') {
                return false;
            }
        }
        return true;
    }

    public static function validate($regData) {
        echo 'Entering validation...';
        echo '<br />';

        $notNullOrEmpty = self::areNotNullOrEmpty($regData);
        echo 'notNullOrEmpty=';
        var_dump($notNullOrEmpty);
        echo '<br />';

        $isEmailAddress = filter_var($regData['email'], FILTER_VALIDATE_EMAIL);
        echo 'isEmailAddress=';
        var_dump($isEmailAddress);
        echo '<br />';

        $passwordsAreMatching = $regData['password'] === $regData['passwordConfirmation'];
        echo 'passwordsAreMatching=';
        var_dump($passwordsAreMatching);
        echo '<br />';

        $userNameDoesNotExists = is_null(self::getUserByUserName($regData['userName']));
        echo 'userNameDoesNotExists=';
        var_dump($userNameDoesNotExists);
        echo '<br />';

        $emailAddressDoesNotExists = is_null(self::getUserByEmail($regData['email']));
        echo 'emailAddressDoesNotExists=';
        var_dump($emailAddressDoesNotExists);
        echo '<br />';

        return $notNullOrEmpty && $isEmailAddress && $passwordsAreMatching && $userNameDoesNotExists && $emailAddressDoesNotExists;
    }


    public static function getUserByUserName($userName) {
        $sql_query = "SELECT * FROM User WHERE UserName= ?";
        $db = DB::getInstance();
        $stmt = $db->prepare($sql_query);
        $stmt->bind_param('s', $userName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            return null;
        }

        $userData = $result->fetch_assoc();

        $user = new User(
            $userData['UserId'],
            $userData['UserName'],
            $userData['FirstName'],
            $userData['LastName'],
            $userData['EmailAddress'],
            $userData['AddressStreet'],
            $userData['AddressZIP'],
            $userData['AddressCity']
        );
        return $user;
    }

    public static function getUserByEmail($email) {
        $sql_query = "SELECT * FROM User WHERE EmailAddress= ?";
        $db = DB::getInstance();
        $stmt = $db->prepare($sql_query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            return null;
        }

        $userData = $result->fetch_assoc();
        $user = new User(
            $userData['UserId'],
            $userData['UserName'],
            $userData['FirstName'],
            $userData['LastName'],
            $userData['EmailAddress'],
            $userData['AddressStreet'],
            $userData['AddressZIP'],
            $userData['AddressCity']
        );
        return $user;
    }

    public static function add(User $user, $password){
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $registrationDate = date("Y-m-d H:i:s");

        $sql_query = "INSERT INTO User (UserName, FirstName, LastName, EmailAddress, AddressStreet, AddressZIP, AddressCity, Password, RegistrationDate) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $db = DB::getInstance();
        $stmt = $db->prepare($sql_query);
        $stmt->bind_param('sssssisss', $user->userName, $user->firstName, $user->lastName, $user->email, $user->street, $user->zip, $user->city, $passwordHash, $registrationDate);
        return $stmt->execute();
    }
}
