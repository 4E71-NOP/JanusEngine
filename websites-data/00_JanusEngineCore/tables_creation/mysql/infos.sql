/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
/* 
*/
CREATE TABLE !table! ( 
info_id 			BIGINT NOT NULL UNIQUE,
fk_infcfg_section	VARCHAR(255),
info_ref_obj		BIGINT,
info_field			VARCHAR(255),
info_string			VARCHAR(1024),
info_number			INTEGER,

PRIMARY KEY (info_id)
);
