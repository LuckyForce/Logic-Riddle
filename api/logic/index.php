<?php
// Author: Adrian Stephan Schauer
// Created at: 2021-12-02
// This file calculates the answer for the given expression.
try {
    //Get the data from the request.
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['expression'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Expression is missing.']);
        exit;
    }

    require 'logic.php';

    $result = evaluateExpression($data['expression']);

    http_response_code(200);
    echo json_encode(['success' => 'Calculated Successfully', 'result' => $result]);
    exit;
} catch (\Throwable $th) {
    http_response_code(400);
    echo json_encode(['error' => 'Bad request']);
    exit;
}
