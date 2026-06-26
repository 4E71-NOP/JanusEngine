/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
CREATE TABLE !table! (
instreport_id		    BINARY(16) NOT NULL UNIQUE, 
instreport_id_str		CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(instreport_id))),
instreport_section	    VARCHAR(255),
instreport_name		    VARCHAR(255),
instreport_ok      	    INTEGER,
instreport_wrn     	    INTEGER,
instreport_err     	    INTEGER,
instreport_start	    BINARY(16),
instreport_end  	    BINARY(16),
instreport_nbr_query  	INTEGER,
instreport_nbr_cmd  	INTEGER,

PRIMARY KEY (instreport_id), 
KEY idx_!IdxNom!_instreport_name (instreport_name)
);
