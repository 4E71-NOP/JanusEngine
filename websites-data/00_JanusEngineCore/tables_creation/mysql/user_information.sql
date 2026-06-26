/* ---------------------------------------- */
/* Foreign keys: fk_usr_id      			*/
/* ---------------------------------------- */

CREATE TABLE !table! (
ui_id	            BINARY(16) NOT NULL UNIQUE, 
ui_id_str			CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(ui_id))),
fk_user_id			BINARY(16),
fk_upe_id           BINARY(16),
ui_string		    VARCHAR(1024),
ui_number 		    BINARY(16),

PRIMARY KEY (ui_id)
);
