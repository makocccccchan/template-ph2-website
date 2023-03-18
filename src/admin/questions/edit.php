<?php




require('../../dbconnect.php');

$sql = "SELECT * FROM questions WHERE id = :id";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(":id", $_REQUEST["id"]);
  $stmt->execute();
  $question = $stmt->fetch(PDO::FETCH_ASSOC);
  
  $sql = "SELECT * FROM choices WHERE question_id = :question_id";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(":question_id", $_REQUEST["id"]);
  $stmt->execute();
  $choices = $stmt->fetchAll(PDO::FETCH_ASSOC);
  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $params = [
      "content" => $_POST["content"],
      "supplement" => $_POST["supplement"],
      "id" => $_POST["id"],
    ];
    $set_query = "SET content = :content, supplement = :supplement";
    if ($_FILES["image"]["tmp_name"] !== "") {
      $set_query .= ", image = :image";
      $params["image"] = "";
    }
    
    $sql = "UPDATE questions $set_query WHERE id = :id";
    
    $dbh->beginTransaction();
    try { 
      if(isset($params["image"])) {
        $image_name = uniqid(mt_rand(), true) . '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);
        $image_path = dirname(__FILE__) . '/../../assets/img/quiz/' . $image_name;
        move_uploaded_file(
          $_FILES['image']['tmp_name'], 
          $image_path
        );
        $params["image"] = $image_name;
      }
    
      $stmt = $dbh->prepare($sql);
      $result = $stmt->execute($params);
    
      $sql = "DELETE FROM choices WHERE question_id = :question_id ";
      $stmt = $dbh->prepare($sql);
      $stmt->bindValue(":question_id", $_POST["id"]);
      $stmt->execute();
    
      $stmt = $dbh->prepare("INSERT INTO choices(name, valid, question_id) VALUES(:name, :valid, :question_id)");
      for ($i = 0; $i < count($_POST["choices"]); $i++) {
        $stmt->execute([
          "name" => $_POST["choices"][$i],
          "valid" => (int)$_POST['correctChoice'] === $i + 1 ? 1 : 0,
          "question_id" => $_POST["id"]
        ]);
      }
      $dbh->commit();
    } catch(Error $e) {
      $dbh->rollBack();
    }
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
        <h1 class="mb-4">問題編集</h1>
        <form class="question-form" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?= $question["id"] ?>">
          <div class="mb-4">
            <label for="question" class="form-label">問題文:</label>
            <input  type="text" name="content" id="question"
            class="form-control required"
            placeholder="問題文を入力してください" 
            value="<?= $question["content"] ?>"/>
          </div>
          <div class="mb-4">
            <label class="form-label">選択肢:</label>
            <?php foreach($choices as $key => $choice) { ?>
              <input type="text" name="choices[]" class="required form-control mb-2" placeholder="選択肢を入力してください" value=<?= $choice["name"] ?>>
            <?php } ?>
          </div>
          <div class="mb-4">
            <label class="form-label">正解の選択肢</label>
            <?php foreach($choices as $key => $choice) { ?>
              <div class="form-check">
                <input 
                  class="form-check-input" 
                  type="radio" name="correctChoice" id="correctChoice<?= $key ?>" 
                  value="<?= $key + 1 ?>"
                  <?= $choice["valid"] === 1 ? 'checked' : '' ?>
                >
                <label class="form-check-label" for="correctChoice1">
                  選択肢<?= $key + 1 ?>
                </label>
              </div>
            <?php } ?>
          </div>
          <div class="mb-4">
            <label for="question" class="form-label">問題の画像</label>
            <input type="file" name="image" id="image"
            class="form-control required"
            placeholder="問題文を入力してください" 
            value="<?= $question["image"] ?>"/>
          </div>
          <div class="mb-4">
            <label for="question" class="form-label">補足:</label>
            <input type="text" name="supplement" id="supplement"
            class="form-control"
            placeholder="補足を入力してください" 
            value="<?= $question["supplement"] ?>"/>
          </div>
          <button type="submit"  class="btn submit">作成</button>
        </form>
      </div>
  </main>

</body>
</html>