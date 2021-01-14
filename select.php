<!-- 
INSERT： データを“登録”する事ができます。
SELECT： データを“表示“する事ができます。ここ
UPDATE： データを“更新”する事ができます。
DELETE： データを“削除“する事ができます。
-->

<?php
//1.  DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=orangepuma5_tj01;charset=utf8;host=mysql1031.db.sakura.ne.jp','orangepuma5','taijun1217');
} catch (PDOException $e) {
  exit('接続エラー:'.$e->getMessage());
}//エラーを取得

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM kadai3");//表示するテーブル＆カラム設定
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("SQLエラー:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $result[] = $stmt->fetch(PDO::FETCH_ASSOC)){//1ページの中でFETCHは一回しか使えない
    $json=json_encode($result);

    // $view .= "<div>";//段落 見やすいように
    //   $view .= '<a href="u_view.php?id='.$result["id"].'">';//入力したデータにリンクを付ける
    //   $view .= $result["id"];//表示するカラム設定
    //   $view .= $result["title"];
      // $view .= $result["url"]."<br>"."<br>";
      // $view .= $result["lat"]."<br>"."<br>";
      // $view .= $result["lon"]."<br>"."<br>";
      // $view .= $result["date"];
    //   $view .= '</a>';
    //   $view .= ' ';
    //   $view .= '<a href="delete.php?id='.$result["id"].'">';
    //   $view .= '[削除]';
    //   $view .= '</a>';
    // $view .= "</div>";
  }
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>フリーアンケート表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">データ登録</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- MAP[Start] -->
<div id="myMap" style='width:100%;height:700px;'></div>
<!-- MAP[END] -->

<!-- Main[Start] -->
<div>
    <div class="container jumbotron" id="love"><?=$view?></div>
</div>
<!-- Main[End] -->

<script src='https://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=ArY_mxvAiQt0FDVzpN0zIoGx5kkg17g06xPorZnTje5AefU5IhGSVERyhkSRfpUo'async defer></script>
<script src="js/BmapQuery.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
let map;
function GetMap() {
    //------------------------------------------------------------------------
    //1. Instance
    //------------------------------------------------------------------------
    map = new Bmap("#myMap");
    //2. Display Map
    //   startMap(lat, lon, "MapType", Zoom[1~20]);MapType:[load, aerial,canvasDark,canvasLight,birdseye,grayscale,streetside]
    //--------------------------------------------------
    map.startMap(43.0611335, 141.3563703, "aerial", 15);

    //3.DB情報
    const json = JSON.parse('<?=$json?>')
    console.log(json);
  

    const len = json.length;
    console.log("データの個数" + len);
    const options = [];
    for (let i = 0; i < len; i++){
      options[i] = {
        "lat": json[i].lat,
        "lon": json[i].lon,
        "title": json[i].title,
        "address": json[i].address,
        "pinColor": "#ff0000",
        "height": 400,
        "width": 600,
        //"description": "<div><img src='"+json[i].*******+"'></div>",
        "description": "<div><a href='"+json[i].url+"'>LINK</a></div>",
        //"description":"<a href='+json[i].url+'>LINK</a>"
        "show": false
    };
    };
    map.infoboxLayers(options, true);

}
/*****************************
配列と反復処理の応用
*****************************/
//1. 配列を作成
//const a=["**","**","**","****","**","**","**","**","**"];
const json = JSON.parse('<?=$json?>')
//2. 変数の入れ物を作成
//let b="";
let taijun="";
//let c=a.length;//戸数自動取得用に変数作成
let hirotani=json.length;
//console.log(c);//コンソールで回数を確認
console.log(hirotani);
//3. 繰り返し処理で、文字列と配列を組み合わせ
//for(let i=0; i<c/*回数を自動取得*/; i++){
for(let i=0; i<hirotani/*回数を自動取得*/; i++){
    //girlfriend+=`<option>${a[i]}********</option>`;
    taijun+=`<p>${json[i].title+' '+json[i].address+' '+json[i].lat+json[i].lon}</p>`;
    // taijun+=`<p>${json[i].address}</p>`;
    // taijun+=`<p>${json[i].lat}</p>`;
    // taijun+=`<p>${json[i].lon}</p>`;
}
//3.表示先
$("#love").html(taijun);

</script>

</body>
</html>
