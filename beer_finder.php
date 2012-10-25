<? 
$title = "Beer Finder!"; 
?>
<?php include("header.php"); ?>        
<script type='text/javascript' src='picnet.table.filter.min.js'></script>  
<style type="text/css">
.c1Head {width:200px; margin:0; padding:0; text-align:center}
.c2Head {width:250px; margin:0; padding:0; text-align:center}
.c1 {width:200px; font-weight:bold; vertical-align:top; margin:0; padding:5px; color:#e79b2f}
.c2 {vertical-align:top; margin:0; padding:5px}
#demotable1 {background:none; color:white}
.selectStyle select {
	padding:2px; -webkit-appearance: none;  
	color:#fff; width:210px; outline:none; border: none;  background: url("arrowR.gif") no-repeat scroll 147px 1px #833101; -webkit-tap-highlight-color: rgba(0,0,0,0)
}
.selectStyle { background:#833101; width:178px; margin:0 0 20px 150px; overflow:hidden; border: dotted 2px #a95f32; -webkit-border-radius: 10px; -moz-border-radius: 10px; text-align:left}
#filter_1 { visibility:hidden; display:none}
#beerSearch { position:relative; min-height:300px; _height:300px; text-align:left}
</style>
<script type='text/javascript'>
      $(document).ready(function() {
            // Initialise Plugin
			$('#demotable1').tableFilter();
      });
</script>
<div class="sideText">
<h1>Beer Finder!</h1>
<p>Use the beer finder to find your favorite beer at different restaurants and bars in Chattanooga.</p>
<p>Select the Beer in the drop down and scroll to find all the places that have that beer. You can also check out our <a href="beer_styles.php">Beer Styles</a> page for descriptions of all the different beers that we brew.</p>
<div class="selectStyle">
<select id="beerSel">
    <option value="clear">Pick a Beer!</option>
  	<option>Chickbock</option>
    <option>Kolsch</option>
    <option>Hill City Pale Ale</option>
    <option>Two Taverns Pale Ale</option>
    <option>Imperial Pilsner</option>
    <option>Hill City Black Lager</option>
    <option>Hill City IPA</option>
    <option>Hill City Stout</option>
    <option>Pale Pleasure</option>
  	<option>Stone Cup Coffee Stout</option>
  	<option>Winter Warmer</option>
    <option value="">All CBC Beers</option>
</select>
</div>
<div id="beerSearch" style="width:450px;">
      <table id="demotable1">
        <thead>
          <tr><th class="c1Head" filter='false'>Location</th><th class="c2Head">Beer</th></tr>
        </thead>
        <tbody>
<?PHP
$file_handle = fopen("ChattBrewingCo.beersatlocations2.csv", "r");
	$row = 1;
	while (!feof($file_handle) ) {
		$line_of_text = fgetcsv($file_handle, 1024);
		print "<tr><td class='c1'>" . $line_of_text[7] . "</td><td class='c2'>" . $line_of_text[1]. "</td></tr>";
	}
fclose($file_handle);
?>
        </tbody>
      </table>
        </div>
</div>

<div style="width:625px; font-family:Arial, sans-serif; font-size:11px; border:0; background:#FFF; margin:-60px 0 125px 235px">
  <table id="cm_mapTABLE"> <tbody> <tr id="cm_mapTR">

    <td> <div id="cm_map" style="width:450px; height:450px"></div> </td>
  </tr> </tbody></table>
</div>

<script src="http://maps.google.com/maps?file=api&v=2&key=ABQIAAAA60hgtFwo751aO_nfXXU9cxSyk8FgJgho5Js_fJS0S2Y6-GC8ZhSsG_MOUL4oUjd3qwUcSlcnRW5qXw" 
  type="text/javascript"></script>

<script type="text/javascript">
//<![CDATA[
var cm_map;
var cm_mapMarkers = [];
var cm_mapHTMLS = [];

// Create a base icon for all of our markers that specifies the
// shadow, icon dimensions, etc.
var cm_baseIcon = new GIcon();
cm_baseIcon.shadow = "http://www.google.com/mapfiles/shadow50.png";
cm_baseIcon.iconSize = new GSize(20, 34);
cm_baseIcon.shadowSize = new GSize(37, 34);
cm_baseIcon.iconAnchor = new GPoint(9, 34);
cm_baseIcon.infoWindowAnchor = new GPoint(9, 2);
cm_baseIcon.infoShadowAnchor = new GPoint(18, 25);

// Change these parameters to customize map
var param_wsId = "od6";
var param_ssKey = "0Aqi3yjbftoLDdGtuTklGcmhfaFdZcjhhZ0tOS013Q0E";
var param_useSidebar = true;
var param_titleColumn = "location";
var param_descriptionColumn = "description";
var param_latColumn = "latitude";
var param_lngColumn = "longitude";
var param_rankColumn = "rank";
var param_iconType = "green";
var param_iconOverType = "orange";

/**
 * Loads map and calls function to load in worksheet data.
 */
function cm_load() {  
  if (GBrowserIsCompatible()) {
    // create the map
    cm_map = new GMap2(document.getElementById("cm_map"));
    cm_map.addControl(new GLargeMapControl());
    cm_map.addControl(new GMapTypeControl());
    cm_map.setCenter(new GLatLng( 43.907787,-79.359741), 2);
    cm_getJSON();
  } else {
    alert("Sorry, the Google Maps API is not compatible with this browser");
  } 
}

/**
 * Function called when marker on the map is clicked.
 * Opens an info window (bubble) above the marker.
 * @param {Number} markerNum Number of marker in global array
 */
function cm_markerClicked(markerNum) {
  cm_mapMarkers[markerNum].openInfoWindowHtml(cm_mapHTMLS[markerNum]);
}

/**
 * Function that sorts 2 worksheet rows from JSON feed
 * based on their rank column. Only called if column is defined.
 * @param {rowA} Object Represents row in JSON feed
 * @param {rowB} Object Represents row in JSON feed
 * @return {Number} Difference between row values
 */
function cm_sortRows(rowA, rowB) {
  var rowAValue = parseFloat(rowA["gsx$" + param_rankColumn].$t);
  var rowBValue = parseFloat(rowB["gsx$" + param_rankColumn].$t);

  return rowAValue - rowBValue;
}

/** 
 * Called when JSON is loaded. Creates sidebar if param_sideBar is true.
 * Sorts rows if param_rankColumn is valid column. Iterates through worksheet rows, 
 * creating marker and sidebar entries for each row.
 * @param {JSON} json Worksheet feed
 */       
function cm_loadMapJSON(json) {
  var usingRank = false;

  if(param_useSidebar == true) {
    var sidebarTD = document.createElement("td");
    sidebarTD.setAttribute("width","250");
    sidebarTD.setAttribute("valign","top");
    var sidebarDIV = document.createElement("div");
    sidebarDIV.id = "cm_sidebarDIV";
    sidebarDIV.style.overflow = "auto";
    sidebarDIV.style.height = "450px";
    sidebarDIV.style.fontSize = "11px";
    sidebarDIV.style.color = "#000000";
    sidebarTD.appendChild(sidebarDIV);
    document.getElementById("cm_mapTR").appendChild(sidebarTD);
  }

  var bounds = new GLatLngBounds();	  

  if(json.feed.entry[0]["gsx$" + param_rankColumn]) {
    usingRank = true;
    json.feed.entry.sort(cm_sortRows);
  }

  for (var i = 0; i < json.feed.entry.length; i++) {
    var entry = json.feed.entry[i];
    if(entry["gsx$" + param_latColumn]) {
      var lat = parseFloat(entry["gsx$" + param_latColumn].$t);
      var lng = parseFloat(entry["gsx$" + param_lngColumn].$t);
      var point = new GLatLng(lat,lng);
      var html = "<div style='font-size:12px'>";
      html += "<strong>" + entry["gsx$"+param_titleColumn].$t 
              + "</strong>";
      var label = entry["gsx$"+param_titleColumn].$t;
      var rank = 0;
      if(usingRank && entry["gsx$" + param_rankColumn]) {
        rank = parseInt(entry["gsx$"+param_rankColumn].$t);
      }
      if(entry["gsx$" + param_descriptionColumn]) {
        html += "<br/>" + entry["gsx$"+param_descriptionColumn].$t;
      }
      html += "</div>";

      // create the marker
      var marker = cm_createMarker(point,label,html,rank);
      cm_map.addOverlay(marker);
      cm_mapMarkers.push(marker);
      cm_mapHTMLS.push(html);
      bounds.extend(point);
	  
      if(param_useSidebar == true) {
        var markerA = document.createElement("a");
        markerA.setAttribute("href","javascript:cm_markerClicked('" + i +"')");
        markerA.style.color = "#000000";
        var sidebarText= "";
        if(usingRank) {
          sidebarText += rank + ") ";
        } 
        sidebarText += label;
        markerA.appendChild(document.createTextNode(sidebarText));
        sidebarDIV.appendChild(markerA);
        sidebarDIV.appendChild(document.createElement("br"));
      } 
    }
  }

  cm_map.setZoom(cm_map.getBoundsZoomLevel(bounds));
  cm_map.setCenter(bounds.getCenter());
}

/**
 * Creates marker with ranked Icon or blank icon,
 * depending if rank is defined. Assigns onclick function.
 * @param {GLatLng} point Point to create marker at
 * @param {String} title Tooltip title to display for marker
 * @param {String} html HTML to display in InfoWindow
 * @param {Number} rank Number rank of marker, used in creating icon
 * @return {GMarker} Marker created
 */
function cm_createMarker(point, title, html, rank) {
  var markerOpts = {};
  var nIcon = new GIcon(cm_baseIcon);

  if(rank > 0 && rank < 100) {
    nIcon.imageOut = "http://gmaps-samples.googlecode.com/svn/trunk/" +
        "markers/" + param_iconType + "/marker" + rank + ".png";
    nIcon.imageOver = "http://gmaps-samples.googlecode.com/svn/trunk/" +
        "markers/" + param_iconOverType + "/marker" + rank + ".png";
    nIcon.image = nIcon.imageOut; 
  } else { 
    nIcon.imageOut = "http://gmaps-samples.googlecode.com/svn/trunk/" +
        "markers/" + param_iconType + "/blank.png";
    nIcon.imageOver = "http://gmaps-samples.googlecode.com/svn/trunk/" +
        "markers/" + param_iconOverType + "/blank.png";
    nIcon.image = nIcon.imageOut;
  }

  markerOpts.icon = nIcon;
  markerOpts.title = title;		 
  var marker = new GMarker(point, markerOpts);
	
  GEvent.addListener(marker, "click", function() {
    marker.openInfoWindowHtml(html);
  });
  GEvent.addListener(marker, "mouseover", function() {
    marker.setImage(marker.getIcon().imageOver);
  });
  GEvent.addListener(marker, "mouseout", function() {
    marker.setImage(marker.getIcon().imageOut);
  });
  GEvent.addListener(marker, "infowindowopen", function() {
    marker.setImage(marker.getIcon().imageOver);
  });
  GEvent.addListener(marker, "infowindowclose", function() {
    marker.setImage(marker.getIcon().imageOut);
  });
  return marker;
}

/**
 * Creates a script tag in the page that loads in the 
 * JSON feed for the specified key/ID. 
 * Once loaded, it calls cm_loadMapJSON.
 */
function cm_getJSON() {

  // Retrieve the JSON feed.
  var script = document.createElement('script');

  script.setAttribute('src', 'http://spreadsheets.google.com/feeds/list'
                         + '/' + param_ssKey + '/' + param_wsId + '/public/values' +
                        '?alt=json-in-script&callback=cm_loadMapJSON');
  script.setAttribute('id', 'jsonScript');
  script.setAttribute('type', 'text/javascript');
  document.documentElement.firstChild.appendChild(script);
}

setTimeout('cm_load()', 500); 

//]]>

</script>

<script>
    function displayVals() {
      var beerSelValues = $("#beerSel").val();
	  $("input").val(beerSelValues);
	  $('#demotable1').tableFilterRefresh();
    }
    $("select").change(displayVals);
    displayVals();
</script>
</div>
<?php include("footer.php"); ?>