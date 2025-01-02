
ALTER TABLE JnsEng.Ht_group_website ADD CONSTRAINT Ht_group_website_FK FOREIGN KEY (ws_id) REFERENCES JnsEng.Ht_website(ws_id);
ALTER TABLE JnsEng.Ht_group_website ADD CONSTRAINT Ht_group_website_FK_1 FOREIGN KEY (group_id) REFERENCES JnsEng.Ht_group(group_id);



ALTER TABLE JnsEng.Ht_group_user ADD CONSTRAINT Ht_group_user_FK FOREIGN KEY (group_id) REFERENCES JnsEng.Ht_group(group_id);
ALTER TABLE JnsEng.Ht_group_user ADD CONSTRAINT Ht_group_user_FK_1 FOREIGN KEY (user_id) REFERENCES JnsEng.Ht_user(user_id);


ALTER TABLE JnsEng.Ht_language_website ADD CONSTRAINT Ht_language_website_FK FOREIGN KEY (ws_id) REFERENCES JnsEng.Ht_website(ws_id);
ALTER TABLE JnsEng.Ht_language_website ADD CONSTRAINT Ht_language_website_FK_1 FOREIGN KEY (lang_id) REFERENCES JnsEng.Ht_language(lang_id);



ALTER TABLE JnsEng.Ht_layout_theme ADD CONSTRAINT Ht_layout_theme_FK FOREIGN KEY (layout_id) REFERENCES JnsEng.Ht_layout(layout_id);
ALTER TABLE JnsEng.Ht_layout_theme ADD CONSTRAINT Ht_layout_theme_FK_1 FOREIGN KEY (theme_id) REFERENCES JnsEng.Ht_theme_descriptor(theme_id);


ALTER TABLE JnsEng.Ht_module_website ADD CONSTRAINT Ht_module_website_FK FOREIGN KEY (module_id) REFERENCES JnsEng.Ht_module(module_id);
ALTER TABLE JnsEng.Ht_module_website ADD CONSTRAINT Ht_module_website_FK_1 FOREIGN KEY (ws_id) REFERENCES JnsEng.Ht_website(ws_id);


ALTER TABLE JnsEng.Ht_theme_website ADD CONSTRAINT Ht_theme_website_FK FOREIGN KEY (theme_id) REFERENCES JnsEng.Ht_theme_descriptor(theme_id);
ALTER TABLE JnsEng.Ht_theme_website ADD CONSTRAINT Ht_theme_website_FK_1 FOREIGN KEY (ws_id) REFERENCES JnsEng.Ht_website(ws_id);


ALTER TABLE JnsEng.Ht_article_tag ADD CONSTRAINT Ht_article_tag_FK FOREIGN KEY (arti_id) REFERENCES JnsEng.Ht_article(arti_id);
ALTER TABLE JnsEng.Ht_article_tag ADD CONSTRAINT Ht_article_tag_FK_1 FOREIGN KEY (tag_id) REFERENCES JnsEng.Ht_tag(tag_id);



ALTER TABLE JnsEng.Ht_menu ADD CONSTRAINT Ht_menu_FK FOREIGN KEY (ws_id) REFERENCES JnsEng.Ht_website(ws_id);
ALTER TABLE JnsEng.Ht_menu ADD CONSTRAINT Ht_menu_FK_1 FOREIGN KEY (lang_id) REFERENCES JnsEng.Ht_language(lang_id);
ALTER TABLE JnsEng.Ht_menu ADD CONSTRAINT Ht_menu_FK_2 FOREIGN KEY (deadline_id) REFERENCES JnsEng.Ht_deadline(deadline_id);
ALTER TABLE JnsEng.Ht_menu ADD CONSTRAINT Ht_menu_FK_3 FOREIGN KEY (group_id) REFERENCES JnsEng.Ht_group(group_id);
/*
Trouver le moyen de faire arti_ref
*/


