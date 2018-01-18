<?php
require_once 'core/db.inc.php';
require_once 'model.php';

class User extends EntityBase {
    public $userName,
        $firstName,
        $lastName,
        $email,
        $street,
        $zip,
        $city;

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
        $notNullOrEmpty = self::areNotNullOrEmpty($regData);
        $isEmailAddress = self::isEmailAddress($regData['email']);
        $passwordsAreMatching = $regData['password'] === $regData['passwordConfirmation'];
        $userNameDoesNotExists = is_null(self::getUserByUserName($regData['userName']));
        $emailAddressDoesNotExists = is_null(self::getUserByEmail($regData['email']));
        return $notNullOrEmpty && $isEmailAddress && $passwordsAreMatching && $userNameDoesNotExists && $emailAddressDoesNotExists;
    }

    public static function isEmailAddress($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }


    public static function getUserByUserName($userName) {
        $sql_query = "SELECT * FROM User WHERE userName= ?";
        $db = DB::getInstance();
        $stmt = $db->prepare($sql_query);
        $stmt->bind_param('s', $userName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            return null;
        } elseif ($result->num_rows == 1) {

            $userData = $result->fetch_assoc();

            $user = new User(
                $userData['id'],
                $userData['userName'],
                $userData['firstName'],
                $userData['lastName'],
                $userData['email'],
                $userData['street'],
                $userData['zip'],
                $userData['city']
            );
            return $user;
        } else {
            echo "Corrupted database state";
        }

    }

    public static function getUserById($id) {
        $sql_query = "SELECT * FROM User WHERE id= ?";
        $db = DB::getInstance();
        $stmt = $db->prepare($sql_query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            return null;
        } elseif ($result->num_rows == 1) {

            $userData = $result->fetch_assoc();

            $user = new User(
                $userData['id'],
                $userData['userName'],
                $userData['firstName'],
                $userData['lastName'],
                $userData['email'],
                $userData['street'],
                $userData['zip'],
                $userData['city']
            );
            return $user;
        } else {
            echo "Corrupted database state";
        }

    }

    public static function getUserByEmail($email) {
        $sql_query = "SELECT * FROM User WHERE email= ?";
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
            $userData['id'],
            $userData['userName'],
            $userData['firstName'],
            $userData['lastName'],
            $userData['email'],
            $userData['street'],
            $userData['zip'],
            $userData['city']
        );
        return $user;
    }

    public static function add(User $user, $password){
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $registrationDate = date("Y-m-d H:i:s");

        $sql_query = "INSERT INTO User (userName, firstName, lastName, email, street, zip, city, password, registrationDate) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $db = DB::getInstance();
        $stmt = $db->prepare($sql_query);
        $stmt->bind_param('sssssisss', $user->userName, $user->firstName, $user->lastName, $user->email, $user->street, $user->zip, $user->city, $passwordHash, $registrationDate);
        return $stmt->execute();
    }
}
