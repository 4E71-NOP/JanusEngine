/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
CREATE TABLE !table! ( 
user_perm_id		BYTEA NOT NULL UNIQUE, 
fk_perm_id			BYTEA,
fk_user_id			BYTEA,

PRIMARY KEY (user_perm_id)


);
