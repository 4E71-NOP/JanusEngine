/* ---------------------------------------- */
/* Foreign keys: fk_ui_name      			*/
/* ---------------------------------------- */

CREATE TABLE !table! (
upe_id	            BIGINT NOT NULL UNIQUE, 
fk_ui_name			BIGINT,
upe_state			BIGINT,
upe_transaltion		VARCHAR(255),

PRIMARY KEY (upe_id)
);
