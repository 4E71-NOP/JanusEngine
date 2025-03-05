/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
/* 
Type = number, char, timestamp
*/
CREATE TABLE !table! ( 
infcfg_id 			BIGINT NOT NULL UNIQUE,
fk_ws_id			BIGINT,
infcfg_section		VARCHAR(255),
infcfg_field		VARCHAR(255),
infcfg_label_ref	VARCHAR(255),
infcfg_enabled		INTEGER,
infcfg_type			INTEGER,
infcfg_order		INTEGER,

PRIMARY KEY (infcfg_id)
);
