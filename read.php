<?php
$dsn = 'mysql:dbname=php_db_app;host=mysql_php_db_app;charset=utf8mb4';
$user = 'root';
$password = 'root';

try {
  //  データベースの接続を試行する
  $pdo = new PDO($dsn, $user, $password);

  // orderパラメータの値が存在すれば（並び替えボタンを押したとき）、その値を変数$orderに代入する
  if (isset($_GET['order'])) {
    $order = $_GET['order'];
  } else {
    $order = NULL;
  }

  // keywordパラメータの値が存在すれば（「検索」ボタンを押したとき）、その値を変数$keywordに代入する
  if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
  } else {
    $keyword = NULL;
  }

  // テーブルからすべてのデータを取得
  // $sql = 'SELECT * FROM products';

  // SQL文を実行する
  // $stmt = $pdo->query($sql);

  // 動的に変わる値をプレースホルダに置き換えたSELECT文をあらかじめ用意する
  // $sql = 'SELECT * FROM products WHERE product_name LIKE :keyword';

  // orderパラメータの値によってSQL文を変更する
  if ($order === 'asc') {
    // ASC（昇順）
    $sql_select = 'SELECT * FROM products WHERE product_name LIKE :keyword ORDER BY updated_at ASC';
  } else {
    // DESC（降順）
    $sql_select = 'SELECT * FROM products WHERE product_name LIKE :keyword ORDER BY updated_at DESC';
  }

  // SQL文を実行する
  $stmt_select = $pdo->prepare($sql_select);

  // SQLのLIKE句で使うため、変数$keyword（検索ワード）の前後を%で囲む（部分一致）
  // 補足：partial match＝部分一致
  $partial_match = "%{$keyword}%";

  // bindValue()メソッドを使って実際の値をプレースホルダにバインドする（割り当てる）
  $stmt_select->bindValue(':keyword', $partial_match, PDO::PARAM_STR);

  // SQL文を実行する
  $stmt_select->execute();

  // SQL文の実行結果を配列で取得する
  $products = $stmt_select->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
  exit($e->getMessage());
}
?>

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

  <script src="https://kit.fontawesome.com/cb1c1fffdd.js" crossorigin="anonymous"></script>

</head>

<body>
  <header class="header">
    <?php
      include "header.html"
    ?>
  </header>

  <main class="ly-cont">
    <article class="products">
      <h1 class="sec-title">商品一覧</h1>

      <div class="products__nav">
        <div class="products__nav__inner">
          <div class="products__nav__inner__sort">
            <a href="read.php?order=asc&keyword=<?= $keyword ?>" class="sort-btn"><i class="fa-solid fa-sort-up"></i></a>
            <a href="read.php?order=desc&keyword=<?= $keyword ?>" class="sort-btn"><i class="fa-solid fa-sort-down"></i></a>
          </div>

          <form class="products__nav__inner__search" action="read.php" method="get">
            <input class="search-text" type="text" name="keyword" placeholder="商品名で検索">
            <input class="search-submit" type="submit" name="submit" value="検索" id="search" >
            <label for="search"><i  class="fas fa-search"></i> </label>
          </form>
        </div>

        <div class="products__nav__btn">
          <a class="btn" href="create.php">商品登録</a>
        </div>
      </div>

      <table class="products__column">
        <tr>
          <th>商品コード</th>
          <th>商品名</th>
          <th>単価</th>
          <th>在庫数</th>
          <th>仕入先コード</th>
          <th>編集</th>
          <th>削除</th>
        </tr>
        <!-- <img src="img/pen-to-square-solid.svg" alt=""> -->
        <!-- <img src="img/trash-solid.svg" alt=""> -->

        <link rel="stylesheet" href="css/style.css">
        <!-- <script src="https://kit.fontawesome.com/cb1c1fffdd.js" crossorigin="anonymous"></script> -->
        <?php
        foreach ($products as $product) {
          # code...
          // <i class='fa-duotone fa-pen-to-square'></i>
          // <img class='edit-btn' src='img/pen-to-square-solid.svg'>
          $table_row = "
          <tr>
            <td>{$product['product_code']}</td>
            <td>{$product['product_name']}</td>
            <td>{$product['price']}</td>
            <td>{$product['stock_quantity']}</td>
            <td>{$product['vendor_code']}</td>
            <td><a href='update.php?id={$product['id']}'><img class='edit-btn' src='img/pen-to-square-solid.svg'></a></td>
            <td><a href='delete.php?id={$product['id']}'><img class='delete-btn' src='img/trash-solid.svg'></a></td>
          </tr>
          ";
          echo "$table_row";
        }

        ?>
      </table>
    </article>

  </main>

  <footer class="footer">
    <?php
      include "footer.html"
    ?>
  </footer>
</body>

</html>
