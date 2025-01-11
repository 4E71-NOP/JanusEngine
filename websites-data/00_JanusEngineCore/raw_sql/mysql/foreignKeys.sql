
ALTER TABLE !table_group_website! ADD CONSTRAINT Ht_group_website_FK_A FOREIGN KEY (fk_ws_id) REFERENCES !table_website!(ws_id);
ALTER TABLE !table_group_website! ADD CONSTRAINT Ht_group_website_FK_B FOREIGN KEY (fk_group_id) REFERENCES !table_group!(group_id);

ALTER TABLE !table_group_user! ADD CONSTRAINT Ht_group_user_FK_A FOREIGN KEY (fk_group_id) REFERENCES !table_group!(group_id);
ALTER TABLE !table_group_user! ADD CONSTRAINT Ht_group_user_FK_B FOREIGN KEY (fk_user_id) REFERENCES !table_user!(user_id);

ALTER TABLE !table_language_website! ADD CONSTRAINT Ht_language_website_FK_A FOREIGN KEY (fk_ws_id) REFERENCES !table_website!(ws_id);
ALTER TABLE !table_language_website! ADD CONSTRAINT Ht_language_website_FK_B FOREIGN KEY (fk_lang_id) REFERENCES !table_language!(lang_id);

ALTER TABLE !table_layout_theme! ADD CONSTRAINT Ht_layout_theme_FK_A FOREIGN KEY (fk_layout_id) REFERENCES !table_layout!(layout_id);
ALTER TABLE !table_layout_theme! ADD CONSTRAINT Ht_layout_theme_FK_B FOREIGN KEY (fk_theme_id) REFERENCES !table_theme_descriptor!(theme_id);

ALTER TABLE !table_module_website! ADD CONSTRAINT Ht_module_website_FK_A FOREIGN KEY (fk_module_id) REFERENCES !table_module!(module_id);
ALTER TABLE !table_module_website! ADD CONSTRAINT Ht_module_website_FK_B FOREIGN KEY (fk_ws_id) REFERENCES !table_website!(ws_id);

ALTER TABLE !table_theme_website! ADD CONSTRAINT Ht_theme_website_FK_A FOREIGN KEY (fk_theme_id) REFERENCES !table_theme_descriptor!(theme_id);
ALTER TABLE !table_theme_website! ADD CONSTRAINT Ht_theme_website_FK_B FOREIGN KEY (fk_ws_id) REFERENCES !table_website!(ws_id);

ALTER TABLE !table_article_tag! ADD CONSTRAINT Ht_article_tag_FK_A FOREIGN KEY (fk_arti_id) REFERENCES !table_article!(arti_id);
ALTER TABLE !table_article_tag! ADD CONSTRAINT Ht_article_tag_FK_B FOREIGN KEY (fk_tag_id) REFERENCES !table_tag!(tag_id);

ALTER TABLE !table_menu! ADD CONSTRAINT Ht_menu_FK_A FOREIGN KEY (fk_ws_id) REFERENCES !table_website!(ws_id);
ALTER TABLE !table_menu! ADD CONSTRAINT Ht_menu_FK_B FOREIGN KEY (fk_lang_id) REFERENCES !table_language!(lang_id);
ALTER TABLE !table_menu! ADD CONSTRAINT Ht_menu_FK_C FOREIGN KEY (fk_deadline_id) REFERENCES !table_deadline!(deadline_id);
ALTER TABLE !table_menu! ADD CONSTRAINT Ht_menu_FK_D FOREIGN KEY (fk_perm_id) REFERENCES !table_permission!(perm_id);

ALTER TABLE !table_document! ADD CONSTRAINT Ht_document_FK_A FOREIGN KEY (docu_creator) REFERENCES !table_user!(user_id);
ALTER TABLE !table_document! ADD CONSTRAINT Ht_document_FK_B FOREIGN KEY (docu_validator) REFERENCES !table_user!(user_id);

ALTER TABLE !table_document_share! ADD CONSTRAINT Ht_document_share_FK_A FOREIGN KEY (fk_docu_id) REFERENCES !table_document!(docu_id);
ALTER TABLE !table_document_share! ADD CONSTRAINT Ht_document_share_FK_B FOREIGN KEY (fk_ws_id) REFERENCES !table_website!(ws_id);

ALTER TABLE !table_keyword! ADD CONSTRAINT Ht_keyword_FK_A FOREIGN KEY (fk_arti_id) REFERENCES !table_article!(arti_id);
ALTER TABLE !table_keyword! ADD CONSTRAINT Ht_keyword_FK_B FOREIGN KEY (fk_ws_id) REFERENCES !table_website!(ws_id);

ALTER TABLE !table_note! ADD CONSTRAINT Ht_note_FK_A FOREIGN KEY (fk_docu_id) REFERENCES !table_document!(docu_id);
ALTER TABLE !table_note! ADD CONSTRAINT Ht_note_FK_B FOREIGN KEY (fk_user_id) REFERENCES !table_user!(user_id);

ALTER TABLE !table_tag! ADD CONSTRAINT Ht_tag_FK_A FOREIGN KEY (fk_ws_id) REFERENCES !table_website!(ws_id);

ALTER TABLE !table_extension! ADD CONSTRAINT Ht_extension_FK_A FOREIGN KEY (fk_ws_id) REFERENCES !table_website!(ws_id);

ALTER TABLE !table_extension_file! ADD CONSTRAINT Ht_extension_file_FK_A FOREIGN KEY (fk_extension_id) REFERENCES !table_extension!(extension_id);

ALTER TABLE !table_extension_dependency! ADD CONSTRAINT Ht_extension_dependency_FK_A FOREIGN KEY (fk_extension_id) REFERENCES !table_extension!(extension_id);

ALTER TABLE !table_article_config! ADD CONSTRAINT Ht_article_config_FK_A FOREIGN KEY (fk_ws_id) REFERENCES !table_website!(ws_id);

ALTER TABLE !table_i18n! ADD CONSTRAINT Ht_i18n_FK_A FOREIGN KEY (fk_lang_id) REFERENCES !table_language!(lang_id);

ALTER TABLE !table_extension_config! ADD CONSTRAINT Ht_extension_config_FK_A FOREIGN KEY (fk_ws_id) REFERENCES !table_website!(ws_id);

ALTER TABLE !table_deadline! ADD CONSTRAINT Ht_deadline_FK_A FOREIGN KEY (fk_ws_id) REFERENCES !table_website!(ws_id);
