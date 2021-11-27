/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
CREATE TABLE !table! ( 
user_perm_id		INTEGER,
fk_perm_id			INTEGER NOT NULL,
fk_user_id			INTEGER,

PRIMARY KEY (user_perm_id),
KEY idx_!IdxNom!_perm_id (fk_perm_id),
KEY idx_!IdxNom!_user_id (fk_user_id)
);
