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
			"sslStateOff"	=>	"Le SSL n'est pas actif. La connexion n'est donc <b><u>PAS</u></b> sécurisée.",
			"invite1"		=>	"Remplissez les champs puis validez. Un mail vous sera envoyé pour confirmer la création du compte.",
			"invite2"		=>	"Un mail de confirmation a été envoyé. Cliquez sur le lien dans le mail pour confirmer l'inscription. Si vous ne trouvez pas le mail, vérifier qu'il n'est pas dans les 'indésirables'.",
			"invite3"		=>	"Félicitation le compte à été créé. Vous pouvez revenir à l'acceuil et vous connecter.",
			"invite4"		=>	"Une erreur s'est produite. Contactez un administrateur du site.",
			"invite5"		=>	"Le jeton sollicité a expiré. L'inscription n'aboutira pas. Vous devez recommencer l'inscrition.",
			"invite6"		=>	"Ce site ne permet pas l'inscription",

			"user_login"	=>	"Identifiant",
			"user_password"	=>	"Mot de passe",
			"user_mail"		=>	"Email",
			"buttonSignup"	=>	"Créer le compte",
			"errorEmptyLogin"			=> "Erreur : Identifiant vide",
			"errorEmptyPassword"		=> "Erreur : Mot de passe vide",
			"errorEmptyEmail"			=> "Erreur : Email vide",
			"errorLoginAlreadyExists"	=> "Erreur : L'identifiant existe déjà",
			"errorInvalidEmail"			=> "Erreur : L'Email est invalide",
			"errorEmailAlreadyExists"	=> "Erreur : L'Email est déjà utilisé",
		),
	)
);
?>