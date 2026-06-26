/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */

CREATE TABLE !table! (
lang_id 			BINARY(16) NOT NULL UNIQUE, 
lang_id_str 		CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(lang_id))), 
lang_639_3			VARCHAR(255),
lang_original_name	VARCHAR(255),
lang_639_2			VARCHAR(255),
lang_639_1			VARCHAR(255),
lang_image			VARCHAR(255),

PRIMARY KEY (lang_id)

);
