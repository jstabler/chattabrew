<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><? echo "$title"; ?> - Chattanooga Brewing Company - Chattanooga, TN</title>
<meta name="description" content="Chattanooga Brewing Co. returned to the local beer scene in 2010, they have brought back Imperial Pilsner and many other tasty brews. Many German, English, and American styles are featured throughout the year." />
<link rel="shortcut icon" href="favicon.png" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script type="text/javascript">
function switchTo(i) {
  $('#glasses div').css('margin-top','-5px').eq(i).css('margin-top','-25px');
  $('#barText div').css('display','none').eq(i).css('display','block');
}
$(document).ready(function(){
    $('#glasses a').removeAttr("href");
    $('#glasses div').mousedown(function(event){
    switchTo($('#glasses div').index(event.target));
  });
  switchTo(0);
});
</script>
<link href='http://fonts.googleapis.com/css?family=Waiting+for+the+Sunrise&v2' rel='stylesheet' type='text/css'>
<link href='site.css?v=1.92' rel='stylesheet' type='text/css'>
<!--[if IE]>
<link href='iefix.css' rel='stylesheet' type='text/css'>
<![endif]-->
<!--[if lte IE 7]>
<style type="text/css">
.selectStyle select {
	padding:0; color:#000; width:200px; outline:none; border: none;  background: none;
}
.selectStyle { background:#none; width:200px; margin:0 0 20px 150px; overflow:hidden; border: none}
</style>
<![endif]-->
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-25379313-1']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
</head>
<body>
<div id="omega">
<div id="logo"></div>
<div id="menu">
  <ul>
    <li id="one"><a href="http://www.chattabrew.com">Home</a></li>
    <li id="two"><a href="photos.php">Photos</a></li>
    <li id="three"><a href="local_connections.php">Local Connections</a></li>
    <li id="four"><a href="beer_finder.php">Beer Finder!</a></li>
    <li id="six"><a href="events.php">Events</a></li>
    <li id="five"><a href="contact_us.php">Contact Us</a></li>
    
  </ul>
</div>
<div id="bigBeer"></div>
<br />
<h2 id="address">
109 Frazier Avenue<br />
  Chattanooga, TN 37405<br /><br />
(423)702-9958
</h2>
<br />