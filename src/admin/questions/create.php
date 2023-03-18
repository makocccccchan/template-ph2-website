<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $image_name = uniqid(mt_rand(), true) . '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);
  $image_path = dirname(__FILE__) . '/../../assets/img/quiz/' . $image_name;
  move_uploaded_file(
    $_FILES['image']['tmp_name'], 
    $image_path
  );

  
  $dbh = new PDO('mysql:host=db;dbname=posse', 'root', 'root');
  $stmt = $dbh->prepare("INSERT INTO questions(content, image, supplement) VALUES(:content, :image, :supplement)");
  $stmt->execute([
    "content" => $_POST["content"],
    "image" => $image_name,
    "supplement" => $_POST["supplement"]
  ]);

  $lastInsertId = $dbh->lastInsertId();
  
  $stmt = $dbh->prepare("INSERT INTO choices(name, valid, question_id) VALUES(:name, :valid, :question_id)");
  
  for ($i = 0; $i < count($_POST["choices"]); $i++) {
    $stmt->execute([
      "name" => $_POST["choices"][$i],
      "valid" => (int)$_POST['correctChoice'] === $i + 1 ? 1 : 0,
      "question_id" => $lastInsertId
    ]);
  }
  header("Location: ". "/admin/index.php");
}

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

  <main>
  <div class="container">
        <h1 class="mb-4">問題作成</h1>
        <form class="question-form" method="POST" enctype="multipart/form-data">
          <div class="mb-4">
            <label for="question" class="form-label">問題文:</label>
            <input type="text" name="content" id="question"
            class="form-control required"
            placeholder="問題文を入力してください" />
          </div>
          <div class="mb-4">
            <label class="form-label">選択肢:</label>
            <input type="text" name="choices[]" class="required form-control mb-2" placeholder="選択肢1を入力してください">
            <input type="text" name="choices[]" class="required form-control mb-2" placeholder="選択肢2を入力してください">
            <input type="text" name="choices[]" class="required form-control mb-2" placeholder="選択肢3を入力してください">
          </div>
          <div class="mb-4">
            <label class="form-label">正解の選択肢</label>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="correctChoice" id="correctChoice1" checked value="1">
              <label class="form-check-label" for="correctChoice1">
                選択肢1
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="correctChoice" id="correctChoice2" value="2">
              <label class="form-check-label" for="correctChoice2">
                選択肢2
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="correctChoice" id="correctChoice2" value="3">
              <label class="form-check-label" for="correctChoice2">
                選択肢3
              </label>
            </div>
          </div>
          <div class="mb-4">
            <label for="question" class="form-label">問題の画像</label>
            <input type="file" name="image" id="image"
            class="form-control required"
            placeholder="問題文を入力してください" />
          </div>
          <div class="mb-4">
            <label for="question" class="form-label">補足:</label>
            <input type="text" name="supplement" id="supplement"
            class="form-control"
            placeholder="補足を入力してください" />
          </div>
          <button type="submit"  class="btn submit">作成</button>
        </form>
      </div>
  </main>

  <!-- <form action="" method="post"><input type="text">
  <div>
    <label for="">問題文</label>
    <input type="text">
  </div>
  <div>
    <label for="">選択肢</label>
    <input type="text">
    <input type="text">
    <input type="text">
  </div>
  <div>
    <label for="">正解の選択肢</label>
    <input type="text">
  </div>
  <div>
    <label for="">問題の画像</label>
    <input type="text">
  </div>
  <div>
    <label for="">補足</label>
    <input type="text">
  </div> -->

</form>
</body>
</html>