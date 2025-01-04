<?php
/*JanusEngine-license-start*/
// --------------------------------------------------------------------------------------------
//
//	Janus Engine - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*JanusEngine-license-end*/
// ../media/IE6_redirect/fond.jpg

$baseUrl  = "http" . (isset($_SERVER['HTTPS']) ? "s" : "") . "://" . $_SERVER['HTTP_HOST'] . "/";
$broswerList = array(
	1 => array(
		"name" => "Brave",
		"logo" => "/media/_staticPages/LogoBrave.png",
		"url" => "https://brave.com/download/"
	),
	2 => array(
		"name" => "Chrome",
		"logo" => $baseUrl . "/media/_staticPages/LogoGoogleChrome.png",
		"url" => "https://www.google.com/chrome/"
	),
	3 => array(
		"name" => "Edge",
		"logo" => $baseUrl . "/media/_staticPages/LogoMicrosoftEdgeChromium.png",
		"url" => "https://www.microsoft.com/fr-fr/windows/microsoft-edge"
	),
	4 => array(
		"name" => "Firefox",
		"logo" => $baseUrl . "/media/_staticPages/LogoMozillaFirefox.png",
		"url" => "https://www.mozilla.org/fr/firefox/new/"
	),
	5 => array(
		"name" => "Opera",
		"logo" => $baseUrl . "/media/_staticPages/LogoOpera.png",
		"url" => "http://www.opera.com/"
	),
	6 => array(
		"name" => "Safari",
		"logo" => $baseUrl . "/media/_staticPages/LogoSafari.png",
		"url" => "https://www.apple.com/safari/"
	),
	7 => array(
		"name" => "Tor",
		"logo" => $baseUrl . "/media/_staticPages/LogoTor.png",
		"url" => "https://www.torproject.org/download/"
	),
	8 => array(
		"name" => "Vivaldi",
		"logo" => $baseUrl . "/media/_staticPages/LogoVivaldi.png",
		"url" => "https://vivaldi.com/en/download/"
	)
);


$Content = "<html>\r
<body 
style='
background-color: #000000;
color: #FFFFFF;
font-family: Arial,Helvetica,sans-serif;
font-size: 24px;
padding: 0;
text-align: center;
'>\r

<div style='
width: 100%; height: 768px; 
background-image: url(" . $baseUrl . "/media/_staticPages/bg.jpg); 
background-repeat: repeat;
margin-left: auto; 
margin-right: auto;
text-align: center;
'>\r


<table style='
margin-left: auto; 
margin-right: auto;
'>\r
<tr>\r
<td style='text-align:left;'>Eng:</td>\r
<td style='text-align:left;'>Internet Explorer isn't supported anymore. You should use another browser. Here are some options</td>\r
</tr>\r
<tr>\r
<td style='text-align:left;'>Fra:</td>\r
<td style='text-align:left;'>Internet Explorer n'est plus supporté. Vous devriez utiliser un autre navigateur. Voici quelques options</td>\r
</tr>\r
</table>\r

<table style='
margin-left: auto; 
margin-right: auto;
margin-top: 256px; 
margin-bottom: auto;
border-spacing: 32px;
'>\r
<tr>\r";

foreach ($broswerList as $A) {
	$Content .= "<td>\r"
		. "<div style='
			padding: 15px; border-radius: 100%; text-align: center; 
			background-color: #FFFFFF; border: solid 2px #404040;
			box-shadow: 0px 20px 10px #000000FF;'>\r"
		. "<a style='color: #FFFFFF;' href='" . $A['url'] . "'>\r"
		. "<img style='width:64px; height:64px;' src='" . $A['logo'] . "'>"
		. "</a>\r"
		. "</div>\r"
		. "</td>\r";
}

$Content .= "</tr>\r<tr>\r";

reset($broswerList);
foreach ($broswerList as $A) {
	$Content .= "<td style='width: 96px; text-align:center; font-weight: bold; font-size: 20px;'>\r"
		. "<a style='color: #FFFFFF;' href='" . $A['url'] . "'>" . $A['name'] . "</a>\r"
		. "</td>\r";
}

$Content .= "</tr>\r
</table>\r

</div>\r

</body>\r
</html>\r
";
echo ($Content);
exit();
