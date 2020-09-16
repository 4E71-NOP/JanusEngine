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
//	uni_informations_utiles_p01.php
// --------------------------------------------------------------------------------------------
/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "uni_informations_utiles_p01";

$tl_['eng']['url_bypass'] = "
<p class='" . $theme_tableau . $_REQUEST['bloc']."_tb4'>Accessing Admin panels:</p>\r
The engine works with a athentification system. If your website do not have the need to register users and by the way do not need to have the authentification module 'online', you will not be able to login either (classical way). To bypass this little problem, you can can use an URL that will make the engine perform the authification.<br>\r
<br>\r
Note that if you change you login and password, this URL with previous login and password information will not work anymore.<br>\r
So before putting the authentification module offline you can bookmark this URL:<br>\r
<br>\r
";
$tl_['fra']['url_bypass'] = "
<p class='" . $theme_tableau . $_REQUEST['bloc']."_tb4'>Acc&eacute;der aux panneaux d'administration:</p>\r
Le moteur fonctionne avec un syst&egrave;me d'authentification. Si votre site n'a pas besoin d'utilisateur, et donc n'a pas besoin d'avoir le module pr&eacute;sent, vous ne pourrez plus vous authentifier de mani&egrave;re classique. Pour contourner ce petit probl&egrave;me, vous pouvez utiliser une URL qui fera en sorte que le moteur vous authentifie.<br>\r
<br>\r
Notez bien que si vous changez vos identifiants, une URL de ce type, sauvegard&eacute;e avec les anciens identifiants ne fonctionnera plus.<br>\r
Avant de mettre le module d'authentification hors ligne vous pouvez enregistrer dans les signets cette URL.<br>\r
<br>\r
";

$tl_['eng']['url_bypass_nom'] = "URL to loggin on this website";
$tl_['fra']['url_bypass_nom'] = "Adresse pour me connecter au site";

echo ( $tl_[$l]['url_bypass'] . "

<span class='" . $theme_tableau . $_REQUEST['bloc']."_tb4'><a class='" . $theme_tableau . $_REQUEST['bloc']."_lien' href='
index.php?
&amp;sw=".$site_web['sw_id']."
&amp;l=".$user['lang']."
&amp;arti_ref=fra_admin_authentification
&amp;arti_page=1
'>".$tl_[$l]['url_bypass_nom']."
</a>
</span>
<br>\r
<br>\r
<hr>\r
");

/*Hydre-contenu_fin*/
?>
