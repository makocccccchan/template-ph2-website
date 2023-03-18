<?php

session_start();
if(!isset($_SESSION["email"])){//sessionでemailが保存されてなかったら（ログインしてなかったら） !で否定演算子
  header('Location: /admin/auth/signin.php');
}

require('../dbconnect.php');//読み込んで参照してくださいの指示文。

$questions = $dbh->query("SELECT id, content FROM questions")->fetchAll(PDO::FETCH_ASSOC);//定型文だお、myadminからphp内で使えるように変数に引っ張って来たよ
//$dbh → 接続
//query → データベース検索
//fetchAll → 検索した値を取得する


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
  <header>
    <button ><a href="./auth/signout.php">logout</a></button>
    <!-- signout.phpに飛ばして、そこでsession処理をする。 -->
  </header>
  <div>あ</div>
  <?php foreach($questions as $key => $question): ?>
    <div>
      <?= $question["id"];?>
      <a href="./questions/edit.php?id=<?= $question["id"] ?>">        
        <?= $question["content"];?>
      </a>
    </div>
    <form action="./questions/delete.php" method="POST">
                    <input type="hidden" value="<?= $question["id"] ?>" name="id">
                    <input type="submit" value="削除" class="submit">
                  </form>
    <?php endforeach;?>
  
</body>
</html>