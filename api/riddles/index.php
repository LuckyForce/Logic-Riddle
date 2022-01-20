<?php
// Author: Adrian Stephan Schauer
// Created at: 2021-11-29
// This file handles every task that has to do with the users.
ini_set('display_errors', 1);

try {
    $data = json_decode(file_get_contents('php://input'), true);

    //Check what task is required.
    if (!empty($data['task']))
        switch ($data['task']) {
            case 'getRiddles':
                getRiddles();
                break;
            case 'checkRiddle':
                checkRiddle();
                break;
            case 'createRiddle':
                createRiddle();
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

function getRiddles()
{
    //Get the data from the request.
    $data = json_decode(file_get_contents('php://input'), true);

    //Check what filters are set.
    if (!isset($data['searchtext']) || $data['searchtext'] == null)
        $searchtext = '%';
    else
        $searchtext = '%'.$data['searchtext'].'%';

    if (!isset($data['searchuser']) || $data['searchuser'] == null)
        $searchuser = '%';
    else
        $searchuser = '%'.$data['searchuser'].'%';

    if (!isset($data['order']) || $data['order'] == null) {
        $order = 'DESC';
    } else
        if ($data['order'] == 'asc')
        $order = "ASC";
    else
        $order = "DESC";

    if ((!isset($data['diff']) || $data['diff'] == null) && $data['diff'] != "1" && $data['diff'] != "2" && $data['diff'] != "3" && $data['diff'] != "4" && $data['diff'] != "5") {
        $diff = 'all';
    } else {
        $diff = intval($data['diff']);
    }

    require '../dbconnect.php';

    //Get the riddles from the database.
    if($diff=='all'){
        $stmt = $conn->prepare("SELECT l_ri_id, l_ri_title, l_ri_diff, l_ri_createdat, l_ri_desc, l_u_user FROM l_ri_riddles INNER JOIN l_u_users ON l_ri_riddles.l_ri_u_creator = l_u_users.l_u_id WHERE l_ri_title LIKE :searchtext AND l_u_user LIKE :searchuser ORDER BY l_ri_createdat $order");
        $stmt->bindParam(':searchtext', $searchtext);
        $stmt->bindParam(':searchuser', $searchuser);
        $stmt->execute();

        //Send Response
        http_response_code(200);
        echo json_encode(['success' => true, 'riddles' => $stmt->fetchAll()]);
        exit;
    }else{
        $stmt = $conn->prepare("SELECT l_ri_id, l_ri_title, l_ri_diff, l_ri_createdat, l_ri_desc, l_u_user FROM l_ri_riddles INNER JOIN l_u_users ON l_ri_riddles.l_ri_u_creator = l_u_users.l_u_id WHERE l_ri_title LIKE :searchtext AND l_ri_diff = :diff AND l_u_user LIKE :searchuser ORDER BY l_ri_createdat $order");
        $stmt->bindParam(':searchtext', $searchtext);
        $stmt->bindParam(':diff', $diff);
        $stmt->bindParam(':searchuser', $searchuser);
        $stmt->execute();

        //Send Response
        http_response_code(200);
        echo json_encode(['success' => true, 'riddles' => $stmt->fetchAll()]);
        exit;
    }

}

function checkRiddle()
{
    //Get the data from the request.
    $data = json_decode(file_get_contents('php://input'), true);

    //Check if the data is valid.
    if (!isset($data['id']) || !isset($data['expression'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Bad request']);
        exit;
    }
    require '../dbconnect.php';
    require '../logic/logic.php';

    //Get Expression from Riddle with the help of the id.
    $stmt = $conn->prepare('SELECT l_ri_solution FROM l_ri_riddles WHERE l_ri_id = :id');
    $stmt->bindParam(':id', $data['id']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result != false) {
        $solution = $result['l_ri_solution'];
        $expression = $data['expression'];
        $result_solution = evaluateExpression($solution);
        $result_expression = evaluateExpression($expression);
        if ($result_solution == $result_expression) {
            http_response_code(200);
            echo json_encode(['success' => true]);
        } else {
            http_response_code(200);
            echo json_encode(['success' => false]);
        }
    }
}

function createRiddle()
{
    //TODO: Create Riddle.
    //Get the data from the request.
    $data = json_decode(file_get_contents('php://input'), true);    
    
    require '../logic/logic.php';

    //Check if the data is valid.
    if (!isset($data['title']) || !isset($data['expression']) || !isset($data['diff']) || !isset($data['email']) || !isset($data['pw']) || $data['title'] == null || is_string($data['title']) == false || strlen($data['title']) < 1 || $data['expression'] == null || is_string($data['expression']) == false || strlen($data['expression']) < 1 || $data['diff'] == null || is_numeric($data['diff']) == false || $data['diff'] < 1 || $data['diff'] > 5 || $data['description'] == null || !isset($data['description']) || $data['description'] == null || is_string($data['description']) == false || strlen($data['description']) < 1){
        http_response_code(400);
        echo json_encode(['error' => 'Bad request TEST']);
        exit;
    }
    
    evaluateExpression($data['expression']);
    
    //Hash password.
    $pw = $data['pw'];
    
    //Check if the password is correct.
    require '../dbconnect.php';
    $stmt = $conn->prepare("SELECT l_u_id, l_u_pw FROM l_u_users WHERE l_u_email = :email AND l_u_verified = 1");
    $stmt->bindParam(':email', $data['email']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result != false && password_verify($pw, $result['l_u_pw'])) {
        //Create Riddle.

        $stmt = $conn->prepare("INSERT INTO l_ri_riddles (l_ri_title, l_ri_solution, l_ri_diff, l_ri_u_creator, l_ri_desc) VALUES (:title, :expression, :diff, :user, :descript)");
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':expression', $data['expression']);
        $stmt->bindParam(':diff', $data['diff']);
        $stmt->bindParam(':user', $result['l_u_id']);
        $stmt->bindParam(':descript', $data['description']);
        $stmt->execute();

        //Get ID of the last STMT transaction
        $stmt = $conn->prepare("SELECT l_ri_id FROM l_ri_riddles ORDER BY l_ri_id DESC LIMIT 1");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        //Send Response
        http_response_code(200);
        echo json_encode(['success' => true, 'id' => $result['l_ri_id']]);
        exit;
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'You need an valid Account to create a Riddle.']);
        exit;
    }
}
