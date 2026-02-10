<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// require 'vendor/autoload.php'; // If using Composer
// OR if using manual PHPMailer download:
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Sanitize inputs
    function clean($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }

    $full_name   = clean($_POST['full_name'] ?? '');
    $email       = clean($_POST['email'] ?? '');
    $phone       = clean($_POST['phone'] ?? '');
    $company     = clean($_POST['company'] ?? '');
    $project     = clean($_POST['project_name'] ?? '');
    $description= clean($_POST['project_description'] ?? '');
    $budget      = clean($_POST['budget'] ?? '');
    $timeline    = clean($_POST['timeline'] ?? '');
    $notes       = clean($_POST['additioninfo'] ?? '');

    // Platform checkboxes (handle safely even if none selected)
    $platforms = [];
    foreach (['web_app','mobile_app','desktop_app','Static Website','Dynamic_website'] as $p) {
        if (!empty($_POST[$p])) {
            $platforms[] = $p;
        }
    }

    $platform_list = empty($platforms) ? 'N/A' : implode(', ', $platforms);

    $mail = new PHPMailer(true);

     try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'codewithtec@gmail.com'; // Your Gmail
        $mail->Password   = 'gdzu grmn bsqd wyis';   // Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;


        // Sender and recipient
        $mail->setFrom('info@codewithtec.com', 'Website Contact Form');
        $mail->addAddress('codewithtec@gmail.com'); // Recipient email


        // ATTACHMENT
        if (!empty($_FILES['attachment']['name'])) {
            $mail->addAttachment(
                $_FILES['attachment']['tmp_name'],
                $_FILES['attachment']['name']
            );
        }

        // EMAIL CONTENT
        $mail->isHTML(true);
        $mail->Subject = "New Project Submission – {$project}";

        $mail->Body = "
        <h2>New Project Request</h2>
        <p><strong>Name:</strong> {$full_name}</p>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>Phone:</strong> {$phone}</p>
        <p><strong>Company:</strong> {$company}</p>

        <hr>

        <p><strong>Project Title:</strong> {$project}</p>
        <p><strong>Description:</strong><br>{$description}</p>
        <p><strong>Platform:</strong> {$platform_list}</p>
        <p><strong>Budget:</strong> {$budget}</p>
        <p><strong>Timeline:</strong> {$timeline}</p>

        <hr>

        <p><strong>Additional Notes:</strong><br>{$notes}</p>
        ";

        $mail->send();

        // Redirect or success message
        header("Location: ../thank-you.html");
        exit;

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
