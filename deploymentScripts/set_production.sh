cd ../

# Basic entry points
rm index.htm index.html
ln -s index.php index.htm
ln -s index.php index.html

# Main content
rm current
ln -s vrs_20190905 current

# Define
cd current
rm define.php
ln -s define_production.php define.php
cd ../

#Configuration
cd current/config/
rm current
ln -s production current
cd ../../

# Layouts Rootwave
cd layouts/Rootwave/
rm *.lyt.html
./make_symbolic_link_for_lazy_ppl.sh
cd ../../

# PHPmailer
cd current/engine/extlib/phpmailer/
rm current
ln -s 6.9.3 current
