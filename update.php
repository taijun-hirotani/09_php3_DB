<!-- 
INSERT： データを“登録”する事ができます。
SELECT： データを“表示“する事ができます。
UPDATE： データを“更新”する事ができます。ここ
DELETE： データを“削除“する事ができます。
-->

<?php
//POSTでカラムを取得
$id      = $_POST["id"];
$name    = $_POST["title"];
$address = $_POST["address"];
$lat     = $_POST["lat"];
$lon     = $_POST["lon"]; 

//2. DB接続します
try {
    //Password:MAMP='root',XAMPP=''
    $pdo = new PDO('mysql:dbname=orangepuma5_tj01;charset=utf8;host=mysql1031.db.sakura.ne.jp','orangepuma5','taijun1217');
    } catch (PDOException $e) {
    exit('接続エラー:'.$e->getMessage());
}//エラーを取得

//3.更新
$sql = 'UPDATE kadai3 SET title=:title, address=:address, lat=:lat, lon=:lon WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':title',   $title,    PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':address', $address, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lat',     $lat,     PDO::PARAM_INT); 
$stmt->bindValue(':lon',     $lon,     PDO::PARAM_INT); 
$stmt->bindValue(':id',      $id,      PDO::PARAM_INT); //更新したいIDを渡す
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
//SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
$error = $stmt->errorInfo();
exit("SQLエラー:".$error[2]);
}else{
//５．index.phpへリダイレクト
header("Location: select.php");
exit;

}

?>