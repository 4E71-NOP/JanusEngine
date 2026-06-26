/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
CREATE TABLE !table! ( 
i18n_id			BINARY(16) NOT NULL UNIQUE, 
i18n_id_str		CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(i18n_id))),
fk_lang_id		BINARY(16),
i18n_package	VARCHAR(255),
i18n_name		VARCHAR(255),
i18n_text		VARCHAR(255),

PRIMARY KEY (i18n_id),
KEY idx_!IdxNom!_i18n_name (i18n_name)

);

