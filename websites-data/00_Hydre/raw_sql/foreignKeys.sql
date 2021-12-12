
ALTER TABLE Hdr.Ht_group_website ADD CONSTRAINT Ht_group_website_FK FOREIGN KEY (ws_id) REFERENCES Hdr.Ht_website(ws_id);
ALTER TABLE Hdr.Ht_group_website ADD CONSTRAINT Ht_group_website_FK_1 FOREIGN KEY (group_id) REFERENCES Hdr.Ht_group(group_id);



ALTER TABLE Hdr.Ht_group_user ADD CONSTRAINT Ht_group_user_FK FOREIGN KEY (group_id) REFERENCES Hdr.Ht_group(group_id);
ALTER TABLE Hdr.Ht_group_user ADD CONSTRAINT Ht_group_user_FK_1 FOREIGN KEY (user_id) REFERENCES Hdr.Ht_user(user_id);


ALTER TABLE Hdr.Ht_language_website ADD CONSTRAINT Ht_language_website_FK FOREIGN KEY (ws_id) REFERENCES Hdr.Ht_website(ws_id);
ALTER TABLE Hdr.Ht_language_website ADD CONSTRAINT Ht_language_website_FK_1 FOREIGN KEY (lang_id) REFERENCES Hdr.Ht_language(lang_id);



ALTER TABLE Hdr.Ht_layout_theme ADD CONSTRAINT Ht_layout_theme_FK FOREIGN KEY (layout_id) REFERENCES Hdr.Ht_layout(layout_id);
ALTER TABLE Hdr.Ht_layout_theme ADD CONSTRAINT Ht_layout_theme_FK_1 FOREIGN KEY (theme_id) REFERENCES Hdr.Ht_theme_descriptor(theme_id);


ALTER TABLE Hdr.Ht_module_website ADD CONSTRAINT Ht_module_website_FK FOREIGN KEY (module_id) REFERENCES Hdr.Ht_module(module_id);
ALTER TABLE Hdr.Ht_module_website ADD CONSTRAINT Ht_module_website_FK_1 FOREIGN KEY (ws_id) REFERENCES Hdr.Ht_website(ws_id);


ALTER TABLE Hdr.Ht_theme_website ADD CONSTRAINT Ht_theme_website_FK FOREIGN KEY (theme_id) REFERENCES Hdr.Ht_theme_descriptor(theme_id);
ALTER TABLE Hdr.Ht_theme_website ADD CONSTRAINT Ht_theme_website_FK_1 FOREIGN KEY (ws_id) REFERENCES Hdr.Ht_website(ws_id);


ALTER TABLE Hdr.Ht_article_tag ADD CONSTRAINT Ht_article_tag_FK FOREIGN KEY (arti_id) REFERENCES Hdr.Ht_article(arti_id);
ALTER TABLE Hdr.Ht_article_tag ADD CONSTRAINT Ht_article_tag_FK_1 FOREIGN KEY (tag_id) REFERENCES Hdr.Ht_tag(tag_id);



ALTER TABLE Hdr.Ht_category ADD CONSTRAINT Ht_category_FK FOREIGN KEY (ws_id) REFERENCES Hdr.Ht_website(ws_id);
ALTER TABLE Hdr.Ht_category ADD CONSTRAINT Ht_category_FK_1 FOREIGN KEY (lang_id) REFERENCES Hdr.Ht_language(lang_id);
ALTER TABLE Hdr.Ht_category ADD CONSTRAINT Ht_category_FK_2 FOREIGN KEY (deadline_id) REFERENCES Hdr.Ht_deadline(deadline_id);
ALTER TABLE Hdr.Ht_category ADD CONSTRAINT Ht_category_FK_3 FOREIGN KEY (group_id) REFERENCES Hdr.Ht_group(group_id);
/*
Trouver le moyen de faire arti_ref
*/


ALTER TABLE Hdr.Ht_document ADD CONSTRAINT Ht_document_FK FOREIGN KEY (docu_creator) REFERENCES Hdr.Ht_user(user_id);
ALTER TABLE Hdr.Ht_document ADD CONSTRAINT Ht_document_FK_1 FOREIGN KEY (docu_examiner) REFERENCES Hdr.Ht_user(user_id);

