/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
CREATE TABLE !table! (
inst_id			BINARY(16) NOT NULL UNIQUE, 
inst_id_str		CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(inst_id))),
inst_display	INTEGER DEFAULT 1,
inst_name		VARCHAR(100) NOT NULL,
inst_nbr		INTEGER DEFAULT 0,
inst_txt		VARCHAR(255),

PRIMARY KEY (inst_id), 
KEY idx_!IdxNom!_inst_name (inst_name)
);

/*
CREATE INDEX idx_!IdxNom!_inst_name ON !table! (inst_name);
*/
