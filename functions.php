<?php
session_start();
define('USERS_FILE', __DIR__ . '/users.json');
/**
 * @return array
 */
function read_users() {
    $path = USERS_FILE;
    if (!file_exists($path)) {
        return [];
    }
    $fp = fopen($path, 'r');
    if (!$fp) return [];
    if (flock($fp, LOCK_SH)) {
        $contents = '';
        while (!feof($fp)) {
            $contents .= fread($fp, 8192);
        }
        flock($fp, LOCK_UN);
    } else {
        $contents = file_get_contents($path);
    }
    fclose($fp);
    $data = json_decode($contents, true);
    return is_array($data) ? $data : [];
}
/**
 * @param array $users
 * @return bool
 */
function save_users(array $users) {
    $path = USERS_FILE;
    $json = json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    $fp = fopen($path, 'c+');
    if (!$fp) return false;
    if (!flock($fp, LOCK_EX)) {
        fclose($fp);
        return false;
    }
    ftruncate($fp, 0);
    rewind($fp);
    $written = fwrite($fp, $json);
    fflush($fp);
    flock($fp, LOCK_UN);
    fclose($fp);
    return $written !== false;
}
function sanitize_username($u) {
    $u = trim($u);
    return preg_replace('/[^A-Za-z0-9_.-]/', '', $u);
}
function valid_password($pw) {
    return strlen($pw) >= 6;
}
function is_logged_in() {
    return isset($_SESSION['username']);
}
function redirect($url) {
    header("Location: $url");
    exit;
}