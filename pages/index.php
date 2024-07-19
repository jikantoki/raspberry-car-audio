<?php
?>
<html>

<head>
  <title>Raspberry Car Audio</title>
</head>

<body>
  <?php include($_SERVER['DOCUMENT_ROOT'] . '/assets/header.php'); ?>
  <button id="getDataButton" onclick="getData()">データ取得</button>
  <div class="player">
    <div class="titleAndArtist">
      <div class="playerTitle">
        <span id="playerTitle"></span>
      </div>
      <div class="playerArtist">
        <span id="playerArtist"></span>
      </div>
    </div>
  </div>
  <div id="data"></div>
</body>

<script>
  const d = document
  const getData = () => {
    fetch('/backend/getPlayMusic.php').then(async (data) => {
      const textedData = await data.json()
      d.getElementById('data').innerText = textedData
      d.getElementById('playerTitle').innerText = textedData.player.title
      d.getElementById('playerArtist').innerText = textedData.player.artist
      console.log(textedData)
    }).catch((e) => {
      console.error(e)
    })
  }
</script>

</html>