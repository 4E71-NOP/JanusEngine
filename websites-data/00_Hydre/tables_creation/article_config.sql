/* ---------------------------------------- */
/* Foreign keys: ws_id					*/
/* ---------------------------------------- */
/*
config_menu_type				1 table 2 menu_select
config_menu_style				1 normal 2 float
config_menu_float_position		0 none 1 left 2 right
config_menu_float_size_x		0 auto
config_menu_float_size_y		0 auto
config_menu_occurence			0 no_menu 1 top 2 bottom 3 both 4 store
*/

CREATE TABLE !table! (
config_id						INTEGER NOT NULL, 
config_name						VARCHAR(255), 
config_menu_type				INTEGER, 
config_menu_style				INTEGER, 
config_menu_float_position		INTEGER, 
config_menu_float_size_x		INTEGER, 
config_menu_float_size_y		INTEGER, 
config_menu_occurence			INTEGER, 
config_show_release_info		INTEGER,
config_show_info_update	INTEGER,
ws_id							INTEGER, 

PRIMARY KEY (config_id),
KEY idx_!IdxNom!_ws_id (ws_id)

);
