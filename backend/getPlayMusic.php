<?php

/** execの結果を行ごとに配列にして保存 */
$arraiedString = array();
/** Bluetoothの現在のオーディオ情報を取得 */
$getSource = exec('(echo menu player && echo show) | bluetoothctl', $arraiedString);
/** 現在の再生状況 */
$player = array(
  'title' => null,
  'artist' => null,
  'album' => null
);
foreach ($arraiedString as $string) {
  if (strpos($string, 'No default player available') !== false) {
    echo 'オワタ';
    break;
  }
}
echo json_encode($player);
echo "\n";
