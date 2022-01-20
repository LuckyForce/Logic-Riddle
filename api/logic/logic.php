<?php
// Author: Adrian Stephan Schauer
// Created at: 2021-11-29
// This file handles every task that has to do with the users.
ini_set('display_errors', 1);

/*
¬ not
∨ or
& ∧ and
⊻ xor
1 True
0 False
→ implies
⟷ if and only if
↑ NAND
↓ NOR
*/

//evaluateExpression("(A∨B→(B∧C))");

function calculateExpression($expression)
{
    $result = calculateBrackets($expression, 0);
    return $result;
}

function calculateBrackets($expression, $startsearching)
{
    $selectedOpenBracket = mb_strpos($expression, "(", $startsearching, 'UTF-8');
    $followingOpenBracket = mb_strpos($expression, "(", $selectedOpenBracket + 1, 'UTF-8');
    $nextClosingBracket = mb_strpos($expression, ")", $selectedOpenBracket + 1, 'UTF-8');

    //Get the part of the expression between the brackets
    if ($selectedOpenBracket === false) {
        $result = calculateBracketPart($expression);
    } else if ($followingOpenBracket === false && $nextClosingBracket !== false || $followingOpenBracket > $nextClosingBracket) {
        $part = mb_substr($expression, $selectedOpenBracket + 1, $nextClosingBracket - $selectedOpenBracket - 1, 'UTF-8');
        $nexpression = mb_substr($expression, 0, $selectedOpenBracket, 'UTF-8') . calculateBracketPart($part) . mb_substr($expression, $nextClosingBracket + 1, strlen($expression) - $nextClosingBracket - 1, 'UTF-8');
        $result = calculateBrackets($nexpression, 0);
    } else if ($followingOpenBracket < $nextClosingBracket) {
        $result = calculateBrackets($expression, $followingOpenBracket);
    } else
        throw new Exception("Invalid Expression.");
    return $result;
}

function calculateBracketPart($expression)
{
    //This part goes to the function above before sending it to this function.
    $expression = str_replace("¬0", "1", $expression);
    $expression = str_replace("¬1", "0", $expression);

    //Take he first three characters of the expression and send it to calculatePairs.
    if ($expression === "0" || $expression === "1")
        return $expression;
    do {
        if (strlen($expression) < 3)
            throw new Exception("Invalid expression.");
        $expression = calculatePairs(mb_substr($expression, 0, 3, 'UTF-8')) . mb_substr($expression, 3, null, 'UTF-8');
    } while (strlen($expression) > 1);
    return $expression;
}

function calculatePairs($pair)
{
    //This function takes a pair of characters and evaluates them.
    $first = mb_substr($pair, 0, 1, 'UTF-8');
    $operator = mb_substr($pair, 1, 1, 'UTF-8');
    $second = mb_substr($pair, 2, 1, 'UTF-8');

    if (!preg_match("/^[∨∧⊻→⟷↑↓]+$/", $operator) && (($first != "0" && $first != "1") || ($second != "0" && $second != "1")))
        throw new Exception("Invalid Expression.");

    if ($first === "1" && $second === "1") {
        switch ($operator) {
            case "∨":
                return "1";
            case "∧":
                return "1";
            case "⊻":
                return "0";
            case "→":
                return "1";
            case "⟷":
                return "1";
            case "↑":
                return "0";
            case "↓":
                return "0";
        }
    } else if ($first === "1" && $second === "0") {
        switch ($operator) {
            case "∨":
                return "1";
            case "∧":
                return "0";
            case "⊻":
                return "1";
            case "→":
                return "0";
            case "⟷":
                return "0";
            case "↑":
                return "1";
            case "↓":
                return "0";
        }
    } else if ($first === "0" && $second === "1") {
        switch ($operator) {
            case "∨":
                return "1";
            case "∧":
                return "0";
            case "⊻":
                return "1";
            case "→":
                return "1";
            case "⟷":
                return "0";
            case "↑":
                return "1";
            case "↓":
                return "0";
        }
    } else if ($first === "0" && $second === "0") {
        switch ($operator) {
            case "∨":
                return "0";
            case "∧":
                return "0";
            case "⊻":
                return "0";
            case "→":
                return "1";
            case "⟷":
                return "1";
            case "↑":
                return "1";
            case "↓":
                return "1";
        }
    }
    throw new Exception("Invalid Expression.");
}

function createTable($expression)
{
    try {
        $alphabet = array(
            "A", "B", "C", "D", "E", "F", "G", "H", "I", "J",
            "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T",
            "U", "V", "W", "X", "Y", "Z"
        );

        $variables = array();

        for ($i = 0; $i < strlen($expression); $i++)
            if (in_array($expression[$i], $alphabet))
                array_push($variables, $expression[$i]);

        $variables = array_unique($variables);
        sort($variables);

        //Escape if there are more than 10 variables in the expression.
        if (count($variables) > 8)
            throw new Exception("Too many variables.");

        $table = array();

        $rows = pow(2, count($variables));
        $columns = count($variables);

        for ($column = 0; $column < $columns; $column++) {
            $counter = 0;
            $block = $rows / pow(2, $column);
            for ($row = 0; $row < $rows; $row++) {
                if ($block / 2 > $counter)
                    $table[$row][$column] = 1;
                else
                    $table[$row][$column] = 0;
                $counter++;
                if ($counter == $block)
                    $counter = 0;
            }
        }

        $results = array();
        $variables_copy = $variables;
        array_push($variables_copy, "Result");
        array_push($results, $variables_copy);
        for ($row = 0; $row < $rows; $row++) {
            $result = array();
            $nexpression = $expression;
            for ($column = 0; $column < $columns; $column++) {
                $nexpression = str_replace($variables[$column], $table[$row][$column], $nexpression);
                $result[$column] = $table[$row][$column];
            }

            $result[count($variables)] = calculateExpression($nexpression, 0);
            array_push($results, $result);
        }

        return $results;
    } catch (\Throwable $th) {
        http_response_code(400);
        echo json_encode(['error' => $th->getMessage()]);
        exit;
    }
}

function evaluateExpression($expression)
{
    if (preg_match("/^[ABCDEFGHIJKLMNOPQRSTUVWXYZ¬∨∧⊻10→⟷↑↓()]+$/", $expression) && strlen($expression) > 0 && strlen($expression) < 256) {
        $results = createTable($expression);
        return $results;
    } else {
        http_response_code(400);
        echo json_encode(['success' => false]);
        exit;
    }
}
