<?php
// @JanusEngine:license-start
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

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"url_bypass" => "<h3>Acc&eacute;der aux panneaux d'administration:</h3>\r
				<p>Le moteur fonctionne avec un syst&egrave;me d'authentification. Si votre site n'a pas besoin d'utilisateur, et donc n'a pas besoin d'avoir le module pr&eacute;sent, vous ne pourrez plus vous authentifier de mani&egrave;re classique. Pour contourner ce petit probl&egrave;me, vous pouvez utiliser une URL qui fera en sorte que le moteur vous authentifie.</p>\r
				<p>Notez bien que si vous changez vos identifiants, une URL de ce type, sauvegard&eacute;e avec les anciens identifiants ne fonctionnera plus.</p>\r
				<p>Avant de mettre le module d'authentification hors ligne vous pouvez enregistrer dans les signets l'URL suivante.</p>\r",
			"url_bypass_name" => "Adresse pour me connecter au site",
		),
	)
);
?>