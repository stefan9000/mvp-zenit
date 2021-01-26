<?php
require_once 'vendor/autoload.php';

if ($_POST['contact']) {
    session_start();

    $contact_count = checkContactCount();

    if ($contact_count < 3) {
        $required = [
            'name',
            'email',
            'message',
        ];

        foreach ($required as $r) {
            if (!isset($_POST[$r]) || empty($_POST[$r])) {
                $required_error = true;
            } else {
                $data[$r] = $_POST[$r];
            }
        }

        $transport = (new Swift_SmtpTransport('46.4.120.252', 587))
            ->setUsername('no-reply@mvpzenit.com')
            ->setPassword('pWAc;l?-dAu&');

        $mailer = new Swift_Mailer($transport);

        $message = (new Swift_Message('Contact message'))
            ->setFrom(['no-reply@mvpzenit.com' => 'MVP Zenit'])
            ->setTo(['office@mvpzenit.com'])
            ->addPart('
            <!DOCTYPE html>
            <html>
            <body>
                <h3>Contact message</h3>
                <ul>
                    <li>Name: '. $data['name'] .'</li>
                    <li>Email: '. $data['email'] .'</li>
                    <li>Message:<br />'. $data['message'] .'</li>
                </ul>
            </body>
            </html>
        ', 'text/html');

        $result = $mailer->send($message);
    }

    echo json_encode([
        'count' => $_SESSION['contact_count'],
        'exp' => $_SESSION['contact_expiration'],
        'date' => date('Y-m-d H:i:s'),
    ]);
}

function checkContactCount()
{
    if ($_SESSION['contact_count'] <= 3) {
        $_SESSION['contact_count'] += 1;
    }

    if (date('Y-m-d') >= $_SESSION['contact_expiration'] || !$_SESSION['contact_expiration']) {
        if ($_SESSION['contact_count'] >= 3) {
            $_SESSION['contact_count'] = 0;
        }

        $_SESSION['contact_expiration'] = date('Y-m-d H:i:s', time() + (3600));
    }

    return $_SESSION['contact_count'];
}