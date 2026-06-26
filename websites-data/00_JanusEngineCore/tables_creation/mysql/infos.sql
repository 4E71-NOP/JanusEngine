/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
/* 
*/
CREATE TABLE !table! ( 
info_id 			BINARY(16) NOT NULL UNIQUE,
info_id_str			CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(info_id))),
fk_infcfg_section	VARCHAR(255),
info_ref_obj		BINARY(16),
info_field			VARCHAR(255),
info_string			VARCHAR(1024),
info_number			INTEGER,

PRIMARY KEY (info_id)
);
