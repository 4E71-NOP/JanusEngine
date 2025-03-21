# --------------------------------------------------------------------------------------------
#
#	JnsEng - Janus Engine
#	Sous licence Creative common	
#	Under Creative Common licence	CC-by-nc-sa (http:#creativecommons.org)
#	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
#
#	(c)Faust MARIA DE AREVALO faust@multiweb-manager.net
#
# --------------------------------------------------------------------------------------------
echo 'Removing symlinks';

rm 05m00_groups.scr;
rm 05n00_groups_permissions.scr;
rm 06n00_users_persmission.scr;
rm 07m00_assign_users.scr;
rm 08m00_deadlines.scr;
rm 09m00_article_config.scr;
rm 10m00_modules.scr;
rm 12m00_articles_01_fra_pack_critique.scr;
rm 12m00_articles_02_eng_pack_critique.scr;
rm 12m01_articles_01_eng_pack_tools.scr;
rm 12m01_articles_01_fra_pack_tools.scr;
rm 13m00_admin_menus.scr;

echo 'Making symlinks';
ln -s ../../00_JanusEngineCore/script/05m00_groups.scr 05m00_groups.scr;
ln -s ../../00_JanusEngineCore/script/05n00_groups_permissions.scr 05n00_groups_permissions.scr;
ln -s ../../00_JanusEngineCore/script/06n00_users_persmission.scr 06n00_users_persmission.scr;
ln -s ../../00_JanusEngineCore/script/07m00_assign_users.scr 07m00_assign_users.scr;
ln -s ../../00_JanusEngineCore/script/08m00_deadlines.scr 08m00_deadlines.scr;
ln -s ../../00_JanusEngineCore/script/09m00_article_config.scr 09m00_article_config.scr;
ln -s ../../00_JanusEngineCore/script/10m00_modules.scr 10m00_modules.scr;
ln -s ../../00_JanusEngineCore/script/12m00_articles_01_fra_pack_critique.scr 12m00_articles_01_fra_pack_critique.scr;
ln -s ../../00_JanusEngineCore/script/12m00_articles_02_eng_pack_critique.scr 12m00_articles_02_eng_pack_critique.scr;
ln -s ../../00_JanusEngineCore/script/12m01_articles_01_eng_pack_tools.scr 12m01_articles_01_eng_pack_tools.scr;
ln -s ../../00_JanusEngineCore/script/12m01_articles_01_fra_pack_tools.scr 12m01_articles_01_fra_pack_tools.scr;
ln -s ../../00_JanusEngineCore/script/13m00_admin_menu.scr 13m00_admin_menus.scr;
echo "End";
