/*----------------------------------------------------------------------------------------------------------------------------------*/
/*	Defninit la table de description des themes																						*/
/*----------------------------------------------------------------------------------------------------------------------------------*/
/*	theme_admctrl_position		1 H-G	2 H-M	3 H-D	4 M-D	5 B-D	6 B-M	7 B-G	8 M-G										*/
/*----------------------------------------------------------------------------------------------------------------------------------*/

CREATE TABLE !table! (
theme_id				INTEGER NOT NULL,
theme_repertoire		VARCHAR(128),
theme_nom 				VARCHAR(128),
theme_titre				VARCHAR(128),
theme_desc				VARCHAR(128),
theme_date				INTEGER,

theme_stylesheet_1		VARCHAR(128),
theme_stylesheet_2		VARCHAR(128),
theme_stylesheet_3		VARCHAR(128),
theme_stylesheet_4		VARCHAR(128),
theme_stylesheet_5		VARCHAR(128),

theme_bg				VARCHAR(128),
theme_bg_repeat			VARCHAR(128),
theme_bg_color			VARCHAR(128),
theme_blason			VARCHAR(128),
theme_banniere			VARCHAR(128),

theme_divinitial_bg		VARCHAR(128),
theme_divinitial_repeat	VARCHAR(128),
theme_divinitial_dx		INTEGER,
theme_divinitial_dy		INTEGER,

theme_bloc_01_nom		VARCHAR(128),		theme_bloc_01_texte		VARCHAR(128),
theme_bloc_02_nom		VARCHAR(128),		theme_bloc_02_texte		VARCHAR(128),
theme_bloc_03_nom		VARCHAR(128),		theme_bloc_03_texte		VARCHAR(128),
theme_bloc_04_nom		VARCHAR(128),		theme_bloc_04_texte		VARCHAR(128),
theme_bloc_05_nom		VARCHAR(128),		theme_bloc_05_texte		VARCHAR(128),
theme_bloc_06_nom		VARCHAR(128),		theme_bloc_06_texte		VARCHAR(128),
theme_bloc_07_nom		VARCHAR(128),		theme_bloc_07_texte		VARCHAR(128),
theme_bloc_08_nom		VARCHAR(128),		theme_bloc_08_texte		VARCHAR(128),
theme_bloc_09_nom		VARCHAR(128),		theme_bloc_09_texte		VARCHAR(128),
theme_bloc_10_nom		VARCHAR(128),		theme_bloc_10_texte		VARCHAR(128),

theme_bloc_11_nom		VARCHAR(128),		theme_bloc_11_texte		VARCHAR(128),
theme_bloc_12_nom		VARCHAR(128),		theme_bloc_12_texte		VARCHAR(128),
theme_bloc_13_nom		VARCHAR(128),		theme_bloc_13_texte		VARCHAR(128),
theme_bloc_14_nom		VARCHAR(128),		theme_bloc_14_texte		VARCHAR(128),
theme_bloc_15_nom		VARCHAR(128),		theme_bloc_15_texte		VARCHAR(128),
theme_bloc_16_nom		VARCHAR(128),		theme_bloc_16_texte		VARCHAR(128),
theme_bloc_17_nom		VARCHAR(128),		theme_bloc_17_texte		VARCHAR(128),
theme_bloc_18_nom		VARCHAR(128),		theme_bloc_18_texte		VARCHAR(128),
theme_bloc_19_nom		VARCHAR(128),		theme_bloc_19_texte		VARCHAR(128),
theme_bloc_20_nom		VARCHAR(128),		theme_bloc_20_texte		VARCHAR(128),

theme_bloc_21_nom		VARCHAR(128),		theme_bloc_21_texte		VARCHAR(128),
theme_bloc_22_nom		VARCHAR(128),		theme_bloc_22_texte		VARCHAR(128),
theme_bloc_23_nom		VARCHAR(128),		theme_bloc_23_texte		VARCHAR(128),
theme_bloc_24_nom		VARCHAR(128),		theme_bloc_24_texte		VARCHAR(128),
theme_bloc_25_nom		VARCHAR(128),		theme_bloc_25_texte		VARCHAR(128),
theme_bloc_26_nom		VARCHAR(128),		theme_bloc_26_texte		VARCHAR(128),
theme_bloc_27_nom		VARCHAR(128),		theme_bloc_27_texte		VARCHAR(128),
theme_bloc_28_nom		VARCHAR(128),		theme_bloc_28_texte		VARCHAR(128),
theme_bloc_29_nom		VARCHAR(128),		theme_bloc_29_texte		VARCHAR(128),
theme_bloc_30_nom		VARCHAR(128),		theme_bloc_30_texte		VARCHAR(128),

theme_bloc_00_menu		VARCHAR(128),
theme_bloc_01_menu		VARCHAR(128),
theme_bloc_02_menu		VARCHAR(128),
theme_bloc_03_menu		VARCHAR(128),
theme_bloc_04_menu		VARCHAR(128),
theme_bloc_05_menu		VARCHAR(128),
theme_bloc_06_menu		VARCHAR(128),
theme_bloc_07_menu		VARCHAR(128),
theme_bloc_08_menu		VARCHAR(128),
theme_bloc_09_menu		VARCHAR(128),

theme_admctrl_panel_bg		VARCHAR(128),
theme_admctrl_switch_bg		VARCHAR(128),
theme_admctrl_size_x		INTEGER,
theme_admctrl_size_y		INTEGER,
theme_admctrl_position		INTEGER,

theme_couleur_jauge_depart	VARCHAR(10),
theme_couleur_jauge_milieu	VARCHAR(10),
theme_couleur_jauge_fin		VARCHAR(10),

PRIMARY KEY (theme_id)
);
