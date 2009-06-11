<?php

if(isset($_GET['adresse']))
	$adresse = $_GET['adresse'];
else
	$adresse = 'france';

if(isset($_GET['id']))
	$id = $_GET['id'];
else
	$id = 1;

if(isset($_GET['zoom']))
	$zoom = $_GET['zoom'];
else
	$zoom = 1;
	
?>

<!DOCTYPE html "-//W3C//DTD XHTML 1.0 Strict//EN" 
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Google Maps JavaScript API Example</title>
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=abcdefg&sensor=true_or_false"
            type="text/javascript"></script>
    <script type="text/javascript">
	var map;
	var geocoder;
	var adresse = <?php echo "\"".$adresse."\""; ?>;
	var id = <?php echo $id; ?>;
	var zoom = <?php echo $zoom; ?>;
	
    function initialize() {
      if (GBrowserIsCompatible()) {
        map = new GMap2(document.getElementById("map_canvas"));
        geocoder = new GClientGeocoder();
 		showAddress(adresse,id);       
        map.setUIToDefault();
      }
    }

	function showAddress(address, id) {
	  if (geocoder) {
		  var lat;
		  var lng;
		geocoder.getLatLng(
		  address,
		  function(point) {
			if (!point) {
			  alert(address + " not found");
			  document.getElementById('err').innerHTML += " pas trouvée";
			} else {
			  lat = point.lat();
			  lng = point.lng();
			  GetMarker(lat,lng,id)
			}
		  }
		);
		
	  }
	}

	function ReverceGeocoding(lat, lng){
		latlng = new GLatLng(lat, lng);
		geocoder.getLocations(latlng, function(addresses) {
		  //alert(lat+", "+lng+" "+latlng.toUrlValue());
		  if(addresses.Status.code != 200) {
		    alert("impossible de trouver l'adresse de la geolocalisation : " + latlng.toUrlValue());
		  } else { 
		    var result = addresses.Placemark[0];
		    if(document.getElementById('formAdresse'))
				document.getElementById('formAdresse').value = result.address;
		  }
		});
	
	}

	function GetMarker(lat, lng, id){

		var point = new GLatLng(lat,lng);
		var marker = new GMarker(point, {draggable: true});
		map.addOverlay(marker);
		//contenu admin
		contenu_topic = '<form name="marker" ><table >';
		contenu_topic += '<tr><td><input type="hidden" name="id" value="' + id + '" /></td></tr>';
		contenu_topic += '<tr><td>Lat : <input type="text" name="lat" value="' + point.lat() + '" /></td></tr>';
		contenu_topic += '<tr><td>Lng : <input type="text" name="lng" value="' + point.lng() + '" /></td></tr>';
		contenu_topic += '<tr><td>zoom : <input type="text" name="zoommin" value="' + zoom + '" /></td></tr>';
		contenu_topic += '<tr><td>Type : <input type="text" name="type" value="" /></td></tr>';
		contenu_topic += '<tr><td>Adresse : <input id="formAdresse" type="text" name="adresse" value="' + adresse + '" /></td></tr>';
		contenu_topic += '<tr><td><input type="button" name="Submit" value="Executer" onclick="SauveMarker(' + id + ')" />';
		contenu_topic +="<tr><td><input type='button' name='GL' value='Geolocaliser' onclick=\"showAddress(window.document.marker.adresse.value," + id + ")\" />";
		contenu_topic += '</tr></table></form>';
		//GESTION DU DRAG & DROP
		GEvent.addListener(marker, "dragstart", function() {
		  map.closeInfoWindow();
		  });
		GEvent.addListener(marker, "dragend", function() {
		  marker.openInfoWindowHtml(contenu_topic);
		  p = marker.getPoint();
		  window.document.forms["marker"].lat.value=p.lat();
		  window.document.forms["marker"].lng.value=p.lng();
		  window.document.forms["marker"].zoommin.value=map.getZoom();
		  window.document.forms["marker"].type.value=map.getCurrentMapType().getName();
		  ReverceGeocoding(p.lat(), p.lng());
		  });		
		map.setCenter(new GLatLng(lat, lng), zoom);
	}
	
    </script>
  </head>
  <body onload="initialize()" onunload="GUnload()">
    <div id="map_canvas" style="width: 500px; height: 300px"></div>
    <div id="err" ></div>
    <div id="formAdresse" ></div>
  </body>
</html>