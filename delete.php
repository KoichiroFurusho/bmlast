<?php
$id = $_GET['id'];

require_once('funcs.php');
$pdo = db_conn();

//２．データ登録SQL作成
$stmt = $pdo->prepare('DELETE FROM gs_bm_table WHERE id = :id');
// ↓追加
$stmt->bindValue(':id', h($id), PDO::PARAM_INT);
$status = $stmt->execute();
//３．データ表示
if ($status == false) {
    sql_error($status);
} else {
    redirect('bm_update_view.php');
}