/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
CREATE TABLE !table! ( 
perm_id				INTEGER NOT NULL,
perm_name 			VARCHAR(255),
perm_object_type	VARCHAR(255),
perm_level			INTEGER,
PRIMARY KEY (perm_id)
);
