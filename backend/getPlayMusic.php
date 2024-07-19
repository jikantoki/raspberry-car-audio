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
    //既に接続されている機器に影響が出るので廃止
    //exec('bluetoothctl discoverable on');
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
  'album' => null,
  /** プレイヤー名 */
  'name' => null,
  /** 再生状態 */
  'status' => null,
  /** 再生位置 */
  'position' => null,
  /** 再生に必要な時間（だと思う） */
  'duration' => null
);
foreach ($sourceArraiedString as $string) {
  //何も再生されていない場合、その旨を返す
  if (mb_strpos($string, 'No default player available') !== false) {
    break;
  }
  if (mb_strpos($string, 'Name: ') !== false) {
    $player['name'] = mb_substr($string, mb_strlen('Name: ') + 1);
  }
  if (mb_strpos($string, 'Status: ') !== false) {
    $player['status'] = mb_substr($string, mb_strlen('Status: ') + 1);
  }
  if (mb_strpos($string, 'Position: ') !== false) {
    $player['position'] = mb_substr($string, mb_strlen('Position: ') + 1);
    /** カッコが始まるまでの情報を削除 */
    $player['position'] = mb_substr($player['position'], mb_strpos($player['position'], '(') + 1);
    /** 最後の一文字が不要なので削除 */
    $player['position'] = mb_substr($player['position'], 0, -1);
  }
  if (mb_strpos($string, 'Title: ') !== false) {
    $player['title'] = mb_substr($string, mb_strlen('Title: ') + 1);
  }
  if (mb_strpos($string, 'Duration: ') !== false) {
    $player['duration'] = mb_substr($string, mb_strlen('Duration: ') + 1);
    /** カッコが始まるまでの情報を削除 */
    $player['duration'] = mb_substr($player['duration'], mb_strpos($player['duration'], '(') + 1);
    /** 最後の一文字が不要なので削除 */
    $player['duration'] = mb_substr($player['duration'], 0, -1);
  }
  if (mb_strpos($string, 'Album: ') !== false) {
    $player['album'] = mb_substr($string, mb_strlen('Album: ') + 1);
  }
  if (mb_strpos($string, 'Artist: ') !== false) {
    $player['artist'] = mb_substr($string, mb_strlen('Artist: ') + 1);
  }
}
$result = array(
  'info' => $info,
  'player' => $player
);
echo json_encode($result);
echo "\n";
