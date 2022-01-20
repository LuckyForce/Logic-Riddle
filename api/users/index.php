<?php
// Author: Adrian Stephan Schauer
// Created at: 2021-11-29
// This file handles every task that has to do with the users.
ini_set('display_errors', 1);

// Function cus we aint have PHP 8 everywhere.
// based on original work from the PHP Laravel framework
if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle)
    {
        return $needle !== '' && mb_strpos($haystack, $needle) !== false;
    }
}

try {
    //Get the data from the request.
    $data = json_decode(file_get_contents('php://input'), true);

    //Check what task is required.
    if (!empty($data['task']))
        switch ($data['task']) {
            case 'checkPassword':
                checkPassword();
                break;
            case 'createUser':
                createUser();
                break;
            case 'resendCode':
                resendCode();
                break;
            case 'verifyUser':
                verifyUser();
                break;
            case 'changePassword':
                changePassword();
                break;
            case 'changeUsername':
                changeUsername();
                break;
            case 'checkUsername':
                checkUsername();
                break;
            case 'checkEmail':
                checkEmail();
                break;
            case 'deleteUser':
                deleteUser();
                break;
            default:
                throw new Exception("Task not found.");
        }
    else
        throw new Exception("No task specified.");
} catch (\Throwable $th) {
    http_response_code(400);
    echo json_encode(['error' => $th->getMessage()]);
    exit;
}

