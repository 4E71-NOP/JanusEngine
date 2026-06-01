<?php
// // @JanusEngine:license-start
// --------------------------------------------------------------------------------------------
// Janus Engine 
//
// This file file is part of the Janus-Engine project.
// @see       : https://github.com/4E71-NOP/JanusEngine
//
// @license   : Creative Commons licence CC-by-nc-sa (https://creativecommons.org/licenses/by-nc-sa/4.0/)
// @author    : Faust MARIA DE AREVALO (original founder) <faust@rootwave.com>
// @copyright : 2005 - ∞ Faust MARIA DE AREVALO
//
// @note      : This program is distributed in the hope that it will be useful - WITHOUT ANY WARRANTY; 
//              without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
//
// Check README.md for more details
// --------------------------------------------------------------------------------------------
// @JanusEngine:license-end


$baseUrl  = "http" . (isset($_SERVER['HTTPS']) ? "s" : "") . "://" . $_SERVER['HTTP_HOST'] . "/";
$broswerList = array(
	1 => array(
		"name" => "Brave",
		"logo" => "/media/_staticPages/LogoBrave.png",
		"url" => "https://brave.com/download/"
	),
	2 => array(
		"name" => "Chrome",
		"logo" => $baseUrl . "/media/_staticPages/LogoGoogleChrome.svg",
		"url" => "https://www.google.com/chrome/"
	),
	3 => array(
		"name" => "Edge",
		"logo" => $baseUrl . "/media/_staticPages/LogoMicrosoftEdgeChromium.svg",
		"url" => "https://www.microsoft.com/fr-fr/windows/microsoft-edge"
	),
	4 => array(
		"name" => "Firefox",
		"logo" => $baseUrl . "/media/_staticPages/LogoMozillaFirefox.svg",
		"url" => "https://www.mozilla.org/fr/firefox/new/"
	),
	5 => array(
		"name" => "Opera",
		"logo" => $baseUrl . "/media/_staticPages/LogoOpera.svg",
		"url" => "http://www.opera.com/"
	),
	6 => array(
		"name" => "Safari",
		"logo" => $baseUrl . "/media/_staticPages/LogoSafari.png",
		"url" => "https://www.apple.com/safari/"
	),
	7 => array(
		"name" => "Tor",
		"logo" => $baseUrl . "/media/_staticPages/LogoTor.svg",
		"url" => "https://www.torproject.org/download/"
	),
	8 => array(
		"name" => "Vivaldi",
		"logo" => $baseUrl . "/media/_staticPages/LogoVivaldi.svg",
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
width: 100%; height: 100%; 
background-image: url(" . $baseUrl . "/media/_staticPages/bg.svg);
background-position: center; 
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
$LimitPerLine = 4;
$CountPerLine = 0;
foreach ($broswerList as $A) {

	$CountPerLine++;
	if ($CountPerLine > $LimitPerLine ) {
		$Content .= "</tr>\r<tr>";
		$CountPerLine = 1;
	}
	$Content .= 
		"<td>\r"
		. "<table>\r<tr>\r<td>\r"
		. "<div style='
			padding: 15px; margin-bottom: 30px;
			text-align: center; 
			border-radius: 100%; 
			background-color: #FFFFFF; border: solid 2px #404040;
			box-shadow: 0px 20px 10px #00000080;'>\r"
		. "<a style='color: #FFFFFF;' href='" . $A['url'] . "'>\r"
		. "<img style='width:128px; height:128px;' src='" . $A['logo'] . "'>"
		. "</a>\r"
		. "</div>\r"
		. "</td>\r</tr>\r"

		
		. "<tr>\r<td style='width: 96px; text-align:center; font-weight: bold; font-size: 20px;'>\r"
		. "<a style='color: #FFFFFF;' href='" . $A['url'] . "'><div style='width:100%; padding:10px; background-color:#FFFFFF80; border-radius:10px'>" . $A['name'] . "</div></a>\r"
		. "</td>\r</tr>\r"

		. "</table>\r"
		. "</td>\r";
}

$Content .= "</tr>\r<tr>\r";

$Content .= "</tr>\r
</table>\r

</div>\r

</body>\r
</html>\r
";
echo ($Content);
exit();
