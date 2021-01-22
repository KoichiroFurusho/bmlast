<?php
session_start();
require_once('funcs.php');
$pdo = db_conn();

//２．データ取得SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table");
$status = $stmt->execute();

//３．データ表示
$view="";
if ($status == false) {
  sql_error($status);
} else {
  while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
      //GETデータ送信リンク作成
      // <a>で囲う。
      $view .= '<p>';
      // 詳細ページリンク
      $view .= '<a href="shousai.php?id=' . $result['id'] . '">';
      $view .= $result["indate"] . "：" . $result["title"];
      $view .= '</a>';

  }
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">

<header>
  <nav class="navbar navbar-default">
  <h2>ブックマークアプリ</h2>
<form action="search.php" method="post">
    <!-- 任意の<input>要素＝入力欄などを用意する -->
    <input type="text" name="search_name">
    <!-- 送信ボタンを用意する -->
    <input type="submit" name="submit" value="本の名前を検索する">
</form>
        <table>
            <?php foreach ($stmt as $row): ?>
            <tr>
                <td><?php echo $row[0]?></td>
                <td><?php echo $row[1]?></td>
                <td><?php echo $row[2]?></td>
            </tr>
                <?php endforeach; ?>
        </table>
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="login.php">ログイン</a></div>
    <div class="navbar-header"><a class="navbar-brand" href="logout.php">ログアウト</a></div>
    </div>
  </nav>
<div>
    <div class="container jumbotron"><?= $view ?></div>
</div>
</header>
</body>
</html>
