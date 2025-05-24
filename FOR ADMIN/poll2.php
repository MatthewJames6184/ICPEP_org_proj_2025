<?php
header('Content-Type: application/json');

$file = 'votes.json';

if (!file_exists($file)) {
  file_put_contents($file, json_encode(["option1" => 0, "option2" => 0]));
}

$votes = json_decode(file_get_contents($file), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $option = $_POST['option'] ?? '';
  if (isset($votes[$option])) {
    $votes[$option]++;
    file_put_contents($file, json_encode($votes));
  }
  echo json_encode($votes);
  exit;
}

echo json_encode($votes);
