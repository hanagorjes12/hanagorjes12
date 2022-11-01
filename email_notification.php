<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include('db_connect.php');

require 'vendor/autoload.php';
if (isset($_POST['send_notification'])) {
    extract($_POST);

    $landlord_id = $_SESSION['login_id'];
    $notidate = date("Y-m-d");

    $insert = mysqli_query($conn, "INSERT INTO notification SET landlord_id = '$landlord_id', tenant_id = '$tenant_id', subject='$subject', message='$body', noti_date='$notidate'");

    echo "<script>
                    alert('Successfully sent notification');
                </script>";



    // $mail = new PHPMailer(true);

    // try {
    //     $mail->isSMTP();                                            //Send using SMTP
    //     $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    //     $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    //     $mail->Username   = $gmail;                     //SMTP username
    //     $mail->Password   = $password;                               //SMTP password
    //     $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    //     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    //     //Whether to use SMTP authentication
    //     $mail->SMTPAuth = true;
    //     //Recipients
    //     $mail->setFrom($gmail, $sender_name);
    //     $mail->addAddress($recipient_email, $recipient_name);     //Add a recipient
    //     $mail->addCC($gmail);

    //     //Content
    //     $mail->isHTML(true);                                  //Set email format to HTML
    //     $mail->Subject = $subject;
    //     $mail->Body    = $body;

    //     $mail->send();
    //     echo "<script>alert('Message has been sent');</script>";
    // } catch (Exception $e) {
    //     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    // }
}
?>

<div class="container-fluid">

    <div class="col-lg-12">
        <div class="row mb-4 mt-4">
            <div class="col-md-12">

            </div>
        </div>
        <div class="row">
            <!-- FORM Panel -->

            <!-- Table Panel -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <b>Send Email Notification</b>
                    </div>
                    <form method="post" action="">
                        <div class="card-body">
                            <!-- <label>Sender Name</label>
                            <input name="sender_name" type="text" class="form-control" />
                            <br />
                            <label>Sender Email (Gmail Only)</label>
                            <input type="email" name="gmail" class="form-control" />
                            <br />
                            <label>Sender Password (Real Account Password)</label>
                            <input type="email" name="password" class="form-control" />
                            <br /> -->
                            <label>Recipient Name</label>
                            <select name="tenant_id" class="form-control" required="">
                                <option value="">-select-</option>
                            <?php 
                            $select_tenant = mysqli_query($conn, "SELECT * FROM tenantss WHERE landlord_id = ".$_SESSION['login_id']);
                            while($res = mysqli_fetch_assoc($select_tenant)){
                            ?>
                                <option value="<?php echo $res["tenant_id"]; ?>"><?php echo $res["firstname"]; ?></option>
                            <?php } ?>
                            </select>
                            <br />
                            <!-- <label>Recipient Email</label>
                            <input type="email" name="recipient_email" class="form-control" />
                            <br /> -->
                            <label>Subject</label>
                            <input type="text" name="subject" class="form-control" />
                            <br />
                            <label>Message</label>
                            <!DOCTYPE html>
                            <textarea name="body"></textarea>
                            <br />
                            <center>
                                <button type="submit" name="send_notification" class="btn btn-sm btn-success">Send</button>
                            </center>
                            <br />
                            </body>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Table Panel -->
        </div>
    </div>

</div>


<style>
    td {
        vertical-align: middle !important;
    }

    td p {
        margin: unset;
        padding: unset;
        line-height: 1em;
    }
</style>
<script>
    tinymce.init({
        selector: 'textarea',
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'floating',
    });
</script>