/* ---------------------------------------- */
/* Foreign keys: site_id					*/
/* ---------------------------------------- */
/*
historique_signal	ERR 0	OK 1	WARN 2	INFO 3	AUTRE 4
*/

CREATE TABLE !table! (
historique_id			INTEGER NOT NULL,
site_id					INTEGER,
historique_date			INTEGER,
historique_initiateur	VARCHAR(255),
historique_action		BLOB,
historique_signal		INTEGER,
historique_msgid		VARCHAR(255),
historique_contenu		BLOB,

PRIMARY KEY (historique_id),
KEY idx_!IdxNom!_site_id (site_id)

);
