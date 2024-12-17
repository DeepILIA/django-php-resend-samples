<?php
if (isset($_POST['send_email'])) {
    $url = "https://api.resend.com/emails"; // API address that send the email
    $apiKey = "re_hM1XAmA8_DAQJyo18fqPE3rD2xL3uyWKW"; // Replace with your actual API key : https://resend.com/onboarding

    $data = [
        "from" => "onboarding@resend.dev",
        "to" => "ilia.umons@gmail.com", // address to send to !!! YOU CAN ONLY USE THE EMAIL ADDRESS YOU OPEN THE RESEND ACCOUNT WITH
        // YOU'LL NEED TO ADD VERIFIED DOMAIN AND HOST YOUR APP SOMEWHERE IF YOU WANT TO SEND TO OTHER EMAIL !
        "subject" => "Hello World",
        "html" => "<p>Congrats on sending your <strong>first email</strong>! This is an UMONS tutorial <3 :)</p>" // THIS IS THE CONTENT OF THE MAIL !
    ];

    // Initialize cURL
    $ch = curl_init($url);

    // Set cURL options
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the request
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($response === false) {
        $status = 'cURL Error: ' . curl_error($ch);
    } else {
        if ($httpCode >= 200 && $httpCode < 300) {
            $status = "Email sent successfully! Response: " . $response;
        } else {
            $status = "Failed to send email. HTTP Code: $httpCode. Response: $response";
        }
    }

    curl_close($ch);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Send Email via Resend : AN UMONS TUTORIAL !</title>
</head>
<body>
    <?php if (isset($status)) echo "<p>$status</p>"; ?>
    <form method="post">
        <button type="submit" name="send_email">Send Email</button>
    </form>
</body>
</html>
