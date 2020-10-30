/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
/*
theme_admctrl_position		1 H-G	2 H-M	3 H-D	4 M-D	5 B-D	6 B-M	7 B-G	8 M-G
*/

CREATE TABLE !table! (
theme_id				INTEGER NOT NULL,
theme_directory		VARCHAR(128),
theme_name 				VARCHAR(128),
theme_title				VARCHAR(128),
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
theme_logo			VARCHAR(128),
theme_banner			VARCHAR(128),

theme_divinitial_bg		VARCHAR(128),
theme_divinitial_repeat	VARCHAR(128),
theme_divinitial_dx		INTEGER,
theme_divinitial_dy		INTEGER,

theme_block_01_name		VARCHAR(128),		theme_block_01_text		VARCHAR(128),
theme_block_02_name		VARCHAR(128),		theme_block_02_text		VARCHAR(128),
theme_block_03_name		VARCHAR(128),		theme_block_03_text		VARCHAR(128),
theme_block_04_name		VARCHAR(128),		theme_block_04_text		VARCHAR(128),
theme_block_05_name		VARCHAR(128),		theme_block_05_text		VARCHAR(128),
theme_block_06_name		VARCHAR(128),		theme_block_06_text		VARCHAR(128),
theme_block_07_name		VARCHAR(128),		theme_block_07_text		VARCHAR(128),
theme_block_08_name		VARCHAR(128),		theme_block_08_text		VARCHAR(128),
theme_block_09_name		VARCHAR(128),		theme_block_09_text		VARCHAR(128),
theme_block_10_name		VARCHAR(128),		theme_block_10_text		VARCHAR(128),

theme_block_11_name		VARCHAR(128),		theme_block_11_text		VARCHAR(128),
theme_block_12_name		VARCHAR(128),		theme_block_12_text		VARCHAR(128),
theme_block_13_name		VARCHAR(128),		theme_block_13_text		VARCHAR(128),
theme_block_14_name		VARCHAR(128),		theme_block_14_text		VARCHAR(128),
theme_block_15_name		VARCHAR(128),		theme_block_15_text		VARCHAR(128),
theme_block_16_name		VARCHAR(128),		theme_block_16_text		VARCHAR(128),
theme_block_17_name		VARCHAR(128),		theme_block_17_text		VARCHAR(128),
theme_block_18_name		VARCHAR(128),		theme_block_18_text		VARCHAR(128),
theme_block_19_name		VARCHAR(128),		theme_block_19_text		VARCHAR(128),
theme_block_20_name		VARCHAR(128),		theme_block_20_text		VARCHAR(128),

theme_block_21_name		VARCHAR(128),		theme_block_21_text		VARCHAR(128),
theme_block_22_name		VARCHAR(128),		theme_block_22_text		VARCHAR(128),
theme_block_23_name		VARCHAR(128),		theme_block_23_text		VARCHAR(128),
theme_block_24_name		VARCHAR(128),		theme_block_24_text		VARCHAR(128),
theme_block_25_name		VARCHAR(128),		theme_block_25_text		VARCHAR(128),
theme_block_26_name		VARCHAR(128),		theme_block_26_text		VARCHAR(128),
theme_block_27_name		VARCHAR(128),		theme_block_27_text		VARCHAR(128),
theme_block_28_name		VARCHAR(128),		theme_block_28_text		VARCHAR(128),
theme_block_29_name		VARCHAR(128),		theme_block_29_text		VARCHAR(128),
theme_block_30_name		VARCHAR(128),		theme_block_30_text		VARCHAR(128),

theme_block_00_menu		VARCHAR(128),
theme_block_01_menu		VARCHAR(128),
theme_block_02_menu		VARCHAR(128),
theme_block_03_menu		VARCHAR(128),
theme_block_04_menu		VARCHAR(128),
theme_block_05_menu		VARCHAR(128),
theme_block_06_menu		VARCHAR(128),
theme_block_07_menu		VARCHAR(128),
theme_block_08_menu		VARCHAR(128),
theme_block_09_menu		VARCHAR(128),

theme_admctrl_panel_bg		VARCHAR(128),
theme_admctrl_switch_bg		VARCHAR(128),
theme_admctrl_width			INTEGER,
theme_admctrl_height		INTEGER,
theme_admctrl_position		INTEGER,

theme_gradient_start_color	VARCHAR(10),
theme_gradient_middle_color	VARCHAR(10),
theme_gradient_end_color		VARCHAR(10),

PRIMARY KEY (theme_id)

);
