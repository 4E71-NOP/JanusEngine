/* ---------------------------------------- */
/* Foreign keys: layout_id					*/
/* ---------------------------------------- */
CREATE TABLE !table! ( 
layoutfile_id				INTEGER NOT NULL,
layoutfile_name			    VARCHAR(255),
layoutfile_generic_name 	VARCHAR(255),
layoutfile_filename	    	VARCHAR(255),
layoutfile_desc 			VARCHAR(255),
PRIMARY KEY (layoutfile_id)

);
