/* ---------------------------------------- */
/* Foreign keys: ws_id					*/
/* ---------------------------------------- */
CREATE TABLE !table! ( 
layout_id				BINARY(16) NOT NULL UNIQUE, 
layout_id_str			CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(layout_id))),
layout_name				VARCHAR(255),
layout_title			VARCHAR(255),
layout_generic_name 	VARCHAR(255),
layout_desc 			VARCHAR(255),
fk_layout_file_id	    BINARY(16),
PRIMARY KEY (layout_id)

);
