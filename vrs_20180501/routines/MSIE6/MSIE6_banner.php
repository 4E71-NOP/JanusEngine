<?php
 /*Hydre-licence-debut*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@club-internet.fr
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/
// ../graph/IE6_redirect/fond.jpg

$lc = "<a style='color: #FFFFFF;' target='_new' href='https://www.google.com/chrome/'>";
$lf = "<a style='color: #FFFFFF;' target='_new' href='http://www.mozilla.com/'>";
$li = "<a style='color: #FFFFFF;' target='_new' href='https://www.microsoft.com/fr-fr/download'>";
$lo = "<a style='color: #FFFFFF;' target='_new' href='http://www.opera.com/'>";

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
background-image: url(../graph/IE6_redirect/fond.jpg); 
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
<td style='text-align:left;'>Only Internet Explorer 11 and Edge are supported by this website!</td>
</tr>
<tr>
<td style='text-align:left;'>Fra:</td>
<td style='text-align:left;'>Seulement Internet Explorer 11 et Edge sont support&eacute;s par ce site!</td>
</tr>
</table>

<table style='
margin-left: auto; 
margin-right: auto;
margin-top: 192px; 
margin-bottom: auto;
border-spacing: 32px;
'>
<tr>
<td style='text-align:center;'>	".$lc." <img src='../graph/IE6_redirect/Logo_Google_Chrome.png' border='0'>		".$lz."	</td>
<td style='text-align:center;'>	".$lf." <img src='../graph/IE6_redirect/Firefox-logo.png' border='0'>	".$lz."	</td>
<td style='text-align:center;'>	".$li." <img src='../graph/IE6_redirect/Microsoft_Edge_logo.png' border='0'>		".$lz."	</td>
<td style='text-align:center;'>	".$lo." <img src='../graph/IE6_redirect/opera-seeklogo.com.png' border='0'>		".$lz."	</td>
</tr>
<tr>
<td style='width: 160px; text-align:center; font-weight: bold; font-size: 20px;'>".$lc." Google Chrome".$lz."</td>
<td style='width: 160px; text-align:center; font-weight: bold; font-size: 20px;'>".$lf." Mozilla Firefox".$lz."</td>
<td style='width: 160px; text-align:center; font-weight: bold; font-size: 20px;'>".$li." Microsoft Edge".$lz."</td>
<td style='width: 160px; text-align:center; font-weight: bold; font-size: 20px;'>".$lo." Opera".$lz."</td>
</tr>
</table>

</div>

</body>
</html>
");

?>
