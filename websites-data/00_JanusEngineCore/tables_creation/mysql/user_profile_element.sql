/* ---------------------------------------- */
/* Foreign keys: fk_ui_name      			*/
/* ---------------------------------------- */

CREATE TABLE !table! (
upe_id	            BINARY(16) NOT NULL UNIQUE, 
upe_id_str			CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(upe_id))),
upe_name		   	VARCHAR(255),
upe_translation		VARCHAR(255),
upe_order			BIGINT,
upe_state			BIGINT,
upe_class           BIGINT,
upe_type            BIGINT,
upe_length          BIGINT,
fk_ws_id            BINARY(16),
PRIMARY KEY (upe_id)
);
