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
  var getData = async () => {
    const data = await fetch('/backend/getPlayMusic.php').body
    d.getElementById('data').innerText = data
    console.log(data)
  }
</script>

</html>