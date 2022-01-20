<?php
$i18n = array(
	'0'				=>		"Non",
	'1'				=>		"Oui",
	'Invite'		=>		"Bienvenue sur Hydre",

	'avcf'	 => "Veuillez compl\351ter le formulaire.\\n\\nChamps du fomulaire:\\n",
	'bouton'	=> "Installer",

	'F1_title'	=> "Information de ce serveur",

	'PHP_builtin_ok'	=> "est présent",
	'PHP_builtin_nok'	=> "n'a pas été trouvé",
	'PHP_support_title'	=> "Couche d'abstraction de base de données:<br>\r",
	'PHP_pear_support' => "Support PEAR:",
	'PHP_adodb_support' => "Support ADOdb:",
	'PHP_pdo_support' => "Support PDO:",
	'PHP_db_builtin_functions' => "Fonctions BDD intégrées à PHP:",

	'tabTxt1'	 => "Serveur",
	'tabTxt2'	 => "BDD",
	'tabTxt3'	 => "Méthode",
	'tabTxt4'	 => "Sites",
	'tabTxt5'	 => "Personalisation",
	'tabTxt6'	 => "Journaux",

	't1l1c1'	 => "Nom de cette machine / IP", 
	't1l2c1'	 => "Version PHP", 
	't1l3c1'	 => "Chemin d'inclusion",
	't1l4c1'	 => "Répertoire courant",
	't1l5c1'	 => "Affiche erreur / Registre global / Taille maximum du 'POST'",
	't1l6c1'	 => "Limite mémoire",
	't1l7c1'	 => "Temps d'exécution maximum",
	't1l8c1'	 => "Service de base de données",
	't1l9c1'	 => "Limite de mémoire préconisée pour l'insatallation",
	't1l10c1'	 => "Limite de temp préconisée pour l'insatallation",

	'test_ok'		=> "ok",
	'test_nok'		=> "Avertissement",

	'F2_title'		=> "Méthode d'installation",
	'F2_intro'		=> "Il y a deux types d'installation de Hydr. Ceci dans le but de permettre une installation facile sur un plus large nombre de plateformes.<br>\r<br>\r",
	'F2_txt_aide1'	=> "Choix d'une installation directe:<br>L'installateur va se connecter à la base (soit locale soit distante) et va créer les tables nécessaires pour que le moteur fonctionne. Les paramètres entrés dans la configuration de cette instalation serviront pour le site en tant que tel.<br><br>N'oubliez pas de copier les fichiers sur le serveur.",
	'F2_txt_aide2'	=> "Choix d'une installation par script:<br>L'installateur va créer un script qui permettra à l'utilisateur de le charger sur une interface de type PhpMyAdmin. Ce genre de cas s\'applique avec des hébergeurs qui ne permettent pas une connexion directe au serveur de base de données. Cela tend à être plus rare de nos jours.<br>",
	'F2_m1o1'		=> "Connexion directe à la base",
	'F2_m1o2'		=> "Création d'un script",


	'F3_title'		=> "Les sites à installer",
	't3l1c1'		=> "Répertoires présents dans Website_datas",
	't3l1c2'		=> "Installation ?",
	't3l1c3'		=> "Faut-il Contrôler le code ?",

	// DB tab
	// 't4l4c4AD'	=> "Si ce script est lancé depuis votre serveur sur un hébergement tiers, vous avez probablement des restrictions pour la création des bases. Habituellement vous devez le faire dans une interface du genre de Cpanel. Dans ce cas sélectionnez \'hébergement\'. Le script ne détruira pas la base que vous nommez mais ne fera que la vider de ces tables.<br><br>L\'autre cas étant un serveur ou vous pouvez absolument tout faire. Vous pouvez sélectionnez le profil \'Droit absolu\'.",
	// 'F4_title'		=> "Se connecter à la BDD pour installer",
	// 'F4_intro'		=> "Pour installer le moteur, il faut un accès à la base de données associée au serveur web. Il faut un compte ayant suffisamment de privilèges sur la base pour pouvoir créer des bases (ou schémas) et des tables. Les identifiants que vous fournirez ne seront pas réutilisés. L'installateur créera un utilisateur dédiée pour fonctionner (tableau suivant). Veuillez renseigner les champs du tableau ci-dessous.<br>\r<br>\r",
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

	'Db_prefix'		=> "Préfixe",
	'Db_prefix'		=> "Parfois un préfixe est requis. Habituellement c'est le nom de votre compte pourvu par votre hébergeur. Ex MonCompte_ + utilisateurDB. Entrez uniquement le préfixe dans ce champ.",

	'DB_name'		=> "Nom de la base de données",
	'DB_nameInf'	=> "C'est le nom de la base de données sur votre serveur.",

	'DB_Admlogin'		=> "Identifiant admin",
	'DB_AdmloginInf'	=> "Entrez un nom d'utilisateur qui a les droits suffisants pour créer des bases, des tables et des utilisateurs sur le serveur de BDD. ",

	'DB_password'		=> "Mot de passe",

	'DB_tstcnx'		=> "Tester la connexion à la base de donnée.",
	'DB_tstcnxAok'		=> "La connexion à la base a réussi.",
	'DB_tstcnxAko'		=> "La connexion à la base a échoué.",
	'DB_tstcnxBok'		=> "ATTENTION: Une BDD Hydr est déjà présente. L'installation écrasera cette base si vous continuez. Changez le nom si vous voulez garder l'existant.",
	'DB_tstcnxBko'		=> "BDD Hydr non trouvée.",


	'F5_title'	 => "Personalisation BDD",
	't5l1c1'	 => "Element",		
	't5l1c2'	 => "Préfixe ",
	't5l1c3'	 => "Champ",
	't5l1c4'	 => "Information",
	't5l2c1'		=> "Préfixes des tables",
	't5l2c2'		=> "",								
	't5l2c3'		=> "",
	't5l2c4'		=> "Chaque table aura ce préfixe. Suivant la base de données cela peut s'avérer utile.",
	't5l3c1'		=> "Nom de l'utilisateur de la base (vos scripts)",
	't5l3c2'		=> "",												
	't5l3c3'		=> "",
	't5l3c4'		=> "C'est l'utilisateur virtuel. Le script l'utilisera pour se connecter a la base de données. Faites en sorte que ce nom soit différent du propriétaire du serveur. Suivant l'hébergeur vous aurez a déclarer la base et l'utilisateur avant d'installer.",
	'boutonpass'	=> "Générer",
	't5l4c1'		=> "Mot de passe",
	't5l4c2'		=> "",								
	'unveilPassword'=> "Découvrir le mot de passe",
	't5l4c4'		=> "Si l'utilisateur existe déjà pour cette base de données, ne générez pas de mot de passe. Utilisez le mot de passe associé à cet utilisateur.",
	't5l5c1'		=> "Recréer cet utilisateur.",
	'dbr_o'	 => "Oui",
	'dbr_n'	 => "Non",
	't5l5c2'		=> "",							
	't5l5c3'		=> "",
	't5l5c4'		=> "Si c'est possible (privilèges administrateur) il préférable de recréer l'utilisateur du script durant l'installation. Si 'non' est selectionné vous devez vérifier que cet utilisateur est correctement configuré pour utiliser cette base.",
	't5l6c1'		=> "Mot de passe des utilisateurs génériques",
	't5l6c2'		=> "",								
	't5l6c3'		=> "",
	't5l6c4'		=> "Le moteur a besoin de quelques utilisateurs pour que vous puissiez accéder aux panneaux d'aministration. C'est le mot de passe pour les utilisateurs génériques.",
	't5l7c1'		=> "Création .htacces",
	't5l7c2'		=> "",						
	't5l7c3'		=> "",
	't5l7c4'		=> "Le fichier .htaccess est un fichier de règles définissant les autorisations d'accès aux fichiers du serveur. Cela permet de protéger des fichiers contenant des informations senssibles. Le fichier proposé offre des règles classiques. Le bon fonctionnement de ces règles dépend aussi du serveur.",
	'TypeExec1'		=> "Module Apache",
	'TypeExec2'		=> "Lignes de commande",
	't5l8c1'		=> "Type d'exécution",
	't5l8c2'		=> "",						
	't5l8c3'		=> "",
	't5l8c4'		=> "Vous pouvez exécuter le script suivant deux mode. Comme un module Apache ou comme un script de ligne de commande. Tout dépend de ce que votre hébergeur autorise. Par défaut l'exécution se fait comme un 'module Apache'.",


	'F6_title'	 => "Journalisation de l'installation",
	't6l1c1'		=> "Options de l'affichage du résumé",
	't6l1c2'		=> "",								
	't6l1c3'		=> "",
	't6l1c4'		=> "",
	't6l2c1'		=> "Base de données",
	't6l2c2'		=> "Messages d'avertissement",
	't6l2c3'		=> "Messages d'erreur",
	't6l3c1'		=> "Console de commande",
	't6l3c2'		=> "Messages d'avertissement",
	't6l3c3'		=> "Messages d'erreur",


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


);
?>