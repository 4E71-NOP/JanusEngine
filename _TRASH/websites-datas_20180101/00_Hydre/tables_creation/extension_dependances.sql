/*----------------------------------------------------------------------------------------------------------------------------------*/
/*	Defninit la table des dépendances des extensions																				*/
/*----------------------------------------------------------------------------------------------------------------------------------*/
CREATE TABLE !table! ( 
dependance_id		INTEGER NOT NULL, 
extension_id		INTEGER, 
extension_dep		INTEGER, 

PRIMARY KEY (dependance_id)
);
