<?php 
$i18n['avcf'] = "Veuillez compl\351ter le formulaire.\\n\\nChamps du fomulaire:\\n";
$i18n['bouton'] = "Installer";

$i18n['F1_title'] = "Information de ce serveur";

$i18n['PHP_builtin_ok'] = "est pr&eacute;sent.\r";
$i18n['PHP_builtin_nok'] = "n'a pas &eacute;t&eacute; trouv&eacute;.<br>\r";
$i18n['PHP_support_title'] = "Couche d'abstraction de base de données:<br>\r";

$i18n['t1l1c1'] = "Nom de cette machine / IP"; 
$i18n['t1l2c1'] = "Version PHP"; 
$i18n['t1l3c1'] = "Chemin d'inclusion";
$i18n['t1l4c1'] = "R&eacute;pertoire courant";
$i18n['t1l5c1'] = "Affiche erreur / Registre global / Taille maximum du 'POST'";
$i18n['t1l6c1'] = "Limite m&eacute;moire";
$i18n['t1l7c1'] = "Temps d'ex&eacute;cution maximum";
$i18n['t1l8c1'] = "Service de base de donn&eacute;es";
$i18n['t1l9c1'] = "Limite de mémoire préconisée pour l'insatallation";
$i18n['t1l10c1'] = "Limite de temp préconisée pour l'insatallation";

$i18n['test_ok']	= "ok";
$i18n['test_nok']	= "Avertissement";

$i18n['F2_title'] = "M&eacute;thode d'installation";
$i18n['F2_intro'] = "Il y a deux types d'installation de MultiWeb Manager. Ceci dans le but de permettre une installation facile sur un plus large nombre de plateformes.<br>\r<br>\r";
$i18n['F2_txt_aide1'] = "<span style=\'font-weight:bold;\'>Choix d\'une installation directe:</span><br>L\'installateur va se connecter &agrave; la base (soit locale soit distante) et va cr&eacute;er les tables n&eacute;cessaires pour que le moteur fonctionne. Les param&egrave;tres entr&eacute;s dans la configuration de cette instalation serviront pour le site en tant que tel.<br><br>N\'oubliez pas de copier les fichiers sur le serveur.";
$i18n['F2_txt_aide2'] = "<span style=\'font-weight:bold;\'>Choix d\'une installation par script:</span><br>L\'installateur va cr&eacute;er un script qui permettra &agrave; l\'utilisateur de le charger sur une interface de type PhpMyAdmin. Ce genre de cas s\'applique avec des h&eacute;bergeurs qui ne permettent pas une connexion directe au serveur de base de donn&eacute;es. Cela tend &agrave; &ecirc;tre plus rare de nos jours.<br>";
$i18n['F2_m1o1'] = "Connexion directe &agrave; la base";
$i18n['F2_m1o2'] = "Cr&eacute;ation d'un script";


$i18n['F3_title'] = "Les sites &agrave; installer";
$i18n['t3l1c1']	= "R&eacute;pertoires pr&eacute;sents dans Website_datas";
$i18n['t3l1c2']	= "Installation ?";
$i18n['t3l1c3']	= "Faut-il Contr&ocirc;ler le code ?";


