/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
CREATE TABLE !table! ( 
perm_id				BIGINT NOT NULL UNIQUE, 
perm_state			INTEGER,
perm_name 			VARCHAR(255),
perm_affinity		VARCHAR(255),
perm_object_type	VARCHAR(255),
perm_desc			VARCHAR(255),
perm_level			INTEGER,

PRIMARY KEY (perm_id)

);
