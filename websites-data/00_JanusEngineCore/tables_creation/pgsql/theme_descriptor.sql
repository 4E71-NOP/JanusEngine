/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
/*
theme_admctrl_position		1 H-G	2 H-M	3 H-D	4 M-D	5 B-D	6 B-M	7 B-G	8 M-G
*/

CREATE TABLE !table! (
theme_id	BIGINT NOT NULL UNIQUE, 
theme_name 	VARCHAR(128),
theme_title	VARCHAR(128),
theme_desc	VARCHAR(128),
theme_date	INTEGER,

PRIMARY KEY (theme_id)

);
