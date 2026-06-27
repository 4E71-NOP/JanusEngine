/* ---------------------------------------- */
/* Foreign keys: fk_usr_id      			*/
/* ---------------------------------------- */

CREATE TABLE !table! (
ui_id	            BYTEA NOT NULL UNIQUE, 
fk_user_id			BYTEA,
fk_upe_id           BYTEA,
ui_string		    VARCHAR(1024),
ui_number 		    BYTEA,

PRIMARY KEY (ui_id)
);