function checkPassword()
{
    //Get the data from the request.
    $data = json_decode(file_get_contents('php://input'), true);

    //Check if the data is valid.
    if (!isset($data['email']) || !isset($data['pw'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Bad request']);
        exit;
    }

    //Hash password.
    $pw = $data['pw'];

    //Check if the password is correct.
    require '../dbconnect.php';
    $stmt = $conn->prepare("SELECT l_u_pw FROM l_u_users WHERE l_u_email = :email AND l_u_verified = 1");
    $stmt->bindParam(':email', $data['email']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result != false && password_verify($pw, $result['l_u_pw'])) {
        http_response_code(200);
        echo json_encode(['success' => true]);
        exit;
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid password']);
        exit;
    }
}

function resendCode()
{
    //Get the data from the request.
    $data = json_decode(file_get_contents('php://input'), true);

    //Check if the data is valid.
    if (!isset($data['email'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Bad request']);
        exit;
    }

    require '../dbconnect.php';

    $stmt = $conn->prepare('SELECT l_u_user, l_u_code FROM l_u_users WHERE l_u_email = :email AND l_u_verified = 0');
    $stmt->bindParam(':email', $data['email']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result == false) {
        http_response_code(400);
        echo json_encode(['error' => 'Account already verified or does not exist.']);
        exit;
    }

    sendVerificationEmail($data['email'], $result['l_u_user'], $result['l_u_code']);

    //Send response.
    http_response_code(200);
    echo json_encode(['success' => 'Email sent.']);
    exit;
}

function verifyUser()
{
    //Get the data from the request.
    $data = json_decode(file_get_contents('php://input'), true);

    //Check if the data is valid.
    if (!isset($data['code']) || !isset($data['email'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Bad request']);
        exit;
    }

    //Check if the code is valid.
    require '../dbconnect.php';
    $stmt = $conn->prepare('SELECT l_u_user FROM l_u_users WHERE l_u_email = :email AND l_u_code = :code');
    $stmt->bindParam(':email', $data['email']);
    $stmt->bindParam(':code', $data['code']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result == false) {
        http_response_code(400);
        echo json_encode(['error' => 'Bad request']);
        exit;
    } else {
        //Assign the username to a variable.
        $user = $result['l_u_user'];

        //Check if the username is already in use.
        $stmt = $conn->prepare('SELECT l_u_user FROM l_u_users WHERE l_u_user = :user AND l_u_verified = 1');
        $stmt->bindParam(':user', $user);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result != false) {
            //Assign random username.
            while (true) {
                $user = "Random_" . rand(0, 99999);

                //Check if the username is already in use.
                $stmt = $conn->prepare('SELECT l_u_user FROM l_u_users WHERE l_u_user = :user');
                $stmt->bindParam(':user', $user);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result == false) {
                    break;
                }
            }
            //Change the username.
            $stmt = $conn->prepare('UPDATE l_u_users SET l_u_user = :user WHERE l_u_email = :email');
            $stmt->bindParam(':user', $user);
            $stmt->bindParam(':email', $data['email']);
            $stmt->execute();
        }

        //Verify the user.
        $stmt = $conn->prepare('UPDATE l_u_users SET l_u_verified = 1 WHERE l_u_email = :email');
        $stmt->bindParam(':email', $data['email']);
        $stmt->execute();

        //Send response.
        http_response_code(200);
        echo json_encode(['success' => 'User verified.']);
        exit;
    }
}

function sendVerificationEmail($email, $user, $code)
{
    require '../phpmailer/mail.php';
    $mail->addAddress($email, $user);
    $mail->isHTML(true);
    $mail->Subject = 'Logik-Riddle Verification';
    $mail->Body    =
        '<style type="text/css">

    </style>
    Dear ' . $user . ',<br><br>
    thank you for registering at Logik-Riddle.<br>
    Here is the following Code to verify your account:<br><br>
    ' . $code . '<br><br>
    If you shouldn\'t have recieved this, please ignore this email.<br><br>
    Your Logik-Riddle Team' . $mailfooter;
    $mail->AltBody =
        'Dear ' . $user . ',
    thank you for registering at Logik-Riddle.
    Here is the following Code to verify your account:
    ' . $code . '
    If you shouldn\'t have recieved this ignore this email, please.
    Your Logik-Riddle Team' . $mailfooternohtml;;
    $mail->send();
}

function changePassword()
{
    //Get the data from the request.
    $data = json_decode(file_get_contents('php://input'), true);

    //Check if the data is valid.
    if (!isset($data['email']) || !isset($data['pw']) || !isset($data['npw']) || $data['npw'] == null || is_string($data['npw']) == false || strlen($data['npw']) < 8 || strlen($data['npw']) > 30 || str_contains($data['npw'], ' ')) {
        http_response_code(400);
        echo json_encode(['error' => 'Bad request']);
        exit;
    }
    //Import File to connect to the database server.
    require '../dbconnect.php';
    //Check in database if the user exists.
    $stmt = $conn->prepare('SELECT l_u_pw FROM l_u_users WHERE l_u_email = :email');
    $stmt->bindParam(':email', $data['email']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    //Hash password
    $pw = $data['pw'];

    //Check if the password is correct.
    if (!password_verify($pw, $result['l_u_pw'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Password is wrong']);
        exit;
    } else {
        //Hash the new password.
        $npw = $data['npw'];
        $npw = password_hash($npw, PASSWORD_DEFAULT);
        //Change the password.
        $stmt = $conn->prepare('UPDATE l_u_users SET l_u_pw = :npw WHERE l_u_email = :email');
        $stmt->bindParam(':npw', $npw);
        $stmt->bindParam(':email', $data['email']);
        $stmt->execute();
        //Send the response.
        http_response_code(200);
        echo json_encode(['success' => 'Password changed']);
        exit;
    }
}

function changeUsername()
{
    //Get the data from the request.
    $data = json_decode(file_get_contents('php://input'), true);

    //Check if the data is valid.
    if (!isset($data['email']) || !isset($data['pw']) || userExists()) {
        http_response_code(400);
        echo json_encode(['error' => 'Bad request']);
        exit;
    }

    //Import File to connect to the database server.
    require '../dbconnect.php';

    //Check in database if the user exists.
    $stmt = $conn->prepare('SELECT l_u_pw FROM l_u_users WHERE l_u_email = :email');
    $stmt->bindParam(':email', $data['email']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    //Check if the password is correct.
    if (!password_verify($data['pw'], $result['l_u_pw'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Password is wrong']);
        exit;
    } else {
        //Change the username.
        $stmt = $conn->prepare('UPDATE l_u_users SET l_u_user = :user WHERE l_u_email = :email');
        $stmt->bindParam(':user', $data['user']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->execute();
        //Send the response.
        http_response_code(200);
        echo json_encode(['success' => 'Username changed']);
        exit;
    }
}

function userVerified($email)
{
    //Import File to connect to the database server.
    require '../dbconnect.php';

    //Checks is user is verified.
    $stmt = $conn->prepare('SELECT l_u_verified FROM l_u_users WHERE l_u_email = :email AND l_u_verified = 1');
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result == false) return false;
    else return true;
}

function userExists()
{
    //Get the data from the request.
    $data = json_decode(file_get_contents('php://input'), true);

    //Check if the data is valid.
    if (!isset($data['user']) || $data['user'] == null || is_string($data['user']) == false || strlen($data['user']) < 5 || str_contains($data['user'], ' ')) {
        http_response_code(400);
        echo json_encode(['error' => 'Bad request']);
        exit;
    }

    //Import File to connect to the database server.
    require '../dbconnect.php';

    //Checks if user exists.
    $stmt = $conn->prepare('SELECT l_u_user FROM l_u_users WHERE l_u_user = :user AND l_u_verified = 1');
    $stmt->bindParam(':user', $data['user']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result == false) return false;
    else return true;
}

function checkUsername()
{
    http_response_code(200);
    echo json_encode(['success' => !userExists()]);
    exit;
}

function emailExists()
{
    //Get the data from the request.
    $data = json_decode(file_get_contents('php://input'), true);

    //Check if the data is valid.
    if (!isset($data['email']) || $data['email'] == null || !filter_var($data['email'], FILTER_VALIDATE_EMAIL) || preg_match("/[&|><=?]/", $data['email'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Bad request']);
        exit;
    }

    //Import File to connect to the database server.
    require '../dbconnect.php';

    //Checks is user is available.
    $stmt = $conn->prepare('SELECT l_u_email FROM l_u_users WHERE l_u_email = :email AND l_u_verified = 1');
    $stmt->bindParam(':email', $data['email']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result == false) return false;
    else return true;
}

function checkEmail()
{
    http_response_code(200);
    echo json_encode(['success' => !emailExists()]);
    exit;
}

function createUser()
{
    if (!userExists() && !emailExists()) {
        //Get the data from the request.
        $data = json_decode(file_get_contents('php://input'), true);

        //Check if the password is valid.
        if (!isset($data['pw']) || $data['pw'] == null || is_string($data['pw']) == false || strlen($data['pw']) < 8 || strlen($data['pw']) > 30 || str_contains($data['pw'], ' ')) {
            http_response_code(400);
            echo json_encode(['error' => 'Bad request']);
            exit;
        }

        //Generate a random six digit code.
        $code = rand(100000, 999999);

        //Encrypt the password.
        $pw = password_hash($data['pw'], PASSWORD_DEFAULT);

        //Import File to connect to the database server.
        require '../dbconnect.php';

        //Checks if email is already in the database but not verified.
        $stmt = $conn->prepare('SELECT l_u_email FROM l_u_users WHERE l_u_email = :email');
        $stmt->bindParam(':email', $data['email']);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result == false) {
            //Create a new user
            $stmt = $conn->prepare('INSERT INTO l_u_users SET l_u_email = :email , l_u_user = :user, l_u_pw = :pw, l_u_code = :code');
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':user', $data['user']);
            $stmt->bindParam(':pw', $pw);
            $stmt->bindParam(':code', $code);
            $stmt->execute();
        } else {
            //Updates the user.
            $stmt = $conn->prepare('UPDATE l_u_users SET l_u_user = :user, l_u_pw = :pw, l_u_code = :code WHERE l_u_email = :email');
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':user', $data['user']);
            $stmt->bindParam(':pw', $pw);
            $stmt->bindParam(':code', $code);
            $stmt->execute();
        }
        //Send Verification Email.
        sendVerificationEmail($data['email'], $data['user'], $code);

        //Send the response.
        http_response_code(200);
        echo json_encode(['success' => 'User created']);
        exit;
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'User already exists']);
        exit;
    }
}

function deleteUser()
{
    //Get the data from the request.
    $data = json_decode(file_get_contents('php://input'), true);

    //Check if the data is valid.
    if (!isset($data['email']) || !isset($data['pw'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Bad request']);
        exit;
    }

    //Import File to connect to the database server.
    require '../dbconnect.php';

    //Checks if user is available.
    $stmt = $conn->prepare('SELECT l_u_pw FROM l_u_users WHERE l_u_email = :email AND l_u_verified = 1');
    $stmt->bindParam(':email', $data['email']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result == false) {
        http_response_code(400);
        echo json_encode(['error' => 'User does not exist']);
        exit;
    }

    //Checks if password is correct.
    if (!password_verify($data['pw'], $result['l_u_pw'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Password is incorrect']);
        exit;
    }

    //Delete the user.
    $stmt = $conn->prepare('SELECT l_u_id FROM l_u_users WHERE l_u_email = :email');
    $stmt->bindParam(':email', $data['email']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $conn->prepare('DELETE FROM l_ri_riddles WHERE l_ri_u_creator = :id');
    $stmt->bindParam(':id', $result['l_u_id']);
    $stmt->execute();

    $stmt = $conn->prepare('DELETE FROM l_u_users WHERE l_u_id = :id');
    $stmt->bindParam(':id', $result['l_u_id']);
    $stmt->execute();

    //Send the response.
    http_response_code(200);
    echo json_encode(['success' => 'User deleted']);
    exit;
}
