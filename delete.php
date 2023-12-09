<?php
include_once("connection.php");
include_once("config.php");
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous_page = array_slice(explode('/', $_SERVER['HTTP_REFERER']), -1)[0];
    if ($previous_page == 'loans.php'){
        $table = 'loans';
    }
    else if ($previous_page == 'lenders.php') {
        $table = 'borrower';
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['id'])) {
            $id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
            $id = intval($id);
            $stmt = $pdo->prepare('DELETE FROM '.$table.' WHERE id = :id');
            $stmt->execute(['id' => $id]);
            echo "Record deleted successfully";
        } else {
            http_response_code(400);
            echo "No id provided";
        }
    } else {
        http_response_code(405);
        echo "Invalid request method";
    }
}
else {
    header('location: index.php');
}
