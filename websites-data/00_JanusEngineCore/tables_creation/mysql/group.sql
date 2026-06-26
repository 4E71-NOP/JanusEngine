/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
/*
group_tag		ANONYME 0	LECTEUR 1	STAFF 2	SENIOR_STAFF 3
*/
CREATE TABLE !table! ( 
group_id		BINARY(16) NOT NULL UNIQUE, 
group_id_str	CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(group_id))),
group_parent	BINARY(16),
group_tag		INTEGER,
group_name		VARCHAR (255),
group_title		VARCHAR (255),
group_file		VARCHAR (255),
group_desc		VARCHAR (255),

PRIMARY KEY (group_id),
KEY idx_!IdxNom!_group_parent (group_parent)

);
