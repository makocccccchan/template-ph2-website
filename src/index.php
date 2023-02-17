<?php

require('./dbconnect.php');//読み込んで参照してくださいの指示文。

$questions = $dbh->query("SELECT * FROM questions")->fetchAll(PDO::FETCH_ASSOC);//定型文だお、myadminからphp内で使えるように変数に引っ張って来たよ
//$dbh → 接続
//query → データベース検索
//fetchAll → 検索した値を取得する
$choices = $dbh->query("SELECT * FROM choices")->fetchAll(PDO::FETCH_ASSOC);

foreach ($choices as $key => $choice) {//$choice = 1問目1個目の選択肢、1問目2個目の選択肢、1問目3個目の選択肢。。。

  $index = array_search($choice["question_id"], array_column($questions, 'id'));//入り口作ってテーブルの紐付け。choiceテーブルのquestion_idとquestionテーブルのidの紐づけ。array_search(1, “1,2,3,4,5,6”)→ 1、array_search(2, “1,2,3,4,5,6”)→ 2

  $questions[$index]["choices"][] = $choice;//ぶっこむ。データの紐付け。question変数の中にchoicesの中身（データ）をぶっこんだ。index=問題番号、choicesって書いてカラムみたいなの追加してる
}

//array_search：配列の値を検索する関数 array_search(検索する値、検索をかける場所)
//array_column：特定のカラムだけで構成された新しい配列を返す関数
//questionsとchoicesを紐づけするだけの処理。出力はできてない。

var_dump($questions[0]["choices"][0])//localhostに出力するやつ

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ITクイズ | POSSE 初めてのWeb制作</title>
  <!-- スタイルシート読み込み -->
  <link rel="stylesheet" href="../assets/styles/common.css">
  <!-- Google Fonts読み込み -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Plus+Jakarta+Sans:wght@400;700&display=swap"
    rel="stylesheet">
  <script src="../assets/scripts/quiz.js" defer></script>
</head>

<body>
  <!-- <header class="l-header p-header">
    <div class="p-header__logo"><img src="../assets/img/logo.svg" alt="POSSE"></div>
    <nav class="p-header__nav">
      <ul class="p-header__nav__list">
        <li class="p-header__nav__item">
          <a href="../" class="p-header__nav__item__link">トップページ</a>
        </li>
        <li class="p-header__nav__item">
          <a href="./quiz/" class="p-header__nav__item__link">クイズ</a>
        </li>
      </ul>
    </nav>
    <ul class="p-header__sns p-sns">
      <li class="p-sns__item">
        <a href="https://twitter.com/posse_program" target="_blank" rel="noopener noreferrer" class="p-sns__item__link"
          aria-label="Twitter">
          <i class="u-icon__twitter"></i>
        </a>
      </li>
      <li class="p-sns__item">
        <a href="https://www.instagram.com/posse_programming/" target="_blank" rel="noopener noreferrer"
          class="p-sns__item__link" aria-label="instagram">
          <i class="u-icon__instagram"></i>
        </a>
      </li>
    </ul>
  </header>
  <!-- /.l-header .p-header -->

  <main class="l-main">
    <section class="p-hero p-quiz-hero">
      <div class="l-container">
        <h1 class="p-hero__title">
          <span class="p-hero__title__label">POSSE課題</span>
          <span class="p-hero__title__inline">ITクイズ</span>
        </h1>
      </div>
    </section>
    <!-- /.p-hero .p-quiz-hero -->


<?php foreach($questions as $key => $question): ?>
  <section class="p-quiz-box js-quiz" data-quiz="2">
        <div class="p-quiz-box__question">
          <h2 class="p-quiz-box__question__title">
            <span class="p-quiz-box__label">Q<?= $key + 1 ;?></span>
            <span class="p-quiz-box__question__title__text"><?= $question["content"];?></span>
          </h2>
          <figure class="p-quiz-box__question__image">
            <img src="../assets/img/quiz/<?= $question["image"];?>" alt="">
          </figure>
        </div>
        <div class="p-quiz-box__answer">
          <span class="p-quiz-box__label p-quiz-box__label--accent">A</span>
          <ul class="p-quiz-box__answer__list">
            <?php foreach($question["choices"] as $choice) :?>
            <li class="p-quiz-box__answer__item">
              <button class="p-quiz-box__answer__button js-answer" data-answer="0">
                <?= $choice["name"];?><i class="u-icon__arrow"></i>
              </button>
            </li>
            <?php endforeach; ?>
          </ul>
          <div class="p-quiz-box__answer__correct js-answerBox">
            <p class="p-quiz-box__answer__correct__title js-answerTitle"></p>
            <p class="p-quiz-box__answer__correct__content">
              <span class="p-quiz-box__answer__correct__content__label">A</span>
              <span class="js-answerText"></span>
            </p>
          </div>
        </div>
      </section>
