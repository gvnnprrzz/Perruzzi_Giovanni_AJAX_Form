<?php
// Required Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: applicant/json; charset=UTF-8");


if($_POST) {
    $recipient = "perruzzi12@gmail.com";
    $subject = "Email from my portfolio site";
    $visitor_name = "";
    $visitor_email = "";
    $message = "";
    $fail = array();

    //Cleans and stores first name in the $visitor_name variable
    if(isset($_POST['firstname'])&& !empty($_POST['firstname'])){
        $visitor_name = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
    }else{
        array_push($fail, "firstname");
    }

    //Cleans and appends last name in the $visitor_name variable
    if(isset($POST['lastname'])&& !empty($POST['lastname'])){
            $visitor_name .= " ".filter_var($POST['lastname'], FILTER_SANITIZE_STRING);
    }else{
        array_push($fail,"lastname");
    }

    //Cleans and stores email in the $visitor_name variable
    if(isset($POST['email']) && !empty($POST['email'])){
        $email = str_replace(array("\r", "\n", "%0a", "%0d"), "", $POST['email']);
        $visitor_email = filter_var($email, FILTER_VALIDATE_EMAIL);
    }else{
        array_push($fail, "email");
    }

    //Cleanse message and stores in $message variable
    if(isset($POST['message']) && !empty($POST['message'])){
        $clean = filter_var($POST['message'],   FILTER_SANITIZE_STRING);
        $message = htmlspecialchars($clean);
    }else{
        array_push($fail, "message");
    }

    $headers = "From:".$visitor_name."\r\n"."Reply-to:".$visitor_email."\r\n"."X-Mailer: PHP/".phpversion();
    if(count($fail)==0){
        mail($recipient, $subject, $message, $headers);
        $results['messages'] = sprintf("Thank you for contacting me, %s. I will respond ASAP. ", $visitor_name);
    }else{
        header("HTTP/1.1 488 Please fill out the form properly");
        die(json_encode(['message' => $fail]));
    }
}else{
    $results['message'] = "Please fill out all form elements. Thank you.";
}

echo json_encode($results);


?>