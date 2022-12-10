<?php
  $dsn = 'mysql:dbname=php_db_app;host=mysql_php_db_app;charset=utf8mb4';
  $user = 'root';
  $password = 'root';

  // // submitパラメータの値が存在するとき（「更新」ボタンを押したとき）の処理
  // if (isset($_POST['submit'])) {
  //   try {
  //     //  データベースの接続を試行する
  //     $pdo = new PDO($dsn, $user, $password);

  //     // テーブルからすべてのデータを取得
  //     // $sql = 'SELECT * FROM products';

  //     // 動的に変わる値をプレースホルダに置き換えたUPDATE文をあらかじめ用意する
  //     $sql_update = '
  //       UPDATE products
  //       SET product_code = :product_code,
  //       product_name = :product_name,
  //       price = :price,
  //       stock_quantity = :stock_quantity,
  //       vendor_code = :vendor_code
  //       WHERE id = :id
  //     ';
  //     $stmt_update = $pdo->prepare($sql_update);

  //     // bindValue()メソッドを使って実際の値をプレースホルダにバインドする（割り当てる）
  //     $stmt_update->bindValue(':product_code', $_POST['product_code'], PDO::PARAM_INT);
  //     $stmt_update->bindValue(':product_name', $_POST['product_name'], PDO::PARAM_STR);
  //     $stmt_update->bindValue(':price', $_POST['price'], PDO::PARAM_INT);
  //     $stmt_update->bindValue(':stock_quantity', $_POST['stock_quantity'], PDO::PARAM_INT);
  //     $stmt_update->bindValue(':vendor_code', $_POST['vendor_code'], PDO::PARAM_INT);
  //     $stmt_update->bindValue(':id', $_GET['id'], PDO::PARAM_INT);

  //     // SQL文を実行する
  //     $stmt_update->execute();

  //     // リダイレクト
  //     header("Location: read.php");
  //   } catch (PDOException $e) {
  //     exit($e->getMessage());
  //   }
  // }

  // // idパラメータの値が存在すれば処理を行う
  // if (isset($_GET['id'])) {
  //   try {
  //     $pdo = new PDO($dsn, $user, $password);

  //     // idカラムの値をプレースホルダ（:id）に置き換えたSQL文をあらかじめ用意する
  //     $sql_select_product = 'SELECT * FROM products WHERE id = :id';
  //     $stmt_select_product = $pdo->prepare($sql_select_product);

  //     // bindValue()メソッドを使って実際の値をプレースホルダにバインドする（割り当てる）
  //     $stmt_select_product->bindValue(':id', $_GET['id'], PDO::PARAM_INT);

  //     // SQL文を実行する
  //     $stmt_select_product->execute();

  //     // SQL文の実行結果を配列で取得する
  //     // 補足：1つのレコード（横1行のデータ）のみを取得したい場合、fetch()メソッドを使えばカラム名がキーになった1次元配列を取得できる
  //     $product = $stmt_select_product->fetch(PDO::FETCH_ASSOC);

  //     // idパラメータの値と同じidのデータが存在しない場合はエラーメッセージを表示して処理を終了する
  //     // 補足：fetch()メソッドは実行結果が取得できなかった場合にFALSEを返す
  //     if ($product === FALSE) {
  //       exit('idパラメータの値が不正です。');
  //     }

  //     // vendorsテーブルからvendor_codeカラムのデータを取得するためのSQL文を変数$sql_select_vendor_codesに代入する
  //     $sql_select_vendor_codes = 'SELECT vendor_code FROM vendors';

  //     // SQL文を実行する
  //     $stmt_select_vendor_codes = $pdo->query($sql_select_vendor_codes);

  //     // SQL文の実行結果を配列で取得する
  //     $vendor_codes = $stmt_select_vendor_codes->fetchAll(PDO::FETCH_COLUMN);
  //   } catch (PDOException $e) {
  //     exit($e->getMessage());
  //   }
  // } else {
  //   // idパラメータの値が存在しない場合はエラーメッセージを表示して処理を停止する
  //   exit('idパラメータの値が存在しません。');
  // }

