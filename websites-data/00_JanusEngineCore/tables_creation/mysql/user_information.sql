/* ---------------------------------------- */
/* Foreign keys: fk_usr_id      			*/
/* ---------------------------------------- */

CREATE TABLE !table! (
ui_id	            BIGINT NOT NULL UNIQUE, 
fk_usr_id			BIGINT,
fk_upe_id           BIGINT,
ui_string		    VARCHAR(1024),
ui_number 		    BIGINT,

PRIMARY KEY (ui_id)
);
