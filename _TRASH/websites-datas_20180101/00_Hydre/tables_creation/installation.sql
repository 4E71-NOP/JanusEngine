/*----------------------------------------------------------------------------------------------------------------------------------*/
/*	Defninit la table du suivi de l'installation																						*/
/*----------------------------------------------------------------------------------------------------------------------------------*/
CREATE TABLE !table! (
install_id 					INTEGER NOT NULL,
install_etat_affichage 		INTEGER,
install_etat_nom 			VARCHAR(255),
install_etat_nombre			INTEGER,
install_etat_texte			VARCHAR(255),
PRIMARY KEY (install_id)
);
