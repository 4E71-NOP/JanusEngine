/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
CREATE TABLE !table! ( 
st_id				BINARY(16) NOT NULL UNIQUE, 
st_id_str			CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(st_id))),
st_creation			INTEGER,
st_action			VARCHAR(255),
st_login			VARCHAR(255),
st_email			VARCHAR(255),
st_content 			VARCHAR(1024),
PRIMARY KEY (st_id)
);
