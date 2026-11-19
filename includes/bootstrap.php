<?php
declare(strict_types=1);

/* ------------------------------------------------------------------
 * Nario Labs — bootstrap: config, DB, settings, content helpers.
 * Every page and admin screen requires this file first.
 * ------------------------------------------------------------------ */

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
        'secure'   => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    ]);
    session_start();
}

define('ROOT', dirname(__DIR__));
$GLOBALS['CONFIG'] = file_exists(ROOT . '/config.php')
    ? require ROOT . '/config.php'
    : require ROOT . '/config.sample.php';

const ITEM_TYPES = [
    'partner' => ['label' => 'Partners',  'single' => 'Partner'],
    'client'  => ['label' => 'Clients',   'single' => 'Client'],
    'product' => ['label' => 'Products',  'single' => 'Product'],
    'game'    => ['label' => 'Games',     'single' => 'Game'],
];

const DEFAULT_SETTINGS = [
    'site_name'        => 'Nario Labs',
    'tagline'          => 'The origin point of software.',
    'meta_description' => 'Nario Labs is the mother factory of software: we build engines that partners brand and sell, run an R&D lab, ship SaaS, build custom systems and make African games.',
    'email'            => 'timcatech@gmail.com',
    'phone'            => '+254711235022',
    'phone_display'    => '+254 711 235 022',
    'whatsapp'         => '254711235022',
    'whatsapp_message' => 'Hi Nario Labs, I would like to talk about a project.',
    'location'         => 'Nairobi, Kenya',
    'handle'           => '@nario_labs',
    'instagram'        => 'https://instagram.com/nario_labs',
    'x'                => 'https://x.com/nario_labs',
    'tiktok'           => 'https://www.tiktok.com/@nario_labs',
    'linkedin'         => 'https://www.linkedin.com/company/nario-labs',
    'youtube'          => 'https://www.youtube.com/@nario_labs',
    'facebook'         => 'https://www.facebook.com/nario_labs',
    'github'           => 'https://github.com/nario-labs',
    'founded'          => '2026',
];

function config(string $key, $default = null)
{
    return $GLOBALS['CONFIG'][$key] ?? $default;
}

/** PDO connection, or null when the database is not reachable (the site then runs on demo content). */
function db(): ?PDO
{
    static $pdo = false;
    if ($pdo !== false) {
        return $pdo;
    }
    $c = config('db');
    try {
        $pdo = new PDO(
            "mysql:host={$c['host']};port={$c['port']};dbname={$c['name']};charset={$c['charset']}",
            $c['user'],
            $c['pass'],
            [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]
        );
    } catch (Throwable $e) {
        $pdo = null;
    }
    return $pdo;
}

/** Asset URL with a cache-busting version so browsers pick up edits immediately. */
function asset(string $path, string $prefix = ''): string
{
    $file = ROOT . '/assets/' . $path;
    return $prefix . 'assets/' . $path . (is_file($file) ? '?v=' . filemtime($file) : '');
}

function e($v): string
{
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}

function settings(): array
{
    static $s = null;
    if ($s !== null) {
        return $s;
    }
    $s = DEFAULT_SETTINGS;
    if ($pdo = db()) {
        try {
            foreach ($pdo->query('SELECT skey, svalue FROM settings') as $row) {
                $s[$row['skey']] = $row['svalue'];
            }
        } catch (Throwable $e) {
        }
    }
    return $s;
}

function S(string $key): string
{
    return (string)(settings()[$key] ?? '');
}

function wa_link(?string $msg = null): string
{
    return 'https://wa.me/' . preg_replace('/\D/', '', S('whatsapp')) . '?text=' . rawurlencode($msg ?? S('whatsapp_message'));
}

function safe_url(?string $url): string
{
    $url = trim((string)$url);
    return preg_match('~^https?://~i', $url) ? $url : '';
}

function safe_color(?string $c): string
{
    return preg_match('/^#[0-9a-f]{6}$/i', (string)$c) ? $c : '';
}

function demo_data(): array
{
    static $d = null;
    return $d ??= (json_decode((string)file_get_contents(ROOT . '/data/demo.json'), true) ?: []);
}

/** Active items of a type for the public site. Falls back to demo content when there is no database. */
function items(string $type): array
{
    if ($pdo = db()) {
        try {
            $st = $pdo->prepare('SELECT * FROM items WHERE type = ? AND is_active = 1 ORDER BY sort_order, id');
            $st->execute([$type]);
            return $st->fetchAll();
        } catch (Throwable $e) {
        }
    }
    return demo_data()[$type] ?? [];
}

/** Public, sanitised shape of an item for the front-end JS. */
function public_item(array $r): array
{
    return [
        'name'        => (string)$r['name'],
        'url'         => safe_url($r['url'] ?? ''),
        'logo'        => (string)($r['logo'] ?? ''),
        'preview'     => (string)($r['preview'] ?? ''),
        'tagline'     => (string)($r['tagline'] ?? ''),
        'description' => (string)($r['description'] ?? ''),
        'status'      => (string)($r['status'] ?? ''),
        'category'    => (string)($r['category'] ?? ''),
        'size'        => in_array($r['size'] ?? '', ['sm', 'wide', 'tall', 'lg'], true) ? $r['size'] : 'sm',
        'accent'      => safe_color($r['accent'] ?? ''),
        'embed'       => (int)($r['embed'] ?? 1) === 1,
    ];
}

/** Everything the front-end needs, printed as window.NARIO in the footer. */
function site_data(): array
{
    $out = [];
    foreach (array_keys(ITEM_TYPES) as $t) {
        $out[$t] = array_map('public_item', items($t));
    }
    $out['csrf'] = csrf_token();
    return $out;
}

/* ---------- CSRF ---------- */
function csrf_token(): string
{
    return $_SESSION['csrf'] ??= bin2hex(random_bytes(32));
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . csrf_token() . '">';
}

function csrf_ok(): bool
{
    return hash_equals($_SESSION['csrf'] ?? '', (string)($_POST['csrf'] ?? ''));
}

/* ---------- Navigation ---------- */
const NAV = [
    'index'    => 'Home',
    'about'    => 'Origin',
    'services' => 'What we do',
    'products' => 'Products',
    'partners' => 'Partners',
    'games'    => 'Games',
    'contact'  => 'Contact',
];

function nav_active(string $slug): string
{
    return (($GLOBALS['page']['slug'] ?? '') === $slug) ? ' is-active' : '';
}
