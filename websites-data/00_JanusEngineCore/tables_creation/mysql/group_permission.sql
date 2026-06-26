/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
CREATE TABLE !table! ( 
group_perm_id		BINARY(16) NOT NULL UNIQUE, 
group_perm_id_str	CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(group_perm_id))),
fk_perm_id			BINARY(16),
fk_group_id			BINARY(16),

PRIMARY KEY (group_perm_id),
KEY idx_!IdxNom!_perm_id (fk_perm_id),
KEY idx_!IdxNom!_group_id (fk_group_id)
);