ALTER TABLE Hdr.Ht_document_share ADD CONSTRAINT Ht_document_share_FK FOREIGN KEY (docu_id) REFERENCES Hdr.Ht_document(docu_id);
ALTER TABLE Hdr.Ht_document_share ADD CONSTRAINT Ht_document_share_FK_1 FOREIGN KEY (ws_id) REFERENCES Hdr.Ht_website(ws_id);


ALTER TABLE Hdr.Ht_keyword ADD CONSTRAINT Ht_keyword_FK FOREIGN KEY (arti_id) REFERENCES Hdr.Ht_article(arti_id);
ALTER TABLE Hdr.Ht_keyword ADD CONSTRAINT Ht_keyword_FK_1 FOREIGN KEY (ws_id) REFERENCES Hdr.Ht_website(ws_id);


ALTER TABLE Hdr.Ht_layout_content ADD CONSTRAINT Ht_layout_content_FK FOREIGN KEY (layout_id) REFERENCES Hdr.Ht_layout(layout_id);

ALTER TABLE Hdr.Ht_log ADD CONSTRAINT Ht_log_FK FOREIGN KEY (ws_id) REFERENCES Hdr.Ht_website(ws_id);


/*
March po!
ALTER TABLE Hdr.Ht_module ADD CONSTRAINT Ht_module_FK FOREIGN KEY (module_group_allowed_to_see) REFERENCES Hdr.Ht_user(user_id);
ALTER TABLE Hdr.Ht_module ADD CONSTRAINT Ht_module_FK_1 FOREIGN KEY (module_group_allowed_to_use) REFERENCES Hdr.Ht_user(user_id);
*/


ALTER TABLE Hdr.Ht_note ADD CONSTRAINT Ht_note_FK FOREIGN KEY (docu_id) REFERENCES Hdr.Ht_document(docu_id);
ALTER TABLE Hdr.Ht_note ADD CONSTRAINT Ht_note_FK_1 FOREIGN KEY (user_id) REFERENCES Hdr.Ht_user(user_id);

ALTER TABLE Hdr.Ht_tag ADD CONSTRAINT Ht_tag_FK FOREIGN KEY (ws_id) REFERENCES Hdr.Ht_website(ws_id);


ALTER TABLE Hdr.Ht_extension ADD CONSTRAINT Ht_extension_FK FOREIGN KEY (ws_id) REFERENCES Hdr.Ht_website(ws_id);

ALTER TABLE Hdr.Ht_extension_file ADD CONSTRAINT Ht_extension_file_FK FOREIGN KEY (extension_id) REFERENCES Hdr.Ht_extension(extension_id);

ALTER TABLE Hdr.Ht_extension_dependency ADD CONSTRAINT Ht_extension_dependency_FK FOREIGN KEY (extension_id) REFERENCES Hdr.Ht_extension(extension_id);

ALTER TABLE Hdr.Ht_article_config ADD CONSTRAINT Ht_article_config_FK FOREIGN KEY (ws_id) REFERENCES Hdr.Ht_website(ws_id);

ALTER TABLE Hdr.Ht_i18n ADD CONSTRAINT Ht_i18n_FK FOREIGN KEY (lang_id) REFERENCES Hdr.Ht_language(lang_id);

ALTER TABLE Hdr.Ht_extension_config ADD CONSTRAINT Ht_extension_config_FK FOREIGN KEY (ws_id) REFERENCES Hdr.Ht_website(ws_id);


ALTER TABLE Hdr.Ht_deadline ADD CONSTRAINT Ht_deadline_FK FOREIGN KEY (user_id) REFERENCES Hdr.Ht_user(user_id);
ALTER TABLE Hdr.Ht_deadline ADD CONSTRAINT Ht_deadline_FK_1 FOREIGN KEY (ws_id) REFERENCES Hdr.Ht_website(ws_id);


























