/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
CREATE TABLE !table! ( 
user_perm_id	BIGINT NOT NULL UNIQUE, 
fk_perm_id		BIGINT,
fk_user_id		BIGINT,

PRIMARY KEY (user_perm_id),
KEY idx_!IdxNom!_perm_id (fk_perm_id),
KEY idx_!IdxNom!_user_id (fk_user_id)
);
