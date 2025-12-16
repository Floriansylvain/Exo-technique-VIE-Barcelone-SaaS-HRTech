<?php
header('X-Robots-Tag: noindex');
header('Content-Type: text/html; charset=utf-8');

$client = null;
if (!empty($_GET['client'])) $client = $_GET['client'];
elseif (!empty($_COOKIE['client'])) $client = $_COOKIE['client'];

if (empty($client)) {
    http_response_code(400);
    echo 'Client not selected';
    exit;
}

if (!preg_match('/^[a-z0-9_-]+$/i', $client)) {
    http_response_code(400);
    echo 'Invalid client identifier';
    exit;
}

$module = isset($_GET['module']) ? $_GET['module'] : '';
$script = isset($_GET['script']) ? $_GET['script'] : '';

if (!preg_match('/^[a-z0-9_-]+$/i', $module) || !preg_match('/^[a-z0-9_-]+$/i', $script)) {
    http_response_code(400);
    echo 'Invalid module or script name';
    exit;
}

$baseDir = dirname(__DIR__) . '/customs/' . $client . '/modules/';
$targetPath = $baseDir . $module . '/' . $script . '.php';

$realBase = realpath(dirname(__DIR__) . '/customs/' . $client . '/modules/');
$realTarget = realpath($targetPath);

if ($realBase === false || $realTarget === false) {
    http_response_code(404);
    echo 'Not found';
    exit;
}

if (strpos($realTarget, $realBase) !== 0) {
    http_response_code(400);
    echo 'Invalid path';
    exit;
}

include $realTarget;
