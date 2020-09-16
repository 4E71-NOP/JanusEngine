/*----------------------------------------------------------------------------------------------------------------------------------*/
/*	Defninit la table des fichiers des extensions																					*/
/*----------------------------------------------------------------------------------------------------------------------------------*/
/* Clefs etrangeres   																												*/
/* extension_id 																													*/
/*----------------------------------------------------------------------------------------------------------------------------------*/
CREATE TABLE !table! ( 
fichier_id					INTEGER NOT NULL, 
extension_id				INTEGER,
extension_nom				VARCHAR(255), 
fichier_nom					VARCHAR(255), 
fichier_nom_generique		VARCHAR(255), 
fichier_type				INTEGER, 
PRIMARY KEY (fichier_id)
);
