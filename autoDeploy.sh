#delete old files
rm -rf /home/spiffpitt/public_html/
#download the new ones
wget -P /home/spiffpitt/public_html https://github.com/spiffpitt/WEBD-2006-Project/archive/master.zip
#unzip the new ones
unzip /home/spiffpitt/public_html/master.zip -d /home/spiffpitt/public_html/
#remove the new zip folder, it isnt needed anymore
rm /home/spiffpitt/public_html/master.zip

#allow the movement of hidden files
shopt -s dotglob
#move all files from the r8mydog folder to the root
mv /home/spiffpitt/public_html/WEBD-2006-Project-master/r8mydog/* /home/spiffpitt/public_html/

#update the auto deploy
mv /home/spiffpitt/public_html/WEBD-2006-Project-master/autoDeploy.sh /home/spiffpitt/
chmod /home/spiffpitt/autoDeploy.sh 775

#remove uneeded files
rm -rf /home/spiffpitt/public_html/WEBD-2006-Project-master
#list the files for verification
ls /home/spiffpitt/public_html/ -AGl
