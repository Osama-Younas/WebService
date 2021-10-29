<?php
$key="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";

require "vendor/autoload.php"; 

$email= new \SendGrid\Mail\Mail();
$email->setFrom("m.usamayounas669@gmail.com", "webservice");
$email->setSubject("Sending with SendGrid is Fun");
$email->addTo("buttw1510@gmail.com", "Example User");
$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
$email->addContent(
    "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
);
$sendgrid = new \SendGrid($key);
try {
    $response = $sendgrid->send($email);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: '. $e->getMessage() ."\n";
}
?>