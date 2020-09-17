/* ---------------------------------------- */
/* Foreign keys: theme_id					*/
/* ---------------------------------------- */
/*
sw_lang				FRA 1	ENG 2		ESP 3
sw_lang_select		NON 0	OUI 1
sw_aide_dynamique	NON 0	OUI 1
sw_etat				OFFLINE 0	ONLINE 1	SUPPRIME 2	MAINTENANCE 3 VEROUILLE 1000
sw_stylesheet		STATIQUE 0	DYNAMIQUE 1
sw_gal_mode			OFF 0	BASE 1(base)	FICHIER 2 (FILE)
sw_ma_diff			NON 0	OUI 1
*/

CREATE TABLE !table! ( 
sw_id				INTEGER NOT NULL,
sw_nom				CHAR(255),
sw_abrege			CHAR(255),
sw_lang				INTEGER,
sw_lang_select		INTEGER,
theme_id			INTEGER,
sw_titre			CHAR(255),
sw_barre_status		CHAR(255),
sw_home				CHAR(255),
sw_repertoire		CHAR(255),
sw_etat				INTEGER,
sw_info_debug		INTEGER,
sw_stylesheet		INTEGER,

sw_gal_mode			INTEGER,
sw_gal_fichier_tag	CHAR(255),
sw_gal_qualite		INTEGER,
sw_gal_x			INTEGER,
sw_gal_y			INTEGER,
sw_gal_liserai		INTEGER,
sw_ma_diff			INTEGER,

PRIMARY KEY (sw_id),
KEY idx_!IdxNom!_theme_id (theme_id)

);

