<?php
?>
<html>

<head>
  <title>Raspberry Car Audio</title>
  <style>
    #playerTitle {
      font-size: 2em;
    }

    .playerTitle,
    .playerArtist {
      display: flex;
      justify-content: center;
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
        <span id="playerTitle"></span>
      </div>
      <div class="playerArtist">
        <span id="playerArtist"></span>
      </div>
      <div class="playerPosition">
        <span id="playerPotision"></span>/<span id="playerDuration"></span>
      </div>
    </div>
  </div>
</body>

<script>
  const d = document
  const getData = () => {
    fetch('/backend/getPlayMusic.php').then(async (data) => {
      const textedData = await data.json()
      textedData.info.name ?
        d.getElementById('deviceName').innerText = textedData.info.name :
        d.getElementById('deviceName').innerText = 'なし'
      textedData.player.title ?
        d.getElementById('playerTitle').innerText = textedData.player.title :
        d.getElementById('playerTitle').innerText = 'メディアなし'
      textedData.player.artist ?
        d.getElementById('playerArtist').innerText = textedData.player.artist :
        d.getElementById('playerArtist').innerText = ''
      textedData.player.position ?
        d.getElementById('playerPosition').innerText = textedData.player.position :
        d.getElementById('playerPosition').innerText = '0'
      textedData.player.duration ?
        d.getElementById('playerDuration').innerText = textedData.player.duration :
        d.getElementById('playerDuration').innerText = '0'
      console.log(textedData)
    }).catch((e) => {
      console.error(e)
    })
  }

  setInterval(getData, 100)
</script>

</html>