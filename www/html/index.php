<?php 

$curl = curl_init("https://meigen.doodlenote.net/api/json.php");
$options = array(
    // HEADER
    CURLOPT_HTTPHEADER =>$header,
    // Method
    CURLOPT_POST => true, // POST
    // body
    CURLOPT_POSTFIELDS => $params,
    // 変数に保存。これがないと即時出力
    CURLOPT_RETURNTRANSFER => true,
    // header出力
    CURLOPT_HEADER => true, 
);
 
//set options
curl_setopt_array($curl, $options);
 
// 実行
$response = curl_exec($curl);
 
// ステータスコード取得
$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
 
// header & body 取得
$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE); // ヘッダサイズ取得
$header = substr($response, 0, $header_size); // header切出
$header = array_filter(explode("\r\n",$header));
$json = substr($response, $header_size); // body切出
 
curl_close($curl);
 
print_r($json_response); // json結果
print_r($header); // header配列

function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

$title = (string)filter_input(INPUT_POST, 'title');
$data = (string)filter_input(INPUT_POST, 'data');
$separator = (string)filter_input(INPUT_POST, 'separator');

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title><?=h($title)?></title>
  <!--外部ファイルにする場合はdelayまたはasync属性必須 → --><script>
  'use strict';
  document.addEventListener('DOMContentLoaded', function () {
    var today = new Date();
    var month = today.getMonth() + 1;
    var day = today.getDate();
    document.querySelector('#today').textContent = '今日は' + month + '月' + day + '日です';
  });
  </script>
</head>
<body>
  <h1><?=h($title)?></h1>
  <p>対象の文字列：<?=h($data)?></p>
  <p>区切り文字：<?=h($separator)?></p>
  <p>分割結果：<?=h(print_r(explode($separator, $data)), true)?></p>
  <p id="today"></p>
</body>
</html>