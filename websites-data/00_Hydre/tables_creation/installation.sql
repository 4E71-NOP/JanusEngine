/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
CREATE TABLE !table! (
inst_id			INTEGER NOT NULL,
inst_display	INTEGER,
inst_name		VARCHAR(100),
inst_nbr		INTEGER,
inst_txt		VARCHAR(255),

PRIMARY KEY (inst_name)

);
COMMIT;
