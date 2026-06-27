/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
CREATE TABLE !table! ( 
group_perm_id		BYTEA NOT NULL UNIQUE, 
fk_perm_id			BYTEA,
fk_group_id			BYTEA,

PRIMARY KEY (group_perm_id)


);
