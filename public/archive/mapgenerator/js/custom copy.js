//default values
var uri = 'http://maps.googleapis.com/maps/api/staticmap?';
var AND = '&';
var zoomA = '11';
var zoomB = '15';
var scale = '2';
var size = '640x360';
var maptype = 'roadmap';
var format = 'jpg';
var visual_refresh = 'false';
var micon = 'http://dl.dropboxusercontent.com/u/691052/icon/marker_googlemaps_75.png';
var shadow = 'true';
var tempAddress = 'Bosdammen 2, Amerzoden';
var n = tempAddress.indexOf(',');
var street = tempAddress.substring(0, n != -1 ? n : tempAddress.length);


//uselater





$('#address').keydown(function(e) {
    if (e.keyCode == 13) {
        $('#search').click();
    }
});

function GenerateurlA(){
  var address = tempAddress.replace(/ /g,"+");
  var url = uri +
          'zoom=' + zoomA +
          '&scale=' +scale +
          '&size=' + size +
          '&maptype=' + maptype +
          '&format=' + format +
          '&visual_refresh=' + visual_refresh +
          '&markers=scale:2|icon:' + micon +
          '%7Cshadow:' + shadow +
          '%7C' + tempAddress.replace(/ /g,"+");
  return url;
}

function GenerateurlB(){
  var address = tempAddress.replace(/ /g,"+");
  var url = uri +
          'zoom=' + zoomB +
          '&scale=' +scale +
          '&size=' + size +
          '&maptype=' + maptype +
          '&format=' + format +
          '&visual_refresh=' + visual_refresh +
          '&markers=scale:2|icon:' + micon +
          '%7Cshadow:' + shadow +
          '%7C' + tempAddress.replace(/ /g,"+");

  return url;
}
/*$("#imgADownload").click(function(){
  var url = this.href.replace(/^data:image\/[^;]/, 'data:application/octet-stream');
  console.log(this);
  window.open(url);
});*/

function refreshImgs(paramA, paramB){
  $("#imageA").attr('src',paramA );
  $("#imgADownload").attr('href',paramA );
  $("#imageB").attr('src',paramB );
  $("#imgBDownload").attr('href',paramB );
}
$("#zoomInA").click(function(){
  zoomA = Number(zoomA) +1;
  var x = GenerateurlA();
  $("#imageA").attr('src',x);
  $("#imgADownload").attr('href',x );
});

$("#zoomOutA").click(function(){
  zoomA = Number(zoomA) -1;
  var x = GenerateurlA();
  $("#imageA").attr('src',x);
  $("#imgADownload").attr('href',x );
});

$("#zoomInB").click(function(){
  zoomB = Number(zoomB) +1;
  var x = GenerateurlB();
  $("#imageB").attr('src',x);
  $("#imgBDownload").attr('href',x );
});

$("#zoomOutB").click(function(){
  zoomB = Number(zoomB) -1;
  var x = GenerateurlB();
  $("#imageB").attr('src',x);
  $("#imgBDownload").attr('href',x );
});

$("#search").click(function(){
var temp = $("#address").val();
if(temp == ""){
alert("Please Enter the Address");
}
else{
  tempAddress = temp;
  var GurlA = GenerateurlA();
  var GurlB = GenerateurlB();
  refreshImgs(GurlA, GurlB);
  $("#maps").css('visibility','visible');
}

});
