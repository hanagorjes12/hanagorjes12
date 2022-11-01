<?php
include 'db_connect.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $qry = mysqli_query($conn,"SELECT * FROM quotation where id= $id");
    $res = mysqli_fetch_assoc($qry);
    $mail = $res['email'];
    $buyer_name = $res['buyer_name'];
}
echo $_GET['id'];

require '../HOUSE_RENTAL_MANAGEMENT_SYSTEM/vendor/autoload.php';

$email = new \SendGrid\Mail\Mail();
$email->setFrom("", "HOUSE_RENTAL_MANAGEMENT_SYSTEM");
$email->setSubject("Confirmation Of Quotation");
$email->addTo("$mail", "Example User"); // Set Receiver Email here , any of it
// $email->addContent("text/plain", "Dear $buyer_name");
$email->addContent(
  "text/html",
  "<strong>Hi $buyer_name ,here is your comfirming of quotation email...</strong>"
);
$sendgrid = new \SendGrid('');
try {
  $response = $sendgrid->send($email);
//   print $response->statusCode() . "\n";
//   print_r($response->headers());
//   print $response->body() . "\n";
// echo "<script>alert('Email Sended');</script>";
echo "<script>
alert('Email Sended');
window.location.href='index.php?page=quotation';
</script>";
// header('Location: index.php?page=quotation?msg=Mail Sent');
} catch (Exception $e) {
  echo 'Caught exception: ' . $e->getMessage() . "\n";
}

?>