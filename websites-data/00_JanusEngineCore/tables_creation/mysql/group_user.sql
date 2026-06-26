/* ---------------------------------------- */
/* Foreign keys: user_id, group_id 			*/
/* ---------------------------------------- */
/* group_user_initial_group NON 0 OUI 1		*/

CREATE TABLE !table! ( 
group_user_id				BINARY(16) NOT NULL UNIQUE, 
group_user_id_str			CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(group_user_id))),
fk_group_id					BINARY(16),
fk_user_id					BINARY(16),
group_user_initial_group	INTEGER,

PRIMARY KEY (group_user_id),
KEY idx_!IdxNom!_group_id (fk_group_id),
KEY idx_!IdxNom!_user_id (fk_user_id)
);