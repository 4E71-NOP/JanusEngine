# --------------------------------------------------------------------------------------------
#
#	MWM - Multi Web Manager
#	Sous licence Creative common	
#	Under Creative Common licence	CC-by-nc-sa (http:#creativecommons.org)
#	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
#
#	(c)Faust MARIA DE AREVALO faust@multiweb-manager.net
#
# --------------------------------------------------------------------------------------------

echo "Suppression des fichiers/n"
cd script
rm -rf 05m00_groupes.scr 05m00_groupes.scr
rm -rf 07m00_assignement_utilisateurs.scr
rm -rf 08m00_bouclage.scr 08m00_bouclage.scr
rm -rf 09m00_article_config.scr
rm -rf 10m00_modules.scr 10m00_modules.scr
rm -rf 15m00_tag.scr 15m00_tag.scr
rm -rf 12o00_mot_cle_fra_mwm.scr
rm -rf 12m00_articles_01_fra_pack_critique.scr
rm -rf 12m00_articles_02_eng_pack_critique.scr
rm -rf 12m00_articles_01_fra_pack_par_defaut.scr
rm -rf 12m00_articles_02_eng_pack_par_defaut.scr
rm -rf 13m00_categories_admin.scr

echo "Creation des symlinks/n"
ln -s 05m00_groupes.scr 05m00_groupes.scr       ../../00_mwm/script/05m00_groupes.scr 05m00_groupes.scr
ln -s 07m00_assignement_utilisateurs.scr        ../../00_mwm/script/07m00_assignement_utilisateurs.scr
ln -s 08m00_bouclage.scr 08m00_bouclage.scr     ../../00_mwm/script/08m00_bouclage.scr 08m00_bouclage.scr
ln -s 09m00_article_config.scr                  ../../00_mwm/script/09m00_article_config.scr
ln -s 10m00_modules.scr 10m00_modules.scr       ../../00_mwm/script/10m00_modules.scr 10m00_modules.scr
ln -s 15m00_tag.scr 15m00_tag.scr               ../../00_mwm/script/15m00_tag.scr 15m00_tag.scr
ln -s 12o00_mot_cle_fra_mwm.scr                 ../../00_mwm/script/12o00_mot_cle_fra_mwm.scr
ln -s 12m00_articles_01_fra_pack_critique.scr   ../../00_mwm/script/12m00_articles_01_fra_pack_critique.scr
ln -s 12m00_articles_02_eng_pack_critique.scr   ../../00_mwm/script/12m00_articles_02_eng_pack_critique.scr
ln -s 12m00_articles_01_fra_pack_par_defaut.scr ../../00_mwm/script/12m00_articles_01_fra_pack_par_defaut.scr
ln -s 12m00_articles_02_eng_pack_par_defaut.scr ../../00_mwm/script/12m00_articles_02_eng_pack_par_defaut.scrln -s 13m00_categories_admin.scr                ../../00_mwm/script/13m00_categories_admin.scr

echo "Fin/n"
