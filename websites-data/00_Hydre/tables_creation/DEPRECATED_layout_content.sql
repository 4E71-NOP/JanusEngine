/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
CREATE TABLE !table! ( 
lyoc_id						INTEGER NOT NULL,
fk_layout_id				INTEGER,
lyoc_line					INTEGER,
lyoc_minimum_x				INTEGER,
lyoc_minimum_y				INTEGER,
lyoc_module_name			VARCHAR(255),
lyoc_calculation_type		INTEGER,
lyoc_position_x				INTEGER,
lyoc_position_y				INTEGER,
lyoc_size_x 				INTEGER,
lyoc_size_y					INTEGER,
lyoc_module_anchor_e1a		VARCHAR(255),	lyoc_anchor_ex1a	INTEGER,		lyoc_anchor_ey1a	INTEGER,
lyoc_module_anchor_e1b		VARCHAR(255),	lyoc_anchor_ex1b	INTEGER,		lyoc_anchor_ey1b	INTEGER,
lyoc_module_anchor_e1c		VARCHAR(255),	lyoc_anchor_ex1c	INTEGER,		lyoc_anchor_ey1c	INTEGER,
lyoc_module_anchor_e1d		VARCHAR(255),	lyoc_anchor_ex1d	INTEGER,		lyoc_anchor_ey1d	INTEGER,
lyoc_module_anchor_e1e		VARCHAR(255),	lyoc_anchor_ex1e	INTEGER,		lyoc_anchor_ey1e	INTEGER,

lyoc_module_anchor_e2a		VARCHAR(255),	lyoc_anchor_ex2a	INTEGER,		lyoc_anchor_ey2a	INTEGER,
lyoc_module_anchor_e2b		VARCHAR(255),	lyoc_anchor_ex2b	INTEGER,		lyoc_anchor_ey2b	INTEGER,
lyoc_module_anchor_e2c		VARCHAR(255),	lyoc_anchor_ex2c	INTEGER,		lyoc_anchor_ey2c	INTEGER,
lyoc_module_anchor_e2d		VARCHAR(255),	lyoc_anchor_ex2d	INTEGER,		lyoc_anchor_ey2d	INTEGER,
lyoc_module_anchor_e2e		VARCHAR(255),	lyoc_anchor_ex2e	INTEGER,		lyoc_anchor_ey2e	INTEGER,

lyoc_module_anchor_e3a		VARCHAR(255),	lyoc_anchor_ex3a	INTEGER,		lyoc_anchor_ey3a	INTEGER,
lyoc_module_anchor_e3b		VARCHAR(255),	lyoc_anchor_ex3b	INTEGER,		lyoc_anchor_ey3b	INTEGER,
lyoc_module_anchor_e3c		VARCHAR(255),	lyoc_anchor_ex3c	INTEGER,		lyoc_anchor_ey3c	INTEGER,
lyoc_module_anchor_e3d		VARCHAR(255),	lyoc_anchor_ex3d	INTEGER,		lyoc_anchor_ey3d	INTEGER,
lyoc_module_anchor_e3e		VARCHAR(255),	lyoc_anchor_ex3e	INTEGER,		lyoc_anchor_ey3e	INTEGER,

lyoc_anchor_dx10			INTEGER,		lyoc_anchor_dy10	INTEGER,
lyoc_anchor_dx20			INTEGER,		lyoc_anchor_dy20	INTEGER,
lyoc_anchor_dx30			INTEGER,		lyoc_anchor_dy30	INTEGER,

lyoc_margin_left	INTEGER,
lyoc_margin_right	INTEGER,
lyoc_margin_top		INTEGER,
lyoc_margin_bottom	INTEGER,

lyoc_module_zindex	INTEGER,

PRIMARY KEY (lyoc_id),
KEY idx_!IdxNom!_layout_id (fk_layout_id)

);