$i18n['F4_title'] = "Se connecter &agrave; la BDD pour installer";
$i18n['F4_intro'] = "Pour installer le moteur, il faut un acc&egrave;s &agrave; la base de donn&eacute;es associ&eacute;e au serveur web. Il faut un compte ayant suffisamment de privil&egrave;ges sur la base pour pouvoir cr&eacute;er des bases (ou sch&eacute;mas) et des tables. Les identifiants que vous fournirez ne seront pas r&eacute;utilis&eacute;s. L'installateur cr&eacute;era un utilisateur d&eacute;di&eacute;e pour fonctionner (tableau suivant). Veuillez renseigner les champs du tableau ci-dessous.<br>\r<br>\r";
$i18n['t4l1c1'] = "Element";
$i18n['t4l1c2'] = "Pr&eacute;fixe ";
$i18n['t4l1c3'] = "Champ";
$i18n['t4l1c4'] = "Information";
$i18n['t4l2c1'] = "Couche d'abstraction";
$i18n['t4l2c2']= "";
$i18n['t4l2c4']	= "Choisissez le support CABDD que vous d&eacute;sirez (attention PEARDB est d&eacute;pr&eacute;ci&eacute;). Le support AdoDB est experimental pour le moment.";
$i18n['msdal_msqli']= "PHP MysqlI (Par d&eacute;faut)";
$i18n['msdal_phppdo']= "PHP PDO";
$i18n['msdal_adodb']= "ADOdb (v&eacute;rifiez votre h&eacute;bergeur)";
$i18n['msdal_pear']= "PEAR DB (d&eacute;pr&eacute;ci&eacute;)";
$i18n['t4l3c1'] = "Type";
$i18n['t4l3c2']= "";
$i18n['t4l3c4']	= "Le support base de donn&eacute;es est assur&eacute; par le module s&eacute;lectionn&eacute;.";
$i18n['t4l4c4AD'] = "Si ce script est lanc&eacute; depuis votre serveur sur un h&eacute;bergement tiers, vous avez probablement des restrictions pour la cr&eacute;ation des bases. Habituellement vous devez le faire dans une interface du genre de Cpanel. Dans ce cas s&eacute;lectionnez \'h&eacute;bergement\'. Le script ne d&eacute;truira pas la base que vous nommez mais ne fera que la vider de ces tables.<br><br>L\'autre cas &eacute;tant un serveur ou vous pouvez absolument tout faire. Vous pouvez s&eacute;lectionnez le profil \'Droit absolu\'.";
$i18n['t4l4c1'] = "Profil d'h&eacute;bergement";
$i18n['t4l4c2']= "";
$i18n['t4l4c4']	= "Choisissez le profil d'h&eacute;bergement ou le moteur devra &ecirc;tre install&eacute;.";
$i18n['dbp_hosted'] = "H&eacute;bergement";
$i18n['dbp_asolute'] = "Droit absolu";
$i18n['t4l5c1'] = "Serveur de base de donn&eacute;es";
$i18n['t4l5c2'] = "";
$i18n['t4l5c3'] = "";
$i18n['t4l5c4'] = "C'est le serveur de base de donn&eacute;es. Habituellement, 'localhost' (litt&eacute;ralement) est la seule information n&eacute;cessaire. Sinon, v&eacute;rifiez les informations avec l'h&eacute;bergeur.";
$i18n['t4l6c1']	= "Pr&eacute;fixe";
$i18n['t4l6c2']	= "";
$i18n['t4l6c3']	= "";
$i18n['t4l6c4']	= "Parfois un pr&eacute;fixe est requis. Habituellement c'est le nom de votre compte pourvu par votre h&eacute;bergeur. Ex MonCompte_ + utilisateurDB. Entrez uniquement le pr&eacute;fixe dans ce champ.";
$i18n['t4l7c1']	= "Nom de la base de donn&eacute;es";
$i18n['t4l7c2']	= "";
$i18n['t4l7c3']	= "";
$i18n['t4l7c4']	= "C'est le nom de la base de donn&eacute;es sur votre serveur.";
$i18n['t4l8c1']	= "Identifiant admin";
$i18n['t4l8c2']	= "";
$i18n['t4l8c3']	= "";
$i18n['t4l8c4']	= "Entrez un nom d'utilisateur qui a les droits suffisants pour cr&eacute;er des bases, des tables et des utilisateurs sur le serveur de BDD. ";
$i18n['t4l9c1']	= "Mot de passe";
$i18n['t4l9c2']	= "";								
$i18n['t4l9c3']	= "";
$i18n['t4l9c4']	= "";
$i18n['t4l10c1']	= "Tester la connexion &agrave; la base de donn&eacute;e.";
$i18n['t4l10c2']	= "";
$i18n['t4l10c4aok']	= "La connexion &agrave; la base a r&eacute;ussi.";
$i18n['t4l10c4ako']	= "La connexion &agrave; la base a &eacute;chou&eacute;.";
$i18n['t4l10c4bok']	= "Une BDD Hydr est d&eacute;j&agrave; pr&eacute;sente.";
$i18n['t4l10c4bko']	= "BDD Hydr non trouv&eacute;e.";


