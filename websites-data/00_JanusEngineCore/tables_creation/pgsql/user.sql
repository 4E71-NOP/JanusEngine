/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
/* 
user_status 		INACTIF 0	ACTIF 1	SUPPRIME 2
user_forum_access	OFF 0		ON 1
user_lang			FRA 1		ENG 2		ESP 3
user_role_function	publique 0	privé 1
*/

CREATE TABLE !table! ( 
user_id 						BIGINT NOT NULL UNIQUE,
user_name						VARCHAR(255),
user_login						VARCHAR(255),
user_password					VARCHAR(255),
user_subscription_date			INTEGER,
user_status						INTEGER,

user_role_function				INTEGER,
user_pref_theme					BIGINT,
user_lang						BIGINT,

user_avatar_image				VARCHAR(255),
user_admin_comment				VARCHAR(255), 

user_last_visit					INTEGER,
user_last_ip					VARCHAR(15),
user_timezone					INTEGER,

PRIMARY KEY (user_id)

);