// submitパラメータの値が存在するとき（「更新」ボタンを押したとき）の処理
 if (isset($_POST['submit'])) {
  try {
    $pdo = new PDO($dsn, $user, $password);

    // 動的に変わる値をプレースホルダに置き換えたUPDATE文をあらかじめ用意する
    $sql_update = '
      UPDATE products
      SET product_code = :product_code,
      product_name = :product_name,
      price = :price,
      stock_quantity = :stock_quantity,
      vendor_code = :vendor_code
      WHERE id = :id
    ';
    $stmt_update = $pdo->prepare($sql_update);

    // bindValue()メソッドを使って実際の値をプレースホルダにバインドする（割り当てる）
    $stmt_update->bindValue(':product_code', $_POST['product_code'], PDO::PARAM_INT);
    $stmt_update->bindValue(':product_name', $_POST['product_name'], PDO::PARAM_STR);
    $stmt_update->bindValue(':price', $_POST['price'], PDO::PARAM_INT);
    $stmt_update->bindValue(':stock_quantity', $_POST['stock_quantity'], PDO::PARAM_INT);
    $stmt_update->bindValue(':vendor_code', $_POST['vendor_code'], PDO::PARAM_INT);
    $stmt_update->bindValue(':id', $_GET['id'], PDO::PARAM_INT);

    // SQL文を実行する
    $stmt_update->execute();

    // 更新した件数を取得する
    $count = $stmt_update->rowCount();

    $message = "商品を{$count}件編集しました。";

    // 商品一覧ページにリダイレクトさせる（同時にmessageパラメータも渡す）
    header("Location: read.php?message={$message}");
  } catch (PDOException $e) {
    exit($e->getMessage());
  }
}

// idパラメータの値が存在すれば処理を行う
if (isset($_GET['id'])) {
  try {
    $pdo = new PDO($dsn, $user, $password);

    // idカラムの値をプレースホルダ（:id）に置き換えたSQL文をあらかじめ用意する
    $sql_select_product = 'SELECT * FROM products WHERE id = :id';
    $stmt_select_product = $pdo->prepare($sql_select_product);

    // bindValue()メソッドを使って実際の値をプレースホルダにバインドする（割り当てる）
    $stmt_select_product->bindValue(':id', $_GET['id'], PDO::PARAM_INT);

    // SQL文を実行する
    $stmt_select_product->execute();

    // SQL文の実行結果を配列で取得する
    // 補足：1つのレコード（横1行のデータ）のみを取得したい場合、fetch()メソッドを使えばカラム名がキーになった1次元配列を取得できる
    $product = $stmt_select_product->fetch(PDO::FETCH_ASSOC);

    // idパラメータの値と同じidのデータが存在しない場合はエラーメッセージを表示して処理を終了する
    // 補足：fetch()メソッドは実行結果が取得できなかった場合にFALSEを返す
    if ($product === FALSE) {
        exit('idパラメータの値が不正です。');
    }

    // vendorsテーブルからvendor_codeカラムのデータを取得するためのSQL文を変数$sql_select_vendor_codesに代入する
    $sql_select_vendor_codes = 'SELECT vendor_code FROM vendors';

    // SQL文を実行する
    $stmt_select_vendor_codes = $pdo->query($sql_select_vendor_codes);

    // SQL文の実行結果を配列で取得する
    // 補足：PDO::FETCH_COLUMNは1つのカラムの値を1次元配列（多次元ではない普通の配列）で取得する設定である
    $vendor_codes = $stmt_select_vendor_codes->fetchAll(PDO::FETCH_COLUMN);
  } catch (PDOException $e) {
    exit($e->getMessage());
  }
} else {
  // idパラメータの値が存在しない場合はエラーメッセージを表示して処理を停止する
  exit('idパラメータの値が存在しません。');
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
    <article class="update">
      <h1 class="sec-title">商品編集</h1>

      <a class="btn" href="read.php">戻る</a>

      <form action="update.php?id=<?= $_GET['id'] ?>" method="post" class="form-ly">
        <div class="form-ly__item">
          <label for="product_code">商品コード</label>
          <input type="number" name="product_code" value="<?= $product['product_code'] ?>" maxlength="60" required>

          <label for="product_name">商品名</label>
          <input type="text" name="product_name" value="<?= $product['product_name'] ?>" maxlength="60" required>

          <label for="price">単価</label>
          <input type="number" name="price" value="<?= $product['price'] ?>" maxlength="60" required>

          <label for="stock_quantity">在庫数</label>
          <input type="number" name="stock_quantity" value="<?= $product['stock_quantity'] ?>" maxlength="60" required>

          <label for="vendor_code">仕入れ先コード</label>
          <select class="vendor-select" name="vendor_code" maxlength="60" required>
            <option disabled selected value class="vendor-select__default">---</option>
            <!-- <option value=""></option> -->
            <link rel="stylesheet" href="css/style.css">
            <?php
            foreach ($vendor_codes as $vendor_code) {
              // echo "<option value='{$vendors['vendor_code']}'>{$vendor_code}</option>";

              // もし変数$vendor_codeが商品の仕入先コードの値と一致していれば、selected属性をつけて初期値にする
              if ($vendor_code === $product['vendor_code']) {
                echo "<option value='{$vendor_code}' selected>{$vendor_code}</option>";
              } else {
                echo "<option value='{$vendor_code}'>{$vendor_code}</option>";
              }
            }
            ?>
          </select>
        </div>

        <button class="btn" type="submit" name="submit" value="update">更新</button>
      </form>
    </article>

  </main>

  <footer class="footer">
    <?php
      include "footer.html"
    ?>
  </footer>
</body>

</html>
