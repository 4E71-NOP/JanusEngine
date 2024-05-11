/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
CREATE TABLE !table! ( 
group_perm_id		BIGINT NOT NULL UNIQUE, 
fk_perm_id			BIGINT,
fk_group_id			BIGINT,

PRIMARY KEY (group_perm_id)

);
