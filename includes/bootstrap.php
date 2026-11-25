<?php
session_start();
$configFile = __DIR__ . '/../config.php';
if (!file_exists($configFile)) { http_response_code(503); exit('Website setup is not complete. Please configure config.php.'); }
$config = require $configFile;
try {
  $pdo = new PDO('mysql:host='.$config['db_host'].';dbname='.$config['db_name'].';charset=utf8mb4', $config['db_user'], $config['db_pass'], [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]);
} catch (Throwable $e) { http_response_code(503); exit('Database connection failed. Please check the hosting database settings.'); }
function e($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function csrf_token() { if (empty($_SESSION['csrf'])) $_SESSION['csrf']=bin2hex(random_bytes(32)); return $_SESSION['csrf']; }
function csrf_check() { if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) { http_response_code(403); exit('Invalid request token. Please go back and try again.'); } }
function require_admin() { if (empty($_SESSION['admin_id'])) { header('Location: login.php'); exit; } }
function logged_in() { return !empty($_SESSION['admin_id']); }
