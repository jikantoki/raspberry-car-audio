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
  if (mb_strpos($string, 'Missing device address argument') !== false) {
    //bluetoothを検出可能にする（ペアリング待ち）
    exec('bluetoothctl discoverable on');
    break;
  }

  //接続情報がゲットできた場合
  if (mb_strpos($string, 'Name: ') !== false) {
    /** 接続した端末名 */
    $info['name'] = mb_substr($string, mb_strlen('Name: ') + 1);
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
  if (mb_strpos($string, 'No default player available') !== false) {
    break;
  }
}
$result = array(
  'info' => $info,
  'player' => $player
);
echo json_encode($result);
echo "\n";
