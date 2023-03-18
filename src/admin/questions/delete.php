<?php

session_start();
if(!isset($_SESSION["email"])){//sessionでemailが保存されてなかったら（ログインしてなかったら） !で否定演算子
  header('Location: /admin/auth/signin.php');
}

require('../../dbconnect.php');//読み込んで参照してくださいの指示文。


//$dbh → 接続
//query → データベース検索
//fetchAll → 検索した値を取得する

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  $dbh->beginTransaction();
  try {
    $sql = "DELETE FROM choices WHERE question_id = :question_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(":question_id", $_POST["id"]);
    $stmt->execute();

    $sql = "DELETE FROM questions WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(":id", $_POST["id"]);
    $stmt->execute();
    $dbh->commit();
    $message = "問題削除に成功しました";
    header('Location: /admin/index.php');
  } catch(Error $e) {
    $dbh->rollBack();
    $message = "問題削除に失敗しました";
  }
}




?>