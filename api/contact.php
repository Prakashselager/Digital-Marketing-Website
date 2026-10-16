<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/php_errors.log');

header('Content-Type: application/json');
ob_start();

try {
    include('../includes/config.php');

    if (!defined('DB_HOST') || !defined('DB_USER') || !defined('DB_PASS') || !defined('DB_NAME')) {
        throw new Exception('Database configuration missing in config.php');
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method. Use POST.');
    }

    $name    = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email   = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone   = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        throw new Exception('Please fill all required fields.');
    }

    // ===== SAVE TO DATABASE =====
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        throw new Exception('DB connection failed: ' . $conn->connect_error);
    }

    $service_name = 'Contact Form: ' . $subject;
    $full_message = "Subject: $subject\n\n$message";

    $stmt = $conn->prepare("INSERT INTO enquiries (service_name, name, email, phone, message) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        throw new Exception('SQL prepare failed: ' . $conn->error);
    }
    $stmt->bind_param("sssss", $service_name, $name, $email, $phone, $full_message);
    if (!$stmt->execute()) {
        throw new Exception('Save failed: ' . $stmt->error);
    }
    $stmt->close();
    $conn->close();

    // ===== SEND EMAIL VIA BREVO API =====
    $mail_sent = false;
    $mail_error = '';

    if (!defined('BREVO_API_KEY') || empty(BREVO_API_KEY)) {
        $mail_error = 'BREVO_API_KEY not set in config.php';
    } else {
        $adminSubject = "New Contact Message: $subject";
        $adminBody = "You have received a new contact message.\n\n";
        $adminBody .= "Name: $name\n";
        $adminBody .= "Email: $email\n";
        $adminBody .= "Phone: " . ($phone ?: 'Not provided') . "\n";
        $adminBody .= "Subject: $subject\n\n";
        $adminBody .= "Message:\n$message\n";

        $url = 'https://api.brevo.com/v3/smtp/email';
        $data = [
            'sender' => [
                'name'  => 'BrandEve Solutions',
                'email' => 'your@gmail.com'
            ],
            'to' => [
                [
                    'email' => ADMIN_EMAIL,
                    'name'  => 'Admin'
                ]
            ],
            'subject' => $adminSubject,
            'textContent' => $adminBody,
            'htmlContent' => "<html><body><pre>" . htmlspecialchars($adminBody) . "</pre></body></html>"
        ];

        $payload = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'api-key: ' . BREVO_API_KEY
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            $mail_error = 'cURL error: ' . $curlError;
        } elseif ($httpCode === 201) {
            $mail_sent = true;
        } else {
            $mail_error = 'API error (HTTP ' . $httpCode . '): ' . $result;
        }
    }

    $response = [
        'success' => true,
        'message' => 'Message sent successfully!',
        'mail_sent' => $mail_sent,
        'mail_error' => $mail_error
    ];

} catch (Exception $e) {
    $response = ['success' => false, 'error' => $e->getMessage()];
}

ob_end_clean();
echo json_encode($response);
exit;