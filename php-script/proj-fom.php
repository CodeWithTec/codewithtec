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

$platforms = $_POST['platforms'] ?? [];
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

     $mail->Body = '
<div style="font-family: Arial, Helvetica, sans-serif; background-color:#f4f6f8; padding:30px;">
    <div style="max-width:650px; margin:0 auto; background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.05);">
        
        <!-- Header -->
        <div style="background:#1f2937; color:#ffffff; padding:20px 30px;">
            <h2 style="margin:0; font-size:22px;">🚀 New Project Request</h2>
        </div>

        <!-- Content -->
        <div style="padding:30px; color:#333333; font-size:14px; line-height:1.6;">
            
            <h3 style="margin-top:0; color:#111827; border-bottom:1px solid #e5e7eb; padding-bottom:8px;">
                Contact Information
            </h3>

            <p><strong>Name:</strong> ' . $full_name . '</p>
            <p><strong>Email:</strong> <a href="mailto:' . $email . '" style="color:#2563eb; text-decoration:none;">' . $email . '</a></p>
            <p><strong>Phone:</strong> ' . $phone . '</p>
            <p><strong>Company:</strong> ' . $company . '</p>

            <h3 style="margin-top:30px; color:#111827; border-bottom:1px solid #e5e7eb; padding-bottom:8px;">
                Project Details
            </h3>

            <p><strong>Project Title:</strong> ' . $project . '</p>
            <p><strong>Description:</strong><br>' . nl2br($description) . '</p>
            <p><strong>Platform:</strong> ' . $platform_list . '</p>
            <p><strong>Budget:</strong> ' . $budget . '</p>
            <p><strong>Timeline:</strong> ' . $timeline . '</p>

            <h3 style="margin-top:30px; color:#111827; border-bottom:1px solid #e5e7eb; padding-bottom:8px;">
                Additional Notes
            </h3>

            <p>' . nl2br($notes) . '</p>

        </div>

        <!-- Footer -->
        <div style="background:#f9fafb; padding:15px 30px; font-size:12px; color:#6b7280; text-align:center;">
            This email was generated from your website project request form.
        </div>

    </div>
</div>
';


        $mail->send();

        // Redirect or success message
        header("Location: ../success.html");
        exit;

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

