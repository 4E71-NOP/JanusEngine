cd ../

# Basic entry points
rm index.htm index.html
ls -s index.php index.htm
ls -s index.php index.html

# Main content
rm current
ln -s vrs_20190905 current

# Define
cd current
ln -s define_development.php define.php
cd ../

#Configuration
cd current/config/
rm current
ln -s development current
cd ../../

# Layouts Rootwave
cd layouts/Rootwave/
rm *.lyt.html
./make_symbolic_link_for_lazy_ppl.sh
cd ../../
