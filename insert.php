<!-- 
INSERT： データを“登録”する事ができます。ここ
SELECT： データを“表示“する事ができます。
UPDATE： データを“更新”する事ができます。
DELETE： データを“削除“する事ができます。
-->


<?php
//1. POSTデータ取得
//$name = filter_input( INPUT_GET, ","name" ); //こういうのもあるよ
//$email = filter_input( INPUT_POST, "email" ); //こういうのもあるよ
$name = $_POST["title"];
$address = $_POST["address"];
$lat = $_POST["lat"];
$lon = $_POST["lon"];
$url = $_POST["url"];


//2. DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=orangepuma5_tj01;charset=utf8;host=mysql1031.db.sakura.ne.jp','orangepuma5','taijun1217');
} catch (PDOException $e) {
  exit('接続エラー:'.$e->getMessage());
}//エラーを取得


//３．データ登録SQL作成
//$stmt = $pdo->prepare("******* ***** ********( ************* )VALUES( ************");
$stmt = $pdo->prepare("INSERT INTO kadai3(id, title, address, lat, lon, url, date )VALUES( NULL, :a1, :a2, :a3, :a4, :a5, sysdate())");

//関数処理の場合
//$sql = "INSERT INTO php03( id, name, address, lat, lon, date )VALUES( NULL,:a1, :a2, :a3, :a4, sysdate())";
//stmt = $pdo->prepare($sql)



//$stmt->bindValue('******', *****, ****************);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a1', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a2', $address, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a3', $lat, PDO::PARAM_STR); 
$stmt->bindValue(':a4', $lon, PDO::PARAM_STR);
$stmt->bindValue(':a5', $url, PDO::PARAM_STR);  
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("SQLエラー:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header("Location: index.php");
  exit;

}
?>
