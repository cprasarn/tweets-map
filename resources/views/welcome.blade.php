<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tweets on Google Map</title>
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
      #panel {
        position: absolute;
        bottom: 5px;
        left: 50%;
        margin-left: -180px;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
      }
      div.row {
        border:1px solid #ccc;
        padding:5px;
        width:240px;
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>

    <script>
// The markers are stored in an array.
var map;
var markers = [];

function initialize() {
  var lat = 13.7563309;
  var lng = 100.5017651;
  var bangkok = new google.maps.LatLng(lat, lng);
  var mapOptions = {
    zoom: 12,
    center: bangkok,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

  // Adds a marker at the center of the map.
  addMarker(bangkok, 'Bangkok, Thailand');

  // Show tweets
  showTwitters('bangkok', lat, lng, '50km');
}

// Add a marker to the map and push to the array.
function addMarker(location, title) {
  var marker = new google.maps.Marker({
    position: location,
    title: title,
    map: map
  });
  markers.push(marker);

  var infowindow = new google.maps.InfoWindow({
      content: title
  });
  google.maps.event.addListener(marker, 'click', function() {
    infowindow.open(map,marker);
  });
}

// Sets the map on all markers in the array.
function setAllMap(map) {
  for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(map);
  }
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
  setAllMap(null);
}

// Shows any markers currently in the array.
function showMarkers() {
  setAllMap(map);
}

// Deletes all markers in the array by removing references to them.
function deleteMarkers() {
  clearMarkers();
  markers = [];
}

google.maps.event.addDomListener(window, 'load', initialize);

function showTwitters(city, lat, lng, radius) {
  $.ajax({
    type: 'GET',
    dataType: 'text',
    data: {
      city: city,
      lat: lat,
      lng: lng,
      radius: radius
    },
    url: "http://localhost:8000/twitters",
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(jqXHR);
    },
    success: function (msg) {
      var response = JSON.parse(msg);
      console.log({r: response});

      var list = response.data.statuses;
      var g, l, t;
      for (var i=0; i < list.length; i++) {
        g = list[i].geo;
        if (null == g || undefined == g) continue;

        // Add marker
        console.log(i + ' => ' + g.coordinates[0] + ', ' + g.coordinates[1]);
        l = new google.maps.LatLng(g.coordinates[0], g.coordinates[1]);
        d = new Date(list[i].created_at);
        t = "Tweet: " + list[i].text;
        t += "\r\nWhen:" + d.toLocaleString();
        addMarker(l, t);
      }
    }
  });
}

function showMap(city) {
  city = (city) ? city : $('input[name="city"]').val();
  if (! city) city = 'bangkok';

  $('#map-canvas').show();
  $('#map-canvas').css('display', 'block');

  $('#panel').show();
  $('#panel').css('display', 'block');

  $('#history').hide();
  $('#history').css('display', 'none');

  $.ajax({
    url: "http://maps.google.com/maps/api/geocode/json?sensor=false&address=" + city,
    cache: true,
  }).done(function(data) {
    var city_location = data['results'][0]['geometry']['location'];
    var lat = city_location['lat'];
    var lng = city_location['lng'];
    var city_marker = new google.maps.LatLng(lat, lng);
    var mapOptions = {
      zoom: 12,
      center: city_marker,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
    addMarker(city_marker, city);
    showTwitters(city, lat, lng, '50km');
  });
}

function showHistories() {
  $.ajax({
    type: 'GET',
    dataType: 'text',
    data: {},
    url: "http://localhost:8000/histories",
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(jqXHR);
    },
    success: function (msg) {
      var response = JSON.parse(msg);
      console.log({r: response});

      var html = '<div class="row">';
      html += '<a href="#" onclick="showMap();">Go Back to Tweets</a>';
      html += '</div>';

      var list = response.data;
      for (var i=0; i < list.length; i++) {
          html += '<div class="row">';
          html += '<a href="#" onclick="showMap(\'' + list[i].city + '\')">' + list[i].city + '</a>';
          html += '</div>';
      }

      $('#map-canvas').hide();
      $('#panel').hide();
      $('#history').show();
      $('#history').css('display', 'block');
      $('#history').html(html);
    }
  });
}
    </script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div id="map-canvas"></div>
    <div id="panel">
      <input type="text" name="city" width="240px">
      <input onclick="showMap();" type=button value="Search">
      <input onclick="showHistories();" type=button value="History">
    </div>
    <div id="history"></div>
  </body>
</html>