$i18n['F5_title'] = "Personalisation BDD";
$i18n['t5l1c1'] = "Element";		
$i18n['t5l1c2'] = "Pr&eacute;fixe ";
$i18n['t5l1c3'] = "Champ";
$i18n['t5l1c4'] = "Information";
$i18n['t5l2c1']	= "Pr&eacute;fixes des tables";
$i18n['t5l2c2']	= "";								
$i18n['t5l2c3']	= "";
$i18n['t5l2c4']	= "Chaque table aura ce pr&eacute;fixe. Suivant la base de donn&eacute;es cela peut s'av&eacute;rer utile.";
$i18n['t5l3c1']	= "Nom de l'utilisateur de la base (vos scripts)";
$i18n['t5l3c2']	= "";												
$i18n['t5l3c3']	= "";
$i18n['t5l3c4']	= "C'est l'utilisateur virtuel. Le script l'utilisera pour se connecter a la base de donn&eacute;es. Faites en sorte que ce nom soit diff&eacute;rent du propri&eacute;taire du serveur. Suivant l'h&eacute;bergeur vous aurez a d&eacute;clarer la base et l'utilisateur avant d'installer.";
$i18n['boutonpass']	= "G&eacute;n&eacute;rer";
$i18n['t5l4c1']	= "Mot de passe";
$i18n['t5l4c2']	= "";								
$i18n['t5l4c3']	= "";
$i18n['t5l4c4']	= "Si l'utilisateur existe d&eacute;j&agrave; pour cette base de donn&eacute;es, ne g&eacute;n&eacute;rez pas de mot de passe. Utilisez le mot de passe associ&eacute; &agrave; cet utilisateur.";
$i18n['t5l5c1']	= "Recr&eacute;er cet utilisateur.";
$i18n['dbr_o'] = "Oui";
$i18n['dbr_n'] = "Non";
$i18n['t5l5c2']	= "";							
$i18n['t5l5c3']	= "";
$i18n['t5l5c4']	= "Si c'est possible (privil&egrave;ges administrateur) il pr&eacute;f&eacute;rable de recr&eacute;er l'utilisateur du script durant l'installation. Si 'non' est selectionn&eacute; vous devez v&eacute;rifier que cet utilisateur est correctement configur&eacute; pour utiliser cette base.";
$i18n['t5l6c1']	= "Mot de passe des utilisateurs g&eacute;n&eacute;riques";
$i18n['t5l6c2']	= "";								
$i18n['t5l6c3']	= "";
$i18n['t5l6c4']	= "Le moteur a besoin de quelques utilisateurs pour que vous puissiez acc&eacute;der aux panneaux d'aministration. C'est le mot de passe pour les utilisateurs g&eacute;n&eacute;riques.";
$i18n['t5l7c1']	= "Cr&eacute;ation .htacces";
$i18n['t5l7c2']	= "";						
$i18n['t5l7c3']	= "";
$i18n['t5l7c4']	= "Le fichier .htaccess est un fichier de r&egrave;gles d&eacute;finissant les autorisations d'acc&egrave;s aux fichiers du serveur. Cela permet de prot&eacute;ger des fichiers contenant des informations senssibles. Le fichier propos&eacute; offre des r&egrave;gles classiques. Le bon fonctionnement de ces r&egrave;gles d&eacute;pend aussi du serveur.";
$i18n['TypeExec1']	= "Module Apache";
$i18n['TypeExec2']	= "Lignes de commande";
$i18n['t5l8c1']	= "Type d'ex&eacute;cution";
$i18n['t5l8c2']	= "";						
$i18n['t5l8c3']	= "";
$i18n['t5l8c4']	= "Vous pouvez ex&eacute;cuter le script suivant deux mode. Comme un module Apache ou comme un script de ligne de commande. Tout d&eacute;pend de ce que votre h&eacute;bergeur autorise. Par d&eacute;faut l'ex&eacute;cution se fait comme un 'module Apache'.";


$i18n['F6_title'] = "Journalisation de l'installation";
$i18n['t6l1c1']	= "Options de l'affichage du r&eacute;sum&eacute;";
$i18n['t6l1c2']	= "";								
$i18n['t6l1c3']	= "";
$i18n['t6l1c4']	= "";
$i18n['t6l2c1']	= "Base de donn&eacute;es";
$i18n['t6l2c2']	= "Messages d'avertissement";
$i18n['t6l2c3']	= "Messages d'erreur";
$i18n['t6l3c1']	= "Console de commande";
$i18n['t6l3c2']	= "Messages d'avertissement";
$i18n['t6l3c3']	= "Messages d'erreur";


$i18n['ls0'] = "Serveur de base de donn\351es";
$i18n['ls1'] = "Identifiant admin (lecture / \351criture)";
$i18n['ls2'] = "Mot de passe";
$i18n['ls3'] = "Nom de la base de donn\351es";
$i18n['ls4'] = "Nom de l\'utilisateur de la base (vos scripts)";
$i18n['ls5'] = "Mot de passe l\'utilisateur de la base";
$i18n['ls6'] = "Mot de passe des utilisateurs g\351n\351riques";

?>