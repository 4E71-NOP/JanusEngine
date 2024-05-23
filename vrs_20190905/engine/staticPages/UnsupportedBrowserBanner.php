<?php
 /*Hydre-licence-debut*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/
// ../media/IE6_redirect/fond.jpg

$lc = "<a style='color: #FFFFFF;' target='new' href='https://www.google.com/chrome/'>";
$lf = "<a style='color: #FFFFFF;' target='new' href='https://www.mozilla.org/fr/firefox/new/'>";
$li = "<a style='color: #FFFFFF;' target='new' href='https://www.microsoft.com/fr-fr/windows/microsoft-edge'>";
$lo = "<a style='color: #FFFFFF;' target='new' href='http://www.opera.com/'>";

$lz = "</a>";

echo ("
<html>
<body 
style='
background-color: #000000;
color: #FFFFFF;
font-family: Arial,Helvetica,sans-serif;
font-size: 24px;
padding: 0;
text-align: center;
'
>

<div style='
width: 1024px; height: 768px; 
background-image: url(../media/_staticPages/bg.jpg); 
background-repeat: repeat;
margin-left: auto; 
margin-right: auto;
text-align: center;
'>


<table style='
margin-left: auto; 
margin-right: auto;
'>
<tr>
<td style='text-align:left;'>Eng:</td>
<td style='text-align:left;'>Internet Explorer isn't supported anymore. You should use another browser. Here are some options</td>
</tr>
<tr>
<td style='text-align:left;'>Fra:</td>
<td style='text-align:left;'>Internet Explorer n'est plus supporté. Vous devriez utiliser un autre navigateur. Voici quelques options</td>
</tr>
</table>

<table style='
margin-left: auto; 
margin-right: auto;
margin-top: 220px; 
margin-bottom: auto;
border-spacing: 32px;
'>
<tr>
<td style='text-align:center;'>	".$lc." <img src='../media/_staticPages/LogoGoogleChrome.png' border='0'>		".$lz."	</td>
<td style='text-align:center;'>	".$lf." <img src='../media/_staticPages/LogoMozillaFirefox.png' border='0'>	".$lz."	</td>
<td style='text-align:center;'>	".$li." <img src='../media/_staticPages/LogoMicrosoftEdgeChromium.png' border='0'>		".$lz."	</td>
<td style='text-align:center;'>	".$lo." <img src='../media/_staticPages/LogoOpera.png' border='0'>		".$lz."	</td>
</tr>
<tr>
<td style='width: 160px; text-align:center; font-weight: bold; font-size: 20px;'>".$lc." Chrome".$lz."</td>
<td style='width: 160px; text-align:center; font-weight: bold; font-size: 20px;'>".$lf." Firefox".$lz."</td>
<td style='width: 160px; text-align:center; font-weight: bold; font-size: 20px;'>".$li." Edge".$lz."</td>
<td style='width: 160px; text-align:center; font-weight: bold; font-size: 20px;'>".$lo." Opera".$lz."</td>
</tr>
</table>

</div>

</body>
</html>
");

?>
