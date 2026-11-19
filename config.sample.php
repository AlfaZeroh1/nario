<?php
/**
 * Nario Labs — configuration.
 * Copy this file to config.php (the installer does it for you) and fill in your details.
 */
return [
    'db' => [
        'host'    => '127.0.0.1',
        'port'    => 3306,
        'name'    => 'nario_labs',
        'user'    => 'root',
        'pass'    => '',
        'charset' => 'utf8mb4',
    ],
    // Send an email to the site email for every contact-form message (needs a working PHP mail()).
    'send_mail' => false,
    // Max upload size for logos / covers in MB.
    'max_upload_mb' => 4,
];
