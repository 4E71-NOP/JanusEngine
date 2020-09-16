/*----------------------------------------------------------------------------------------------------------------------------------*/
/*	Defninit la table des presentations																								*/
/*----------------------------------------------------------------------------------------------------------------------------------*/
/* Clefs etrangeres   																												*/ 
/*----------------------------------------------------------------------------------------------------------------------------------*/
CREATE TABLE !table! ( 
pres_cont_id				INTEGER NOT NULL,
pres_id						INTEGER,
pres_ligne					INTEGER,
pres_minimum_x				INTEGER,
pres_minimum_y				INTEGER,
pres_module_nom				VARCHAR(255),
pres_type_calcul			INTEGER,
pres_position_x				INTEGER,
pres_position_y				INTEGER,
pres_dimenssion_x 			INTEGER,
pres_dimenssion_y			INTEGER,
pres_module_ancre_e1a		VARCHAR(255),	pres_ancre_ex1a	INTEGER,		pres_ancre_ey1a	INTEGER,
pres_module_ancre_e1b		VARCHAR(255),	pres_ancre_ex1b	INTEGER,		pres_ancre_ey1b	INTEGER,
pres_module_ancre_e1c		VARCHAR(255),	pres_ancre_ex1c	INTEGER,		pres_ancre_ey1c	INTEGER,
pres_module_ancre_e1d		VARCHAR(255),	pres_ancre_ex1d	INTEGER,		pres_ancre_ey1d	INTEGER,
pres_module_ancre_e1e		VARCHAR(255),	pres_ancre_ex1e	INTEGER,		pres_ancre_ey1e	INTEGER,

pres_module_ancre_e2a		VARCHAR(255),	pres_ancre_ex2a	INTEGER,		pres_ancre_ey2a	INTEGER,
pres_module_ancre_e2b		VARCHAR(255),	pres_ancre_ex2b	INTEGER,		pres_ancre_ey2b	INTEGER,
pres_module_ancre_e2c		VARCHAR(255),	pres_ancre_ex2c	INTEGER,		pres_ancre_ey2c	INTEGER,
pres_module_ancre_e2d		VARCHAR(255),	pres_ancre_ex2d	INTEGER,		pres_ancre_ey2d	INTEGER,
pres_module_ancre_e2e		VARCHAR(255),	pres_ancre_ex2e	INTEGER,		pres_ancre_ey2e	INTEGER,

pres_module_ancre_e3a		VARCHAR(255),	pres_ancre_ex3a	INTEGER,		pres_ancre_ey3a	INTEGER,
pres_module_ancre_e3b		VARCHAR(255),	pres_ancre_ex3b	INTEGER,		pres_ancre_ey3b	INTEGER,
pres_module_ancre_e3c		VARCHAR(255),	pres_ancre_ex3c	INTEGER,		pres_ancre_ey3c	INTEGER,
pres_module_ancre_e3d		VARCHAR(255),	pres_ancre_ex3d	INTEGER,		pres_ancre_ey3d	INTEGER,
pres_module_ancre_e3e		VARCHAR(255),	pres_ancre_ex3e	INTEGER,		pres_ancre_ey3e	INTEGER,

pres_ancre_dx10				INTEGER,		pres_ancre_dy10	INTEGER,
pres_ancre_dx20				INTEGER,		pres_ancre_dy20	INTEGER,
pres_ancre_dx30				INTEGER,		pres_ancre_dy30	INTEGER,

pres_espacement_bord_gauche	INTEGER,
pres_espacement_bord_droite	INTEGER,
pres_espacement_bord_haut	INTEGER,
pres_espacement_bord_bas	INTEGER,

pres_module_zindex			INTEGER,

PRIMARY KEY (pres_cont_id)
);
