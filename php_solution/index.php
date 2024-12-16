<?php
if (isset($_POST['send_email'])) {
    $url = "https://api.resend.com/emails";
    $apiKey = "re_MZEi4p2X_PNTY7d3fqJXhCU5vHuqUi38S"; // Replace with your actual API key

    $data = [
        "from" => "onboarding@resend.dev",
        "to" => "hammicristo@gmail.com",
        "subject" => "Hello World",
        "html" => "<p>Congrats on sending your <strong>first email</strong>!</p>"
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
    <title>Send Email via Resend</title>
</head>
<body>
    <?php if (isset($status)) echo "<p>$status</p>"; ?>
    <form method="post">
        <button type="submit" name="send_email">Send Email</button>
    </form>
</body>
</html>
