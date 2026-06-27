/* ---------------------------------------- */
/* Foreign keys: user_id, group_id 			*/
/* ---------------------------------------- */
/* group_user_initial_group NON 0 OUI 1		*/

CREATE TABLE !table! ( 
group_user_id				BIGINT NOT NULL UNIQUE, 
fk_group_id					BIGINT,
fk_user_id					BIGINT,
group_user_initial_group	INTEGER,

PRIMARY KEY (group_user_id)

);