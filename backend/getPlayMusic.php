<?php

/** execの結果を行ごとに配列にして保存 */
$infoArraiedString = array();
/** Bluetoothの現在の接続情報を取得 */
$getInfo = exec('bluetoothctl info', $infoArraiedString);
/** 現在の接続情報 */
$info = array(
  'name' => null
);
foreach ($infoArraiedString as $string) {
  //何も接続されていない場合、その旨を返す
  if (strpos($string, 'Missing device address argument') !== false) {
    //bluetoothを検出可能にする（ペアリング待ち）
    exec('bluetoothctl discoverable on');
    break;
  }
}

/** execの結果を行ごとに配列にして保存 */
$sourceArraiedString = array();
/** Bluetoothの現在のオーディオ情報を取得 */
$getSource = exec('(echo menu player && echo show) | bluetoothctl', $sourceArraiedString);
/** 現在の再生状況 */
$player = array(
  'title' => null,
  'artist' => null,
  'album' => null
);
foreach ($sourceArraiedString as $string) {
  //何も再生されていない場合、その旨を返す
  if (strpos($string, 'No default player available') !== false) {
    break;
  }
}
echo json_encode($player);
echo "\n";
