/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
CREATE TABLE !table! ( 
group_perm_id		INTEGER,
fk_perm_id			INTEGER NOT NULL,
fk_group_id			INTEGER,

PRIMARY KEY (group_perm_id),
KEY idx_!IdxNom!_perm_id (fk_perm_id),
KEY idx_!IdxNom!_group_id (fk_group_id)
);
