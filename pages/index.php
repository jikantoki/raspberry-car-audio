<?php
?>
<html>

<head>
  <title>Raspberry Car Audio</title>
</head>

<body>
  <?php include($_SERVER['DOCUMENT_ROOT'] . '/assets/header.php'); ?>
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
</body>

<script>
  const d = document
  const getData = () => {
    fetch('/backend/getPlayMusic.php').then(async (data) => {
      const textedData = await data.json()
      textedData.player.title ?
        d.getElementById('playerTitle').innerText = textedData.player.title :
        d.getElementById('playerTitle').innerText = 'Null'
      d.getElementById('playerArtist').innerText = textedData.player.artist
      console.log(textedData)
    }).catch((e) => {
      console.error(e)
    })
  }

  setInterval(getData, 100)
</script>

</html>