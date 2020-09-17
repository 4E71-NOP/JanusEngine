/* ---------------------------------------- */
/* Foreign keys: theme_id					*/
/* ---------------------------------------- */

CREATE TABLE !table! ( 
ws_id				INTEGER NOT NULL,
ws_name				VARCHAR(255),
ws_short			VARCHAR(255),
ws_lang				INTEGER,
ws_lang_select		INTEGER,
theme_id			INTEGER,
ws_title			VARCHAR(255),
ws_status_bar		VARCHAR(255),
ws_home				VARCHAR(255),
ws_directory		VARCHAR(255),
ws_state			INTEGER,
ws_info_debug		INTEGER,
ws_stylesheet		INTEGER,

ws_gal_mode			INTEGER,
ws_gal_file_tag		VARCHAR(255),
ws_gal_quality		INTEGER,
ws_gal_x			INTEGER,
ws_gal_y			INTEGER,
ws_gal_border		INTEGER,
ws_ma_diff			INTEGER,

PRIMARY KEY (ws_id),
KEY idx_!IdxNom!_theme_id (theme_id)

);
