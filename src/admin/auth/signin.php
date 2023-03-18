<?php

session_start();//サーバー（ブラウザより裏側）にデータを保存 クッキーはブラウザ側に保存（脆弱） 

require('../../dbconnect.php');

$email = $_POST["email"];
$password = $_POST["password"];

$sql = "SELECT * FROM users WHERE email = :email";
$stmt = $dbh->prepare($sql);//sql文を書きますよって準備
$stmt->bindValue(":email", $email);//どの変数にどの変数をいれるのか提示
$stmt->execute();//実行
$user = $stmt->fetch(PDO::FETCH_ASSOC);




if (password_verify($password, $user['password'])) {//password_verify パスワードと一致してるか確認 左：入力した方 右：テーブルに入ってる方
  //情報をセッション変数に登録
  $_SESSION['email'] = $user['email'];//サーバーにemailを保存してる  ログインしてる状態ならsession_start(); echo $_SESSION["email"]; でどこでも出てくる、してなかったら空っぽ
  header('Location: /admin/index.php');//どこかに飛ばしてくれる echo使っちゃダメ 
} else {
  //パスワードが間違っている場合
}

//session_destroy(); // セッションを破棄

?>



<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <form action="./signin.php" method="post">
    <input type="email" name="email">
    <input type="password" name="password">
    <button type="submit">login</button>
  </form>
</body>
</html>