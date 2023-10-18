<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json; charset=UTF-8');
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipient = "perruzzi12@gmail.com";
    $subject = "Email from my *****";
    $visitor_name = "";
    $visitor_email = "";
    $message = "";
    $fail = [];

    // Sanitize and validate input fields.
    if (isset($_POST['firstname']) && !empty($_POST['firstname'])) {
        $visitor_name = filter_var($_POST['firstname'], FILTER_SANITIZE_SPECIAL_CHARS);
    } else {
        array_push($fail, "firstname");
    }

    if (isset($_POST['lastname']) && !empty($_POST['lastname'])) {
        $visitor_name .= ' ' . filter_var($_POST['lastname'], FILTER_SANITIZE_SPECIAL_CHARS);
    } else {
        array_push($fail, "lastname");
    }

    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $visitor_email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    } else {
        array_push($fail, "email");
    }

    if (isset($_POST['message']) && !empty($_POST['message'])) {
        $message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');
    } else {
        array_push($fail, "message");
    }

    $headers = 'From: ' . $visitor_email . "\r\n" . 'Reply-to: ' . $visitor_email . "\r\n" . 'X-Mailer: PHP/' . phpversion();

    if (empty($fail)) {
        mail($recipient, $subject, $message, $headers);
        $results['message'] = sprintf("Thank you for contacting us, %s. We will respond within 24 hours.", $visitor_name);
    } else {
        header("HTTP/1.1 400 Bad Request");
        $errorResponse = ['error' => 'Form validation failed', 'errors' => $fail];
        echo json_encode($errorResponse);
    }
} else {
    header("HTTP/1.1 400 Bad Request");
    $results['message'] = "Please fill out the form correctly.";
    echo json_encode($results);
}
