/* ---------------------------------------- */
/* Foreign keys: fk_ui_name      			*/
/* ---------------------------------------- */

CREATE TABLE !table! (
upe_id	            BIGINT NOT NULL UNIQUE, 
upe_name		   	VARCHAR(255),
upe_translation		VARCHAR(255),
upe_state			BIGINT,
upe_type            BIGINT,
upe_length          BIGINT,
fk_ws_id            BIGINT,
PRIMARY KEY (upe_id)
);
