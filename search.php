<?php
try{
    //DBに接続
    $dsn = 'mysql:dbname=kadai_db; host=localhost';
    $username= 'root';
    $password= 'root';
    $pdo = new PDO($dsn, $username, $password);

    //SQL文を実行して、結果を$stmtに代入する。
    $stmt = $pdo->prepare(" SELECT * FROM gs_bm_table WHERE title LIKE '%" . $_POST["search_name"] . "%' "); 

    //実行する
    $stmt->execute();
    echo "OK";
    echo "<br>";
} catch(PDOException $e){
    echo "失敗:" . $e->getMessage() . "\n";
    exit();
}
?>

<html>
    <body>

    <h2>検索</h2>
<form action="search.php" method="post">
    <!-- 任意の<input>要素＝入力欄などを用意する -->
    <input type="text" name="search_name">
    <!-- 送信ボタンを用意する -->
    <input type="submit" name="submit" value="名前を検索する">
</form>

        <table>
            <tr><th>ID</th><th>Name</th><th>アドレス</th></tr>
            <!-- ここでPHPのforeachを使って結果をループさせる -->
            <?php foreach ($stmt as $row): ?>
            <tr>
                <td><?php echo $row[0]?></td>
                <td><?php echo $row[1]?></td>
                <td><?php echo $row[2]?></td>
            </tr>

                <?php endforeach; ?>
        </table>
    </body>
</html>