ALTER TABLE JnsEng.Ht_document ADD CONSTRAINT Ht_document_FK FOREIGN KEY (docu_creator) REFERENCES JnsEng.Ht_user(user_id);
ALTER TABLE JnsEng.Ht_document ADD CONSTRAINT Ht_document_FK_1 FOREIGN KEY (docu_validator) REFERENCES JnsEng.Ht_user(user_id);

ALTER TABLE JnsEng.Ht_document_share ADD CONSTRAINT Ht_document_share_FK FOREIGN KEY (docu_id) REFERENCES JnsEng.Ht_document(docu_id);
ALTER TABLE JnsEng.Ht_document_share ADD CONSTRAINT Ht_document_share_FK_1 FOREIGN KEY (ws_id) REFERENCES JnsEng.Ht_website(ws_id);


ALTER TABLE JnsEng.Ht_keyword ADD CONSTRAINT Ht_keyword_FK FOREIGN KEY (arti_id) REFERENCES JnsEng.Ht_article(arti_id);
ALTER TABLE JnsEng.Ht_keyword ADD CONSTRAINT Ht_keyword_FK_1 FOREIGN KEY (ws_id) REFERENCES JnsEng.Ht_website(ws_id);


ALTER TABLE JnsEng.Ht_layout_content ADD CONSTRAINT Ht_layout_content_FK FOREIGN KEY (layout_id) REFERENCES JnsEng.Ht_layout(layout_id);

ALTER TABLE JnsEng.Ht_log ADD CONSTRAINT Ht_log_FK FOREIGN KEY (ws_id) REFERENCES JnsEng.Ht_website(ws_id);

ALTER TABLE JnsEng.Ht_note ADD CONSTRAINT Ht_note_FK FOREIGN KEY (docu_id) REFERENCES JnsEng.Ht_document(docu_id);
ALTER TABLE JnsEng.Ht_note ADD CONSTRAINT Ht_note_FK_1 FOREIGN KEY (user_id) REFERENCES JnsEng.Ht_user(user_id);

ALTER TABLE JnsEng.Ht_tag ADD CONSTRAINT Ht_tag_FK FOREIGN KEY (ws_id) REFERENCES JnsEng.Ht_website(ws_id);


ALTER TABLE JnsEng.Ht_extension ADD CONSTRAINT Ht_extension_FK FOREIGN KEY (ws_id) REFERENCES JnsEng.Ht_website(ws_id);

ALTER TABLE JnsEng.Ht_extension_file ADD CONSTRAINT Ht_extension_file_FK FOREIGN KEY (extension_id) REFERENCES JnsEng.Ht_extension(extension_id);

ALTER TABLE JnsEng.Ht_extension_dependency ADD CONSTRAINT Ht_extension_dependency_FK FOREIGN KEY (extension_id) REFERENCES JnsEng.Ht_extension(extension_id);

ALTER TABLE JnsEng.Ht_article_config ADD CONSTRAINT Ht_article_config_FK FOREIGN KEY (ws_id) REFERENCES JnsEng.Ht_website(ws_id);

ALTER TABLE JnsEng.Ht_i18n ADD CONSTRAINT Ht_i18n_FK FOREIGN KEY (lang_id) REFERENCES JnsEng.Ht_language(lang_id);

ALTER TABLE JnsEng.Ht_extension_config ADD CONSTRAINT Ht_extension_config_FK FOREIGN KEY (ws_id) REFERENCES JnsEng.Ht_website(ws_id);


ALTER TABLE JnsEng.Ht_deadline ADD CONSTRAINT Ht_deadline_FK FOREIGN KEY (user_id) REFERENCES JnsEng.Ht_user(user_id);
ALTER TABLE JnsEng.Ht_deadline ADD CONSTRAINT Ht_deadline_FK_1 FOREIGN KEY (ws_id) REFERENCES JnsEng.Ht_website(ws_id);


























