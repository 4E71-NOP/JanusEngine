/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
CREATE TABLE !table! ( 
st_id				BIGINT NOT NULL UNIQUE, 
st_creation			INTEGER,
st_action			VARCHAR(255),
st_login			VARCHAR(255),
st_email			VARCHAR(255),
st_content 			VARCHAR(1024),
PRIMARY KEY (st_id)
);
