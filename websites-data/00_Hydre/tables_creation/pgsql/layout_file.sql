/* ----------------------------------------- */
/* Foreign keys: layout_id				*/
/* ----------------------------------------- */
CREATE TABLE !table! (
layout_file_id				BIGINT NOT NULL UNIQUE, 
layout_file_name			VARCHAR(255),
layout_file_generic_name	VARCHAR(255),
layout_file_filename		VARCHAR(255),
layout_file_desc 			VARCHAR(255),

PRIMARY KEY (layout_file_id)

);
