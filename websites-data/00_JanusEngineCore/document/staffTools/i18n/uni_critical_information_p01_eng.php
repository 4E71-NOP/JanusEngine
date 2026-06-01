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
		"eng" => array(
			"url_bypass" => "<h3>Accessing Admin panels:</h3>\r
				<p>The engine works with a athentification system. If your website do not have the need to register users and by the way do not need to have the authentification module 'online', you will not be able to login either (classical way). To bypass this little problem, you can can use an URL that will make the engine perform the authification.</p>\r
				<p>Note that if you change you login and password, this URL with previous login and password information will not work anymore.</p>\r
				<p>So before putting the authentification module offline you can bookmark the following URL:</p>\r",
			"url_bypass_name" => "URL to loggin on this website",
		),
	)
);
?>