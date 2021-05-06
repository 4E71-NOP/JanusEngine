/* ---------------------------------------- */
/* Foreign keys: theme_id					*/
/* ---------------------------------------- */

CREATE TABLE !table! ( 
ws_id				INTEGER NOT NULL,
ws_name				VARCHAR(255),
ws_short			VARCHAR(255),
fk_lang_id			INTEGER,
ws_lang_select		INTEGER,
fk_theme_id			INTEGER,
ws_title			VARCHAR(255),
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

row_creation		TIMESTAMP NULL NULL,
row_user_creation	VARCHAR(255),
row_update			TIMESTAMP NULL NULL,
row_user_update		VARCHAR(255),
row_disabled		TIMESTAMP NULL NULL,
row_user_disabled	VARCHAR(255),

PRIMARY KEY (ws_id),
KEY idx_!IdxNom!_theme_id (fk_theme_id)

);
