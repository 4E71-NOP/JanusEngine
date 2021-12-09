/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */

CREATE TABLE !table! (
stored_event_id 			BIGINT NOT NULL UNIQUE, 
stored_event_date			INTEGER,
stored_event_object			VARCHAR(255),
stored_event_type			VARCHAR(255),

PRIMARY KEY (stored_event_id)

);

