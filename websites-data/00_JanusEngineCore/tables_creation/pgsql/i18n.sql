/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
CREATE TABLE !table! ( 
i18n_id			BIGINT NOT NULL UNIQUE, 
fk_lang_id		BIGINT,
i18n_package	VARCHAR(255),
i18n_name		VARCHAR(255),
i18n_text		VARCHAR(255),

PRIMARY KEY (i18n_id)

);

