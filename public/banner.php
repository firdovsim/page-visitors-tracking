<?php

use App\Services\Database;
use App\Services\ImageRenderer;
use App\Services\VisitorTracker;

require dirname(__DIR__) . '/vendor/autoload.php';

$ip_address = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$page_url = $_SERVER['HTTP_REFERER'];

$db = new Database();
$tracker = new VisitorTracker($db->getConnection());

$visitor = $tracker->getVisitorBy([
    'ip_address' => $ip_address,
    'user_agent' => $user_agent,
    'page_url' => $page_url
]);

if ($visitor) {
    $tracker->updateVisitorById($visitor['id'], [
        'view_date' => date('Y-m-d H:i:s')
    ]);
} else {
    $tracker->createVisitor([
        'ip_address' => $ip_address,
        'user_agent' => $user_agent,
        'page_url' => $page_url,
        'view_date' => date('Y-m-d H:i:s')
    ]);
}

$renderer = new ImageRenderer();
$renderer->renderImage();