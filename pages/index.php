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
      const d = await new Response(data).text()
      d.getElementById('data').innerText = d
      console.log(d)
    }).catch((e) => {
      console.error(e)
    })
  }
</script>

</html>