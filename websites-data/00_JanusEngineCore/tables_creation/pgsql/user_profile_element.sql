/* ---------------------------------------- */
/* Foreign keys: fk_ui_name      			*/
/* ---------------------------------------- */

CREATE TABLE !table! (
upe_id	            BYTEA NOT NULL UNIQUE, 
upe_name		   	VARCHAR(255),
upe_translation		VARCHAR(255),
upe_order			BIGINT,
upe_state			BIGINT,
upe_class           BIGINT,
upe_type            BIGINT,
upe_length          BIGINT,
fk_ws_id            BYTEA,
PRIMARY KEY (upe_id)
);
