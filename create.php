<?php
  $dsn = 'mysql:dbname=php_db_app;host=mysql_php_db_app;charset=utf8mb4';
  $user = 'root';
  $password = 'root';

  // submitパラメータの値が存在するとき（「登録」ボタンを押したとき）の処理
  if (isset($_POST['submit'])) {
    try {
      //  データベースの接続を試行する
      $pdo = new PDO($dsn, $user, $password);

      // テーブルからすべてのデータを取得
      // $sql = 'SELECT * FROM products';

      // 動的に変わる値をプレースホルダに置き換えたINSERT文をあらかじめ用意する
      $sql_insert = '
        INSERT INTO products (product_code, product_name, price, stock_quantity, vendor_code)
        VALUES (:product_code, :product_name, :price, :stock_quantity, :vendor_code)
      ';
      $stmt_insert = $pdo->prepare($sql_insert);

      // bindValue()メソッドを使って実際の値をプレースホルダにバインドする（割り当てる）
      $stmt_insert->bindValue(':product_code', $_POST['product_code'], PDO::PARAM_STR);
      $stmt_insert->bindValue(':product_name', $_POST['product_name'], PDO::PARAM_STR);
      $stmt_insert->bindValue(':price', $_POST['price'], PDO::PARAM_STR);
      $stmt_insert->bindValue(':stock_quantity', $_POST['stock_quantity'], PDO::PARAM_STR);
      $stmt_insert->bindValue(':vendor_code', $_POST['vendor_code'], PDO::PARAM_STR);

      // SQL文を実行する
      $stmt_insert->execute();

      // header()関数を使ってリダイレクト
      header('Location: read.php');
    } catch (PDOException $e) {
      exit($e->getMessage());
    }
  }

  try {
    //  データベースの接続を試行する
    $pdo = new PDO($dsn, $user, $password);

    // テーブルからすべてのデータを取得
    $sql_vendors = 'SELECT vendor_code FROM vendors';

    // SQL文を実行する
    $stmt_vendors = $pdo->query($sql_vendors);

    // SQL文の実行結果を配列で取得する
    $vendor_codes = $stmt_vendors->fetchAll(PDO::FETCH_COLUMN);
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

</head>

<body>
  <header class="header">
    <?php
      include "header.html"
    ?>
  </header>

  <main class="ly-cont">
    <article class="create">
      <h1 class="sec-title">商品登録</h1>

      <a class="btn" href="read.php">戻る</a>

      <form action="create.php" method="post" class="form-ly">
        <div class="form-ly__item">
          <label for="product_code">商品コード</label>
          <input type="text" name="product_code" maxlength="60" required>

          <label for="product_name">商品名</label>
          <input type="text" name="product_name" maxlength="60" required>

          <label for="price">単価</label>
          <input type="text" name="price" maxlength="60" required>

          <label for="stock_quantity">在庫数</label>
          <input type="text" name="stock_quantity" maxlength="60" required>

          <label for="vendor_code">仕入れ先コード</label>
          <!-- <input type="text" name="vendor_code" maxlength="60" required> -->
          <select class="vendor-select" name="vendor_code" maxlength="60" required>
            <option disabled selected value class="vendor-select__default">---</option>
            <!-- <option value=""></option> -->
            <link rel="stylesheet" href="css/style.css">
            <?php
            // foreach ($vendor_codes as $vendor_code_key => $vendor_code_val) {
            //   # code...
            //   $vendor_codes .= "<option value='". $vendor_code_key;
            //   $vendor_codes .= "'>". $vendor_code_val. "</option>";
            // }

            foreach ($vendor_codes as $vendor_code) {
              echo "<option value='{$vendor_code}'>{$vendor_code}</option>";
            }
            ?>
          </select>
        </div>

        <a class="btn" href="read.php"><button type="submit" name="submit" value="insert">登録</button></a>
      </form>
    </article>

  </main>

  <footer class="footer"> y3
    <?php
      include "footer.html"
    ?>
  </footer>
</body>

</html>
