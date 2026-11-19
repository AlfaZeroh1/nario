<?php
declare(strict_types=1);
require dirname(__DIR__) . '/includes/bootstrap.php';

header('Content-Type: application/json; charset=utf-8');

function out(int $code, array $body): never
{
    http_response_code($code);
    echo json_encode($body);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') out(405, ['ok' => false, 'error' => 'Method not allowed']);
if (!csrf_ok()) out(419, ['ok' => false, 'error' => 'Your session expired. Refresh the page and try again.']);
if (!empty($_POST['website'])) out(200, ['ok' => true]); // honeypot: bots fill it, people never see it

$last = $_SESSION['last_contact'] ?? 0;
if (time() - $last < 30) out(429, ['ok' => false, 'error' => 'Easy there, give it 30 seconds before sending another message.']);

$f = fn(string $k, int $max) => mb_substr(trim((string)($_POST[$k] ?? '')), 0, $max);
$data = [
    'name'     => $f('name', 120),
    'email'    => $f('email', 160),
    'phone'    => $f('phone', 40),
    'company'  => $f('company', 160),
    'interest' => $f('interest', 60),
    'budget'   => $f('budget', 60),
    'message'  => $f('message', 5000),
];

$errors = [];
if ($data['name'] === '') $errors['name'] = 'Tell us your name.';
if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors['email'] = 'That email does not look right.';
if (mb_strlen($data['message']) < 10) $errors['message'] = 'A few more words, please (10+ characters).';
if ($errors) out(422, ['ok' => false, 'error' => 'Please fix the highlighted fields.', 'fields' => $errors]);

$pdo = db();
if (!$pdo) out(503, ['ok' => false, 'error' => 'Our inbox is offline. Email or WhatsApp us directly instead.']);

$st = $pdo->prepare('INSERT INTO messages (name, email, phone, company, interest, budget, message, ip) VALUES (?,?,?,?,?,?,?,?)');
$st->execute([...array_values($data), substr((string)($_SERVER['REMOTE_ADDR'] ?? ''), 0, 45)]);
$_SESSION['last_contact'] = time();

if (config('send_mail') && S('email')) {
    $body = '';
    foreach ($data as $k => $val) $body .= ucfirst($k) . ': ' . $val . "\n";
    $safeName = preg_replace('/[\r\n]+/', ' ', $data['name']);
    @mail(S('email'), 'New enquiry from ' . $safeName . ' — Nario Labs', $body, 'Reply-To: ' . $data['email']);
}

out(200, ['ok' => true, 'message' => 'Message received. We will get back to you within one working day.']);
