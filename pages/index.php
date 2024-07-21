<?php
?>
<html>

<head>
  <title>Raspberry Car Audio</title>
  <style>
    body {
      font-size: 4vw;
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

    .playBar,
    .fullPlayBar,
    .nowPlayPosition {
      height: 0.5em;
    }

    .fullPlayBar {
      background-color: greenyellow;
      width: 100%;
    }

    .nowPlayPosition {
      background-color: red;
      width: 0%;
      transition: all 0.5s;
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
        <span class="spaceWord">　</span>
        <span id="playerTitle"></span>
        <span class="spaceWord">　</span>
      </div>
      <div class="playerArtist">
        <span class="spaceWord">　</span>
        <span id="playerArtist"></span>
        <span class="spaceWord">　</span>
      </div>
      <div class="playerAlbum">
        <span class="spaceWord">　</span>
        <span id="playerAlbum"></span>
        <span class="spaceWord">　</span>
      </div>
      <div class="playerPosition">
        <span id="playerPosition">　</span>/<span id="playerDuration">　</span>
      </div>
      <div class="playBar">
        <div class="fullPlayBar">
          <div class="nowPlayPosition" id="nowPlayPosition"></div>
        </div>
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
      /** 現在何%まで再生されているか？ */
      const nowPlayPosition = Math.round(
        Number(
          d.getElementById('nowPlayPosition').style.width.replace(/%/, '')
        ) * 10
      ) / 10
      /** 次は何%に設定するのか */
      const setPlayPosition = Math.round(
        (
          (textedData.player.position / textedData.player.duration) * 100
        ) * 10
      ) / 10
      if (nowPlayPosition !== setPlayPosition) {
        if (nowPlayPosition < setPlayPosition) {
          d.getElementById('nowPlayPosition').style.width = `${setPlayPosition}%`
        } else {
          //再生時間が戻る場合はアニメーションを切る
          d.getElementById('nowPlayPosition').style.transition = `all 0.0s`
          d.getElementById('nowPlayPosition').style.width = `${setPlayPosition}%`
          setInterval(() => {
            d.getElementById('nowPlayPosition').style.transition = null
          }, 1000)
        }
      }
      console.log(textedData)
    }).catch((e) => {
      console.error(e)
    })
  }

  /** ここで指定したミリ秒毎に情報を更新 */
  setInterval(getData, 300)
</script>

</html>