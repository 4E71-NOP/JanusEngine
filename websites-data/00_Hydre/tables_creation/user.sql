/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
/* 
user_status 		INACTIF 0	ACTIF 1	SUPPRIME 2
user_droit_forum	OFF 0		ON 1
user_lang			FRA 1		ENG 2		ESP 3
user_role_function	publique 0	privé 1
*/

CREATE TABLE !table! ( 
user_id 								INTEGER NOT NULL,
user_nom								VARCHAR(255),
user_login								VARCHAR(255),
user_password							VARCHAR(255),
user_date_inscription					INTEGER,
user_status								INTEGER,
user_role_fonction						INTEGER,
user_droit_forum						INTEGER,

user_email								VARCHAR(255),
user_msn								VARCHAR(255),
user_aim								VARCHAR(255),
user_icq								VARCHAR(255),
user_yim								VARCHAR(255),
user_website							VARCHAR(255),

user_perso_nom							VARCHAR(255),
user_perso_pays							VARCHAR(255),
user_perso_ville						VARCHAR(255),
user_perso_occupation					VARCHAR(255),
user_perso_interet						VARCHAR(255),

user_derniere_visite					INTEGER,
user_derniere_ip						VARCHAR(15),
user_timezone							INTEGER,
user_lang								INTEGER,

user_pref_theme							INTEGER,
user_pref_newsletter					INTEGER,
user_pref_montre_email					INTEGER,
user_pref_montre_status_online			INTEGER,
user_pref_notification_reponse_forum	INTEGER,
user_pref_notification_nouveau_pm		INTEGER,
user_pref_autorise_bbcode				INTEGER,
user_pref_autorise_html					INTEGER,
user_pref_autorise_smilies				INTEGER,

user_image_avatar						VARCHAR(255),
user_admin_commentaire					VARCHAR(255), 

PRIMARY KEY (user_id)

);
