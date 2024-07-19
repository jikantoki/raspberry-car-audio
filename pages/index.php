<?php
?>
<html>

<head>
  <title>Raspberry Car Audio</title>
</head>

<body>
  <?php include($_SERVER['DOCUMENT_ROOT'] . '/assets/header.php'); ?>
  <button id="getDataButton" onclick="getData()">データ取得</button>
  <div id="data"></div>
</body>

<script>
  const d = document
  var getData = () => {
    fetch('/backend/getPlayMusic.php').then(async (data) => {
      d.getElementById('data').innerText = data.text()
      console.log(data.text())
    }).catch((e) => {
      console.error(e)
    })
  }
</script>

</html>