/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */

CREATE TABLE !table! (
lang_id 			BIGINT NOT NULL UNIQUE, 
lang_639_3			VARCHAR(255),
lang_original_name	VARCHAR(255),
lang_639_2			VARCHAR(255),
lang_639_1			VARCHAR(255),
lang_image			VARCHAR(255),

PRIMARY KEY (lang_id)

);
