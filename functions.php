<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
function redirect($url) {
    header("Location: $url");
    exit;
}
function sanitize($str) {
    return htmlspecialchars(trim($str), ENT_QUOTES, 'UTF-8');
}
function read_users() {
    if (!file_exists('users.json')) return [];
    return json_decode(file_get_contents('users.json'), true) ?? [];
}
function save_users($users) {
    file_put_contents('users.json', json_encode($users, JSON_PRETTY_PRINT));
}
function read_people() {
    if (!file_exists('people.json')) return [];
    return json_decode(file_get_contents('people.json'), true) ?? [];
}
function save_people($people) {
    file_put_contents('people.json', json_encode($people, JSON_PRETTY_PRINT));
}
function require_login() {
    if (!isset($_SESSION['username'])) {
        redirect('login.php');
    }
}
