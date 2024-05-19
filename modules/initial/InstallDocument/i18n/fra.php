<?php
$i18n = array(
	'0'				=>		"Non",
	'1'				=>		"Oui",
	'Invite'		=>		"Bienvenue sur Hydre",

	'avcf'	 => "Veuillez compl\351ter le formulaire.\\n\\nChamps du fomulaire:\\n",
	'bouton'	=> "Installer",

	'F1_title'	=> "Information de ce serveur",

	'PHP_builtin_ok'			=> "est présent",
	'PHP_builtin_nok'			=> "n'a pas été trouvé",
	'PHP_support_title'			=> "Couche d'abstraction de base de données:<br>\r",
	'PHP_pear_support'			=> "Support PEAR:",
	'PHP_adodb_support'			=> "Support ADOdb:",
	'PHP_pdo_support'			=> "Support PDO:",
	'PHP_db_builtin_functions'	=> "Fonctions BDD intégrées à PHP:",
	'unveilPassword'			=> "Découvrir le mot de passe",

	'tabTxt1'	=> "Serveur",
	'tabTxt2'	=> "BDD",
	'tabTxt3'	=> "Méthode",
	'tabTxt4'	=> "Sites",
	'tabTxt5'	=> "Personalisation",
	'tabTxt6'	=> "Journaux",

	// Server
	'SRV_ip'		=> "Nom de cette machine / IP", 
	'SRV_phpVrs'	=> "Version PHP", 
	'SRV_incPth'	=> "Chemin d'inclusion",
	'SRV_CurDir'	=> "Répertoire courant",
	'SRV_DisErr'	=> "Affiche erreur / Registre global / Taille maximum du 'POST'",
	'SRV_MemLim'	=> "Limite mémoire",
	'SRV_MaxTim'	=> "Temps d'exécution maximum",
	'SRV_DbSrvc'	=> "Service de base de données",
	'SRV_PrcRam'	=> "Limite de mémoire préconisée pour l'insatallation",
	'SRV_PrcTim'	=> "Limite de temp préconisée pour l'insatallation",

	'test_ok'		=> "ok",
	'test_nok'		=> "Avertissement",

	// DB
	'DB_Titlec1'	=> "Element",
	'DB_Titlec2'	=> "Préfixe ",
	'DB_Titlec3'	=> "Champ",
	'DB_Titlec4'	=> "Information",

	'DB_dal'		=> "Couche d'abstraction",
	'DB_dalInf'		=> "Choisissez le support CABDD que vous voulez utiliser. Attention PEARDB est déprécié. Le support AdoDB est experimental pour le moment.",
	'msdal_php'		=> "PHP functions (default)",
	'msdal_pdo'		=> "PHP PDO",
	'msdal_adodb'	=> "ADOdb (check webhosting plan)",
	'msdal_pear' 	=> "PEAR DB (deprecated)",

	'DB_type'		=> "Type",
	'DB_typeInf'	=> "Le support base de données est assuré par le module sélectionné.",

	'DB_hosting'	=> "Profil d'hébergement",
	'DB_hostingInf'	=> "Choisissez le profil d'hébergement ou le moteur devra être installé.",
	'dbp_hosted'	=> "Hébergement",
	'dbp_asolute'	=> "Pouvoir absolu sur mon serveur",

	'DB_server'	 	=> "Serveur de base de données",
	'DB_serverInf' 	=> "C'est le serveur de base de données. Utilisez 'localhost' or 'mysql' (Docker, etc.) ou l'adresse IP du serveur. Sinon, vérifiez les informations avec l'hébergeur.",

	'DB_server_port'		=> "Port du serveur de base de données",
	'DB_server_portInf' 	=> "Laissez le champ vide pour utiliser le port par défaut.",

	'Db_prefix'		=> "Préfixe",
	'Db_prefixInf'	=> "Parfois un préfixe est requis. Habituellement c'est le nom de votre compte pourvu par votre hébergeur. Ex MonCompte_ + utilisateurDB. Entrez uniquement le préfixe dans ce champ.",

	'DB_name'		=> "Nom de la base de données",
	'DB_nameInf'	=> "C'est le nom de la base de données sur votre serveur.",

	'DB_Admlogin'		=> "Identifiant admin",
	'DB_AdmloginInf'	=> "Entrez un nom d'utilisateur qui a les droits suffisants pour créer des bases, des tables et des utilisateurs sur le serveur de BDD. ",

	'DB_password'		=> "Mot de passe",

	'DB_tstcnx'					=>	"Tester la connexion à la base de donnée.",
	'DB_cnxToDBok'				=>	"La connexion à la base a réussi.",
	'DB_cnxToDBko'				=>	"La connexion à la base a échoué.",
	'DB_HydrDBAlreadyExistsok'	=>	"ATTENTION! Une BDD Hydr est déjà présente. L'installation écrasera cette base si vous continuez. Changez le nom si vous voulez garder l'existant.",
	'DB_HydrDBAlreadyExistsko'	=>	"BDD Hydr non trouvée.",
	'DB_HydrUserAlreadyExistsok'	=>	"ATTENTION! L'utilisateur a été trouvé. L'installateur ne fera que <b>modifier ses privilèges</b> à moins que la 'personalisation' spécifie le contraire.",
	'DB_HydrUserAlreadyExistsko'	=>	"L'utilisateur n'a pas étyé trouvé. L'installateur le créera.",
	"DB_installationLockedok"	=>	"Pas de verrou trouvé.",
	"DB_installationLockedko"	=>	"L'installation est  <b>vérrouillée!</b> Le programme n'installera pas tant que le verrou sera présent.",

	// Method
	'MTH_intro'		=> "Il y a deux types d'installation de Hydr. Ceci dans le but de permettre une installation facile sur un plus large nombre de plateformes.<br>\r<br>\r",
	'MTH_opt1'		=> "Connexion directe à la base",
	'MTH_opt2'		=> "Création d'un script",
	'MTH_opt1Help'	=> "Choix d'une installation directe:<br>L'installateur va se connecter à la base (soit locale soit distante) et va créer les tables nécessaires pour que le moteur puisse fonctionner. Les paramètres entrés dans la configuration de cette instalation serviront pour le site en tant que tel.<br><br>N'oubliez pas de copier les fichiers (et fichiers de configuration) sur le serveur.",
	'MTH_opt2Help'	=> "Choix d'une installation par script:<br>L'installateur va créer un script qui permettra à l'utilisateur de le charger sur une interface de type PhpMyAdmin. Ce genre de cas s\'applique avec des hébergeurs qui ne permettent pas une connexion directe au serveur de base de données. Cela tend à être plus rare de nos jours.<br>",

	// Site Selection
	'SIT_Titlec1'	=> "Répertoires présents dans '<i><b>Websites-datas</b></i>'",
	'SIT_Titlec2'	=> "Installation ?",
	'SIT_Titlec3'	=> "Faut-il Contrôler le code ?",

	// Personalization
	'PER_Titlec1'	=> "Element",		
	'PER_Titlec2'	=> "Préfixe",
	'PER_Titlec3'	=> "Champ",
	'PER_Titlec4'	=> "Information",

	'PER_TbPrfx'	=> "Préfixes des tables",
	'PER_TbPrfxInf'	=> "Chaque table aura ce préfixe. Suivant la base de données cela peut s'avérer utile.",

	'PER_DbUsrN'	=> "Nom d'utilisateur Hydr sur la BDD",
	'PER_DbUsrNInf'	=> "C'est l'utilisateur virtuel. Le script l'utilisera pour se connecter a la base de données. Faites en sorte que ce nom soit différent du propriétaire du serveur. Suivant l'hébergeur vous aurez a déclarer la base et l'utilisateur avant d'installer.",
	'boutonpass'	=> "Générer",

	'PER_DbUsrP'	=> "Mot de passe",
	'PER_DbUsrPInf'	=> "Si l'utilisateur existe déjà pour cette base de données, ne générez pas de mot de passe. Utilisez le mot de passe associé à cet utilisateur.",

	'PER_UsrRec'	=> "Recréer cet utilisateur.",
	'PER_UsrRecInf'	=> "Si c'est possible (privilèges administrateur) il préférable de recréer l'utilisateur du script durant l'installation. Si 'non' est selectionné vous devez vérifier que cet utilisateur est correctement configuré pour utiliser cette base.",
	'dbr_o'			=> "Oui",
	'dbr_n'			=> "Non",

	'PER_WbUsrP'	=> "Mot de passe des utilisateurs des sites",
	'PER_WbUsrPInf'	=> "Le moteur a besoin de quelques utilisateurs pour que vous puissiez accéder aux panneaux d'aministration. C'est le mot de passe pour les utilisateurs génériques.",

	'PER_MkHtacs'		=> "Création .htacces",
	'PER_MkHtacsInf'	=> "Le fichier .htaccess est un fichier de règles définissant les autorisations d'accès aux fichiers du serveur. Cela permet de protéger des fichiers contenant des informations senssibles. Le fichier proposé offre des règles classiques. Le bon fonctionnement de ces règles dépend aussi du serveur.",
	'TypeExec1'		=> "Module Apache",
	'TypeExec2'		=> "Lignes de commande",

	'PER_Typexe'	=> "Type d'exécution",
	'PER_TypexeInf'	=> "Vous pouvez exécuter le script suivant deux mode. Comme un module Apache ou comme un script de ligne de commande. Tout dépend de ce que votre hébergeur autorise. Par défaut l'exécution se fait comme un 'module Apache'.",

	// Report
	'REP_Titlec1'	=> "Options de l'affichage du résumé",
	'REP_db'		=> "Base de données",
	'REP_consol'	=> "Console de commande",
	'REP_wrnMsg'	=> "Messages d'avertissement",
	'REP_errMsg'	=> "Messages d'erreur",

	'ls0'	 => "Serveur de base de donn\351es",
	'ls1'	 => "Identifiant admin (lecture / \351criture)",
	'ls2'	 => "Mot de passe",
	'ls3'	 => "Nom de la base de donn\351es",
	'ls4'	 => "Nom de l\'utilisateur de la base (vos scripts)",
	'ls5'	 => "Mot de passe l\'utilisateur de la base",
	'ls6'	 => "Mot de passe des utilisateurs g\351n\351riques",

	'tab_1' => "Création tables",
	'tab_2' => "Chargement SQL",
	'tab_3' => "Script",
	'tab_4' => "Chargement SQL supplémentaire",
	'tab_5' => "SQL brut",
	'tab_6' => "Performances",
	'tab_7' => "Fichiers",
	'tab_8' => "7",

	't1c1' => "Fichier",
	't1c2' => "Ok",
	't1c3' => "Avertissement",
	't1c4' => "Erreur",
	't1c5' => "Temps",
	't1c6' => "SQL",
	't1c7' => "Commandes",

	't5c1' => "
Ces fihiers doivent être sauvegardés (si ce n'est pas déjà fait) dans le répertoire 'current/config/current/'.<br>\r
L'acces à ce répertoire doit être restreint. Un simple .htaccess par défaut est fourni dans ce répertoire.<br>\r
Assurez vous qu'il est bien présent sur le serveur. Assurez vous de l'éditer avec précaution. Assurez vous que 'AllowOverride All' est configuré pour 'Directory /var/www/'<br>\r
<br>\r
",
	'BtnSelect' => "Sélectionner",
	
	"perfTab01"	=>	"N",
	"perfTab02"	=>	"Checkpoint",
	"perfTab03"	=>	"Time",
	"perfTab04"	=>	"Memory",
	"perfTab05"	=>	"Queries",
	
	't9c1' => "A",
	't9c2' => "B",
	't9c3' => "C",
	't9c4' => "D",
	't9c5' => "E",
	't9c6' => "F",

	"JavaScriptI18nDbCnxAlert"	=>	"Le test d'accès à la BDD n'est pas bon. Merci de vous assurer de l'accès à la base de donnée depuis le formulaire avec le bouton dédié (onlget BDD).",
	"REPORT_badToken"	=>	"Le jeton d'installation n'est pas le bon."

);
?>