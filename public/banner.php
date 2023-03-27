<?php

const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = 'password';
const DB_NAME = 'tracking';

try {
    $conn = new PDO(sprintf("mysql:host=%s;dbname=%s", DB_HOST, DB_NAME), DB_USER, DB_PASS);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$ip_address = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$page_url = $_SERVER['HTTP_REFERER'];

$view_date = date("Y-m-d H:i:s");

$stmt = $conn->prepare("SELECT * FROM visitors WHERE ip_address = :ip_address AND user_agent = :user_agent AND page_url = :page_url");
$stmt->execute(['ip_address' => $ip_address, 'user_agent' => $user_agent, 'page_url' => $page_url]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    $stmt = $conn->prepare("UPDATE visitors SET view_date = :view_date, views_count = views_count + 1 WHERE id = :id");
    $stmt->execute(['view_date' => $view_date, 'id' => $result['id']]);
} else {
    $stmt = $conn->prepare("INSERT INTO visitors (ip_address, user_agent, page_url, view_date, views_count) VALUES (:ip_address, :user_agent, :page_url, :view_date, 1)");
    $stmt->execute(['ip_address' => $ip_address, 'user_agent' => $user_agent, 'page_url' => $page_url, 'view_date' => $view_date]);
}


header('Content-Type: image/jpeg');
readfile('image.jpeg');