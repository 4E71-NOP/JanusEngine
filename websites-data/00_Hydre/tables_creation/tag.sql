/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */

CREATE TABLE !table! (
tag_id		INTEGER NOT NULL, 
tag_nom		VARCHAR(64), 
tag_html	VARCHAR(64), 
site_id		INTEGER, 

PRIMARY KEY (tag_id),
KEY idx_!IdxNom!_site_id (site_id)

);
