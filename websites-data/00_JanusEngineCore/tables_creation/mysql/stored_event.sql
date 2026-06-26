/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */

CREATE TABLE !table! (
stored_event_id 		BINARY(16) NOT NULL UNIQUE, 
stored_event_id_str		CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(stored_event_id))),
stored_event_date		INTEGER,
stored_event_object		VARCHAR(255),
stored_event_type		VARCHAR(255),

PRIMARY KEY (stored_event_id)

);

