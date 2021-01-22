<?php
session_start();
/**
 * １．PHP
 * [ここでやりたいこと]
 * まず、クエリパラメータの確認 = GETで取得している内容を確認する
 * イメージは、select.phpで取得しているデータを一つだけ取得できるようにする。
 * →select.phpのPHP<?php ?>の中身をコピー、貼り付け
 * ※SQLとデータ取得の箇所を修正します。
 */
// var_dump($_GET);
$id = $_GET['id'];
require_once('funcs.php');
loginCheck();
$pdo = db_conn();

//２．データ登録SQL作成
$stmt = $pdo->prepare('SELECT * FROM gs_bm_table WHERE id = ' . $id . ';');
$stmt->bindValue(":id", $id, PDO::PARAM_INT);
$status = $stmt->execute();
//３．データ表示
if ($status == false) {
    sql_error($status);
} else {
    while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $view .= '<p>';
        $view .= '<a href="bm_update.php?id=' . $r["id"] . '">';
        $view .= $r["id"] . " " . $r["title"] . " " . $r["url"];
        $view .= '</a>';
        $view .= "　";

        if($_SESSION['kanri_flg'] == 1){
        $view .= '<a class="btn btn-danger" href="delete.php?id=' . $r["id"] . '">';
        $view .= '[<i class="glyphicon glyphicon-remove"></i>削除]';
        $view .= '</a>';
        $view .= '</p>';
        }
    }
}
?>
<!--
２．HTML
以下にindex.phpのHTMLをまるっと貼り付ける！
(入力項目は「登録/更新」はほぼ同じになるから)
※form要素 input type="hidden" name="id" を１項目追加（非表示項目）
※form要素 action="update.php"に変更
※input要素 value="ここに変数埋め込み"
-->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>データ登録</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <!-- Head[Start] -->
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand" href="bm_update_view.php">データ一覧</a></div>
            </div>
        </nav>
    </header>
    <!-- Head[End] -->
    <!-- Main[Start] -->
    <form method="POST" action="update.php">
        <div class="jumbotron">
            <fieldset>
                <legend>詳細データ</legend>
                <label>タイトル：<input type="text" name="title" value="<?= $row['title'] ?>"></label><br>
                <label>URL：<input type="text" name="url" value="<?= $row['url'] ?>"></label><br>

                <label><textArea name="comment" rows="4" cols="40"><?= $row['comment'] ?></textArea></label><br>
                <input type="hidden" name="id" value=<?= $row['id'] ?>>
                <input type="submit" value="送信">
            </fieldset>
        </div>
    </form>
    <!-- Main[End] -->
</body>
</html>