<?php endforeach;?>


    <div class="p-quiz-container l-container">
      <section class="p-quiz-box js-quiz" data-quiz="0">
        <div class="p-quiz-box__question">
          <h2 class="p-quiz-box__question__title">
            <span class="p-quiz-box__label">Q1</span>
            <span class="p-quiz-box__question__title__text">日本のIT人材が2030年には最大どれくらい不足すると言われているでしょうか？</span>
          </h2>
          <figure class="p-quiz-box__question__image">
            <img src="../assets/img/quiz/img-quiz01.png" alt="">
          </figure>
        </div>
        <div class="p-quiz-box__answer">
          <span class="p-quiz-box__label p-quiz-box__label--accent">A</span>
          <ul class="p-quiz-box__answer__list">
            <li class="p-quiz-box__answer__item">
              <button class="p-quiz-box__answer__button js-answer" data-answer="0">
                約28万人<i class="u-icon__arrow"></i>
              </button>
            </li>
            <li class="p-quiz-box__answer__item">
              <button class="p-quiz-box__answer__button js-answer" data-answer="1">
                約79万人<i class="u-icon__arrow"></i>
              </button>
            </li>
            <li class="p-quiz-box__answer__item">
              <button class="p-quiz-box__answer__button js-answer" data-answer="2">
                約183万人<i class="u-icon__arrow"></i>
              </button>
            </li>
          </ul>
          <div class="p-quiz-box__answer__correct js-answerBox">
            <p class="p-quiz-box__answer__correct__title js-answerTitle"></p>
            <p class="p-quiz-box__answer__correct__content">
              <span class="p-quiz-box__answer__correct__content__label">A</span>
              <span class="js-answerText"></span>
            </p>
          </div>
        </div>
        <blockquote class="p-quiz-box__note">
          <i class="u-icon__note"></i>経済産業省 2019年3月 － IT 人材需給に関する調査
        </blockquote>
      </section>
      <!-- ./p-quiz-box -->

      <section class="p-quiz-box js-quiz" data-quiz="1">
        <div class="p-quiz-box__question">
          <h2 class="p-quiz-box__question__title">
            <span class="p-quiz-box__label">Q2</span>
            <span class="p-quiz-box__question__title__text">既存業界のビジネスと、先進的なテクノロジーを結びつけて生まれた、新しいビジネスのことをなんと言うでしょう？</span>
          </h2>
          <figure class="p-quiz-box__question__image">
            <img src="../assets/img/quiz/img-quiz02.png" alt="">
          </figure>
        </div>
        <div class="p-quiz-box__answer">
          <span class="p-quiz-box__label p-quiz-box__label--accent">A</span>
          <ul class="p-quiz-box__answer__list">
            <li class="p-quiz-box__answer__item">
              <button class="p-quiz-box__answer__button js-answer" data-answer="0">
                INTECH<i class="u-icon__arrow"></i>
              </button>
            </li>
            <li class="p-quiz-box__answer__item">
              <button class="p-quiz-box__answer__button js-answer" data-answer="1">
                BIZZTECH<i class="u-icon__arrow"></i>
              </button>
            </li>
            <li class="p-quiz-box__answer__item">
              <button class="p-quiz-box__answer__button js-answer" data-answer="2">
                X-TECH<i class="u-icon__arrow"></i>
              </button>
            </li>
          </ul>
          <div class="p-quiz-box__answer__correct js-answerBox">
            <p class="p-quiz-box__answer__correct__title js-answerTitle"></p>
            <p class="p-quiz-box__answer__correct__content">
              <span class="p-quiz-box__answer__correct__content__label">A</span>
              <span class="js-answerText"></span>
            </p>
          </div>
        </div>
      </section>
      <!-- ./p-quiz-box -->

      <section class="p-quiz-box js-quiz" data-quiz="2">
        <div class="p-quiz-box__question">
          <h2 class="p-quiz-box__question__title">
            <span class="p-quiz-box__label">Q3</span>
            <span class="p-quiz-box__question__title__text">IoTとは何の略でしょう？</span>
          </h2>
          <figure class="p-quiz-box__question__image">
            <img src="../assets/img/quiz/img-quiz03.png" alt="">
          </figure>
        </div>
        <div class="p-quiz-box__answer">
          <span class="p-quiz-box__label p-quiz-box__label--accent">A</span>
          <ul class="p-quiz-box__answer__list">
            <li class="p-quiz-box__answer__item">
              <button class="p-quiz-box__answer__button js-answer" data-answer="0">
                Internet of Things<i class="u-icon__arrow"></i>
              </button>
            </li>
            <li class="p-quiz-box__answer__item">
              <button class="p-quiz-box__answer__button js-answer" data-answer="1">
                Integrate into Technology<i class="u-icon__arrow"></i>
              </button>
            </li>
            <li class="p-quiz-box__answer__item">
              <button class="p-quiz-box__answer__button js-answer" data-answer="2">
                Information on Tool<i class="u-icon__arrow"></i>
              </button>
            </li>
          </ul>
          <div class="p-quiz-box__answer__correct js-answerBox">
            <p class="p-quiz-box__answer__correct__title js-answerTitle"></p>
            <p class="p-quiz-box__answer__correct__content">
              <span class="p-quiz-box__answer__correct__content__label">A</span>
              <span class="js-answerText"></span>
            </p>
          </div>
        </div>
      </section>
      <!-- ./p-quiz-box -->

      <section class="p-quiz-box js-quiz" data-quiz="3">
        <div class="p-quiz-box__question">
          <h2 class="p-quiz-box__question__title">
            <span class="p-quiz-box__label">Q4</span>
            <span
              class="p-quiz-box__question__title__text">イギリスのコンピューター科学者であるギャビン・ウッド氏が提唱した、ブロックチェーン技術を活用した「次世代分散型インターネット」のことをなんと言うでしょう？</span>
          </h2>
          <figure class="p-quiz-box__question__image">
            <img src="../assets/img/quiz/img-quiz04.png" alt="">
          </figure>
        </div>
        <div class="p-quiz-box__answer">
          <span class="p-quiz-box__label p-quiz-box__label--accent">A</span>
          <ul class="p-quiz-box__answer__list">
            <li class="p-quiz-box__answer__item">
              <button class="p-quiz-box__answer__button js-answer" data-answer="0">
                Society 5.0<i class="u-icon__arrow"></i>
              </button>
            </li>
            <li class="p-quiz-box__answer__item">
              <button class="p-quiz-box__answer__button js-answer" data-answer="1">
                CyPhy<i class="u-icon__arrow"></i>
              </button>
            </li>
            <li class="p-quiz-box__answer__item">
              <button class="p-quiz-box__answer__button js-answer" data-answer="2">
                SDGs<i class="u-icon__arrow"></i>
              </button>
            </li>
          </ul>
          <div class="p-quiz-box__answer__correct js-answerBox">
            <p class="p-quiz-box__answer__correct__title js-answerTitle"></p>
            <p class="p-quiz-box__answer__correct__content">
              <span class="p-quiz-box__answer__correct__content__label">A</span>
              <span class="js-answerText"></span>
            </p>
          </div>
        </div>
        <blockquote class="p-quiz-box__note">
          <i class="u-icon__note"></i>Society5.0 - 科学技術政策 - 内閣府
        </blockquote>
      </section>
      <!-- ./p-quiz-box -->

      <section class="p-quiz-box js-quiz" data-quiz="4">
        <div class="p-quiz-box__question">
          <h2 class="p-quiz-box__question__title">
            <span class="p-quiz-box__label">Q5</span>
            <span
              class="p-quiz-box__question__title__text">イギリスのコンピューター科学者であるギャビン・ウッド氏が提唱した、ブロックチェーン技術を活用した「次世代分散型インターネット」のことをなんと言うでしょう？</span>
          </h2>
          <figure class="p-quiz-box__question__image">
            <img src="../assets/img/quiz/img-quiz05.png" alt="">
          </figure>
        </div>
        <div class="p-quiz-box__answer">
          <span class="p-quiz-box__label p-quiz-box__label--accent">A</span>
          <ul class="p-quiz-box__answer__list">
            <li class="p-quiz-box__answer__item">
              <button class="p-quiz-box__answer__button js-answer" data-answer="0">
                Web3.0<i class="u-icon__arrow"></i>
              </button>
            </li>
            <li class="p-quiz-box__answer__item">
              <button class="p-quiz-box__answer__button js-answer" data-answer="1">
                NFT<i class="u-icon__arrow"></i>
              </button>
            </li>
            <li class="p-quiz-box__answer__item">
              <button class="p-quiz-box__answer__button js-answer" data-answer="2">
                メタバース<i class="u-icon__arrow"></i>
              </button>
            </li>
          </ul>
          <div class="p-quiz-box__answer__correct js-answerBox">
            <p class="p-quiz-box__answer__correct__title js-answerTitle"></p>
            <p class="p-quiz-box__answer__correct__content">
              <span class="p-quiz-box__answer__correct__content__label">A</span>
              <span class="js-answerText"></span>
            </p>
          </div>
        </div>
      </section>
      <!-- ./p-quiz-box -->

      <section class="p-quiz-box js-quiz" data-quiz="5">
        <div class="p-quiz-box__question">
          <h2 class="p-quiz-box__question__title">
            <span class="p-quiz-box__label">Q6</span>
            <span class="p-quiz-box__question__title__text">先進テクノロジー活用企業と出遅れた企業の収益性の差はどれくらいあると言われているでしょうか？</span>
          </h2>
          <figure class="p-quiz-box__question__image">
            <img src="../assets/img/quiz/img-quiz06.png" alt="">
          </figure>
        </div>
        <div class="p-quiz-box__answer">
          <span class="p-quiz-box__label p-quiz-box__label--accent">A</span>
          <ul class="p-quiz-box__answer__list">
            <li class="p-quiz-box__answer__item">
              <button class="p-quiz-box__answer__button js-answer" data-answer="0">
                約2倍<i class="u-icon__arrow"></i>
              </button>
            </li>
            <li class="p-quiz-box__answer__item">
              <button class="p-quiz-box__answer__button js-answer" data-answer="1">
                約5倍<i class="u-icon__arrow"></i>
              </button>
            </li>
            <li class="p-quiz-box__answer__item">
              <button class="p-quiz-box__answer__button js-answer" data-answer="2">
                約11倍<i class="u-icon__arrow"></i>
              </button>
            </li>
          </ul>
          <div class="p-quiz-box__answer__correct js-answerBox">
            <p class="p-quiz-box__answer__correct__title js-answerTitle"></p>
            <p class="p-quiz-box__answer__correct__content">
              <span class="p-quiz-box__answer__correct__content__label">A</span>
              <span class="js-answerText"></span>
            </p>
          </div>
        </div>
        <blockquote class="p-quiz-box__note">
          <i class="u-icon__note"></i>Accenture Technology Vision 2021
        </blockquote>
      </section>
      <!-- ./p-quiz-box -->
    </div>
    <!-- /.l-container .p-quiz-container -->
  </main>

  <div class="p-line">
    <div class="l-container">
      <div class="p-line__body">
        <div class="p-line__body__inner">
          <h2 class="p-heading -light p-line__title"><i class="u-icon__line"></i>POSSE 公式LINE</h2>
          <div class="p-line__content">
            <p>公式LINEにてご質問を随時受け付けております。<br>詳細やPOSSE最新情報につきましては、公式LINEにてお知らせ致しますので<br>下記ボタンより友達追加をお願いします！</p>
          </div>
          <div class="p-line__footer">
            <a href="https://line.me/R/ti/p/@651htnqp?from=page" target="_blank" rel="noopener noreferrer"
              class="p-line__button">LINE追加<i class="u-icon__link"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.p-line -->

  <footer class="l-footer p-footer">
    <div class="p-fixedLine">
      <a href="https://line.me/R/ti/p/@651htnqp?from=page" target="_blank" rel="noopener noreferrer"
        class="p-fixedLine__link">
        <i class="u-icon__line"></i>
        <p class="p-fixedLine__link__text">POSSE公式LINEで<br>最新情報をGET！</p>
        <i class="u-icon__link"></i>
      </a>
    </div>
    <div class="l-footer__inner">
      <div class="p-footer__siteinfo">
        <span class="p-footer__logo">
          <img src="../assets/img/logo.svg" alt="POSSE">
        </span>
        <a href="https://posse-ap.com/" target="_blank" rel="noopener noreferrer"
          class="p-footer__siteinfo__link">POSSE公式サイト</a>
      </div>
      <div class="p-footer__sns">
        <ul class="p-sns__list p-footer__sns__list">
          <li class="p-sns__item">
            <a href="https://twitter.com/posse_program" target="_blank" rel="noopener noreferrer"
              class="p-sns__item__link" aria-label="Twitter">
              <i class="u-icon__twitter"></i>
            </a>
          </li>
          <li class="p-sns__item">
            <a href="https://www.instagram.com/posse_programming/" target="_blank" rel="noopener noreferrer"
              class="p-sns__item__link" aria-label="instagram">
              <i class="u-icon__instagram"></i>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="p-footer__copyright">
      <small lang="en">©︎2022 POSSE</small>
    </div>
  </footer> -->
  <!-- /.l-footer .p-footer -->

</body>

</html>
