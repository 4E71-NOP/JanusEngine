/* ---------------------------------------- */
/* Foreign keys: fk_usr_id      			*/
/* ---------------------------------------- */

CREATE TABLE !table! (
ui_id	            BIGINT NOT NULL UNIQUE, 
fk_usr_id			BIGINT,
ui_name		        VARCHAR(255),
ui_type			    BIGINT,
ui_data_string		VARCHAR(255),
ui_data_number 		BIGINT,

PRIMARY KEY (ui_id),
);
