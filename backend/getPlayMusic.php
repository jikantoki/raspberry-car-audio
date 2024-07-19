<?php

/** Bluetoothの現在のオーディオ情報を取得 */
$getSource = passthru('(echo menu player && echo show) | bluetoothctl');
$includeEnterWordString = str_replace(array("\r\n", "\r"), "\n", $getSource);
/** 取得したデータが一行ごとに配列になっている */
$arraiedString = explode("\n", $includeEnterWordString);
/** 現在の再生状況 */
$player = array(
  'title' => null,
  'artist' => null,
  'album' => null
);
foreach ($arraiedString as $string) {
  if (strpos($string, 'No default player available')) {
    echo 'オワタ';
    break;
  }
}
echo json_encode($player . "\n");
