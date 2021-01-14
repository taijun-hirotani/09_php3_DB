<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>データ登録</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="POST" action="insert.php">
  <div class="jumbotron">
   <fieldset>
    <legend>フリーアンケート</legend>
     <label>名前：<input type="text" name="title"></label><br>
     <label>住所：<input type="text" name="address"></label><br>
     <label>緯度：<input type="text" name="lat"></label><br>
     <label>経度：<input type="text" name="lon"></label><br>
     <label>url：<input type="text" name="url"></label><br>
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


<!-- MAP[Start] -->
<div id="geocode">geocode:data</div>
<div id="geocode2">Reversegeocode:data</div>
<div id="myMap" style='width:100%;height:700px;'></div>
<!-- MAP[END] -->

<script src='https://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=ArY_mxvAiQt0FDVzpN0zIoGx5kkg17g06xPorZnTje5AefU5IhGSVERyhkSRfpUo'async defer></script>
<script src="js/BmapQuery.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
let map;
function GetMap() {

  //1. Instance

    map = new Bmap("#myMap");

    //2. Display Map
    map.startMap(43.0611335, 141.3563703, "aerial", 15);

    //3. Geocode(2 patterns)
    let lat;
    let lon;
    //B.Get geocode of click location
    map.onGeocode("click", function (data2) {
    lat = data2.location.latitude; //Get latitude
    lon = data2.location.longitude; //Get longitude
    document.querySelector("#geocode").innerHTML =  lat + '<br>' + lon;
    });

    //----------------------------------------------------
    //3. Get ReverseGeocode(2 patterns)
    //   reverseGeocode(location,callback);
    //----------------------------------------------------
    
    //A. Set location data for BingMaps
    //const location = map.getCenter(); //MapCenter
    map.reverseGeocode(location, function(data){
        console.log(data);
        document.querySelector("#geocode2").innerHTML=data;
    });
    
    //B. Get ReverseGeocode of click location
    map.onGeocode("click", function(clickPoint){
        map.reverseGeocode(clickPoint.location, function(data){
            console.log(data);
            document.querySelector("#geocode2").innerHTML=data;
        });
    });
    

  }



</script>


</body>
</html>
