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
  const getData = () => {
    fetch('/backend/getPlayMusic.php').then(async (data) => {
      const textedData = await data.json()
      d.getElementById('data').innerText = textedData
      console.log(textedData)
    }).catch((e) => {
      console.error(e)
    })
  }
  const unicodeUnescape = (str) => {
    let result = '',
      strs = str.match(/\\u.{4}/ig);

    if (!strs) return '';

    for (let i = 0, len = strs.length; i < len; i++) {
      result += String.fromCharCode(strs[i].replace('\\u', '0x'));
    }

    return result;
  }
</script>

</html>