<!DOCTYPE html>

<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>商品管理アプリ</title>

  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;400&display=swap" rel="stylesheet">

</head>

<body>
  <header class="header">
    <?php
      include "header.html"
    ?>
  </header>

  <main class="ly-cont">
    <article class="home">
      <h1 class="home__title">商品管理アプリ</h1>
      <p class="home__subtitle">『PHPとデータベースを連携しよう』成果物</p>
      <a class="home__btn" href="read.php">商品一覧</a>
    </article>
  </main>

  <footer class="footer">
    <?php
      include "footer.html"
    ?>
  </footer>
</body>

</html>
