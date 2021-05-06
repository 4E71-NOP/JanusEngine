/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
CREATE TABLE !table! ( 
i18n_id			INTEGER NOT NULL,
fk_lang_id		INTEGER,
i18n_package	VARCHAR(255),
i18n_name		VARCHAR(255),
i18n_text		VARCHAR(255),

PRIMARY KEY (i18n_id),
KEY idx_!IdxNom!_i18n_name (i18n_name)

);

