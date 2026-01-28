<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// require 'vendor/autoload.php'; // If using Composer
// OR if using manual PHPMailer download:
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

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
        $mail->setFrom('yourgmail@gmail.com', 'Website Contact Form');
        $mail->addAddress('codewithtec@gmail.com'); // Recipient email

        // Attach all uploaded files
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0) {
    $mail->addAttachment($_FILES['attachment']['tmp_name'], $_FILES['attachment']['name']);
} else {
    echo "⚠️ File not uploaded. Error code: " . $_FILES['attachment']['error'];
}

        // options
       $service = $_POST['service'] ?? 'Not Selected';

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "New Prise Form Submission";
        $mail->Body    = "

             <div style='font-family: Arial, sans-serif; color: #333;'>
        <h2 style='background: #b60505ff; color: #fff; padding: 10px;'>
            📩 New Prise Form Submission
        </h2>
        <table border='1' cellpadding='8' cellspacing='0' width='100%' style='border-collapse: collapse;'>
            <tr>
                <td style='background:#f9f9f9; font-weight:bold;'>First Name</td>
                <td>$name</td>
            </tr>
            <tr>
                <td style='background:#f9f9f9; font-weight:bold;'>Last Name</td>
                <td>$email</td>
            </tr>
            <tr>
                <td style='background:#f9f9f9; font-weight:bold;'>Service</td>
                <td>$service</td>
            </tr>
            <tr>
                <td style='background:#f9f9f9; font-weight:bold;'>Message</td>
                <td>$message</td>
            </tr>
        </table>
        <p style='margin-top:20px; font-size:12px; color:#777;'>
            This message was sent from your website contact form.
        </p>
    </div>
";


        //     <h3>New Message from <br>$name</h3>
        //     <h3>Subject: $subject</h3>
        //     <p><strong>Email:</strong> $email</p>
        //     <p><strong>Message:</strong><br>$message</p>
        // ";

        // Send email
        $mail->send();

        // echo "thanks for the mail";
        // Reirect after success 
        header("Location: ../success.html");
    } catch (Exception $e) {
        echo "Message could not be sent. Error: {$mail->ErrorInfo}";
    }
}


//vnix akge jyfv yscu  This is a key password to keep




?>



<?php

// if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0) {
//     $filePath = $_FILES['attachment']['tmp_name'];
//     $fileName = $_FILES['attachment']['name'];
//     $fileData = chunk_split(base64_encode(file_get_contents($filePath)));

//     $mail->Body = "
//         <h2>New Contact Message</h2>
//         <p><strong>Name:</strong> $name</p>
//         <p><strong>Email:</strong> $email</p>
//         <p><strong>Service Selected:</strong> $service</p>
//         <p><strong>Message:</strong><br>$message</p>
//         <p><strong>Uploaded File:</strong> $fileName <br>
//         (file is attached to this email)</p>
//     ";
//     // Still attach so recipient can download
//     $mail->addAttachment($filePath, $fileName);
// }

?>

