/*----------------------------------------------------------------------------------------------------------------------------------*/
/*	Defninit la table des bouclages																									*/
/*----------------------------------------------------------------------------------------------------------------------------------*/
/* Clefs etrangeres   																												*/ 
/*	site_id																															*/
/*	user_id																															*/
/*----------------------------------------------------------------------------------------------------------------------------------*/
/*
bouclage_etat 				OFFLINE 0	ONLINE 1	SUPPRIME 2
*/
CREATE TABLE !table! (
bouclage_id 				INTEGER NOT NULL,
bouclage_nom 				VARCHAR(255),
bouclage_titre 				VARCHAR(255),
bouclage_etat 				INTEGER,
bouclage_date_creation 		INTEGER,
bouclage_date_limite 		INTEGER,
site_id						INTEGER,
user_id						INTEGER,
PRIMARY KEY (bouclage_id)
);
