
    <?php
    require 'vendor/autoload.php';

    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("theloon789123@gmail.com", "Example User");
    $email->setSubject("Sending with Twilio SendGrid is Fun");
    $email->addTo("your mail@gmail.com", "Example User"); // Set Receiver Email here , any of it
    $email->addContent("text/plain", "and easy to do anywhere, even with PHP");
    $email->addContent(
      "text/html",
      "<strong>Any Text Or Date Here</strong>"
    );
    $sendgrid = new \SendGrid('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');
    try {
      $response = $sendgrid->send($email);
      print $response->statusCode() . "\n";
      print_r($response->headers());
      print $response->body() . "\n";
    } catch (Exception $e) {
      echo 'Caught exception: ' . $e->getMessage() . "\n";
    }

    ?>