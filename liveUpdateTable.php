<?php
session_start();

if (isset($_POST) && count($_POST)) {

    $action = $_POST['action'];
    unset($_POST['action']);

    if ($action == "save") {
        if (isset($_SESSION['tableID'])) {
            $_SESSION['tableID'] = $_SESSION['tableID'] + 1;
        } else {
            $_SESSION['tableID'] = 1;
        }
        $escapedPost = array_map('mysql_real_escape_string', $_POST);
        $escapedPost = array_map('htmlentities', $escapedPost);
        
        $escapedPost["success"] = "1";
        $escapedPost["id"] = $_SESSION['tableID'];
        array_push($_SESSION['test'], $escapedPost);
        echo json_encode($escapedPost);
    } else if ($action == "del") {
        $id = $_POST['rid'];
        $key = array_search($id, array_column($_SESSION['test'], 'id'));
        unset($_SESSION['test'][$key]);
        $testing = array_filter($_SESSION['test']);
        $_SESSION['test'] = array_slice($testing, 0);
        echo json_encode(array("success" => "1", "id" => $id));
    } else if ($action == "update") {
        $id = $_POST['rid'];
        $escapedPost = array_map('mysql_real_escape_string', $_POST);
        $escapedPost = array_map('htmlentities', $escapedPost);
        $newData = $_POST;
        unset($newData['rid']);
        $newData['success'] = 1;
        $newData['id'] = $id;
        $_SESSION['test'][array_search($id, array_column($_SESSION['test'], 'id'))] = $newData;
        echo json_encode(array_merge(array("success" => "1", "id" => $id), $escapedPost));
    } else if ($action == "updated") {
        /*
        $escapedPost = array_map('mysql_real_escape_string', $_POST);
        $escapedPost = array_map('htmlentities', $escapedPost);
        echo json_encode(array_merge(array("success" => "1", "id" => $id), $escapedPost));
         */
    }
}
?>