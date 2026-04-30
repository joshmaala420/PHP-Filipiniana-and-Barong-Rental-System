<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Set the recipient email address (where the contact form data will be sent)
    $to = "patolotrental@gmail.com";  // Replace with your email address
    $subject = "New Message from Contact Us Form";
    $body = "You have received a new message from $name ($email):\n\n$message";
    $headers = "From: $email";

    // Send the email
    if (mail($to, $subject, $body, $headers)) {
        echo "<script>
                alert('Thank you for contacting us. We will get back to you soon.');
                window.location.href = 'thank_you.php';
              </script>";
    } else {
        echo "<script>
                alert('There was an error sending your message. Please try again later.');
                window.location.href = 'contact_us.php';
              </script>";
    }
} else {
    // If the form wasn't submitted properly, redirect to the contact form page
    header("Location: contact_us.php");
    exit();
}
?>
