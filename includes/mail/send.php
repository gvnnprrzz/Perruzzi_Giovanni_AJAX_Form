<?php
// Required Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: applicant/json; charset=UTF-8");


if($_POST) {
    $receipent = "This is where your email goes...";
    $subject = "Email from my portfolio site";
    $visitor_name = "";
    $visitor_email = "";
    $message = "";
    $fail = array();

    //Cleans and stores first name in the $visitor_name variable
    if(isset($_POST['firstname'])&& !empty($_POST['firstname'])){
        $visitor_name = filter_var($_POST['fistname'], FILTER_SANITIZE_STRING);
    }else{
        array_push($fail, "firstname");
    }

    //Cleans and apends last name in the $visitor_name variable
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
    
    //Cleanse message and stores in $message varible
    if(isset($POST['message']) && !empty($POST['message'])){
        $clean = filter_var($POST['message'],   FILTER_SANITIZE_STRING);
        $message = htmlspecialchars($clean);
    }else{
        array_push($fail, "message");
    }

    $headers = "From: i_am_awesom@awesome.com"."\r\n"."Reply-to: again@again.com"."\r\n"."X-Mailer: PHP/".phpversion();
    if(count($fail)==0){
        mail($receipent, $subject, $message, $headers);
        $results['messages'] = sprintf("Thank you for contacting us, %s. We will respong within 24 hours. ", $visitor_name);
    }else{
        header("HTTP/1.1 488 You did NOT fill out the form correctly");
        die(json_encode(['message' => $fail]));
    }
}else{
    $results['message'] = "Stop being so lazy and fill out the damn form.";
}

echo json_encode($results);


?>