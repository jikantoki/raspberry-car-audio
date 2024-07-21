<?php
?>
<html>

<head>
  <title>Raspberry Car Audio</title>
  <style>
    body {
      font-size: 5vw;
    }

    #playerTitle {
      font-size: 2em;
    }

    .playerTitle,
    .playerArtist,
    .playerAlbum {
      display: flex;
      justify-content: center;
      text-wrap: nowrap;
      overflow: hidden;
    }
  </style>
</head>

<body>
  <?php include($_SERVER['DOCUMENT_ROOT'] . '/assets/header.php'); ?>
  <div class="device">
    <div class="deviceName">
      接続デバイス: <span id="deviceName"></span>
    </div>
  </div>
  <div class="player">
    <div class="titleAndArtist">
      <div class="playerTitle">
        <span id="playerTitle">　</span>
      </div>
      <div class="playerArtist">
        <span id="playerArtist">　</span>
      </div>
      <div class="playerAlbum">
        <span class="spaceWord">　</span>
        <span id="playerAlbum">　</span>　
        <span class="spaceWord">　</span>
      </div>
      <div class="playerPosition">
        <span id="playerPosition">　</span>/<span id="playerDuration">　</span>
      </div>
    </div>
  </div>
</body>

<script>
  const d = document
  /**
   * 画面に表示されているテキストを更新
   * * 更新があれば書き換え、同じ情報なら書き換えない
   * @param string $playData 新しく反映したい情報（曲名やアーティストなど）
   * @param string $elementId 反映させたい場所のエレメントID
   * @param string $noConnectMessage 未接続などエラー時のメッセージ
   */
  const updatePlayerText = (playData, elementId, noConnectMessage) => {
    if (playData) {
      if (playData !== d.getElementById(elementId).innerText) {
        d.getElementById(elementId).innerText = playData
      }
    } else {
      if (noConnectMessage) {
        if (noConnectMessage != d.getElementById(elementId).innerText) {
          d.getElementById(elementId).innerText = noConnectMessage
        }
      } else {
        if (d.getElementById(elementId).innerText) {
          d.getElementById(elementId).innerText = null
        }
      }
    }
  }
  const getData = () => {
    fetch('/backend/getPlayMusic.php').then(async (data) => {
      const textedData = await data.json()
      updatePlayerText(textedData.info.name, 'deviceName', 'なし')
      updatePlayerText(textedData.player.title, 'playerTitle', 'メディアなし')
      updatePlayerText(textedData.player.artist, 'playerArtist')
      updatePlayerText(textedData.player.album, 'playerAlbum')
      updatePlayerText(textedData.player.position, 'playerPosition', '0')
      updatePlayerText(textedData.player.duration, 'playerDuration', '0')
      console.log(textedData)
    }).catch((e) => {
      console.error(e)
    })
  }

  /** ここで指定したミリ秒毎に情報を更新 */
  setInterval(getData, 300)
</script>

</html>