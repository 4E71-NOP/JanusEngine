/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
CREATE TABLE !table! (
instreport_id		    BYTEA NOT NULL UNIQUE, 
instreport_section	    VARCHAR(255),
instreport_name		    VARCHAR(255),
instreport_ok      	    INTEGER,
instreport_wrn     	    INTEGER,
instreport_err     	    INTEGER,
instreport_start	    BYTEA,
instreport_end  	    BYTEA,
instreport_nbr_query  	INTEGER,
instreport_nbr_cmd  	INTEGER,

PRIMARY KEY (instreport_id)

);
