/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
CREATE TABLE !table! (
inst_id			BIGINT NOT NULL UNIQUE, 
inst_display	INTEGER DEFAULT 1,
inst_name		VARCHAR(100),
inst_nbr		INTEGER DEFAULT 0,
inst_txt		VARCHAR(255),

PRIMARY KEY (inst_id), 
KEY idx_!IdxNom!_inst_name (inst_name)
);
