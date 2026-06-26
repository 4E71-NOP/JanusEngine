/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
CREATE TABLE !table! ( 
perm_id				BINARY(16) NOT NULL UNIQUE, 
perm_id_str			CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(perm_id))),
perm_state			INTEGER,
perm_name 			VARCHAR(255),
perm_affinity		VARCHAR(255),
perm_object_type	VARCHAR(255),
perm_desc			VARCHAR(255),
perm_level			INTEGER,
PRIMARY KEY (perm_id)
);
