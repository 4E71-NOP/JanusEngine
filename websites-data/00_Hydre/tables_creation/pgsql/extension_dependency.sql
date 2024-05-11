/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */

CREATE TABLE !table! ( 
dependency_id		BIGINT NOT NULL UNIQUE, 
fk_extension_id		BIGINT, 
extension_dep		INTEGER, 

PRIMARY KEY (dependency_id)

);
