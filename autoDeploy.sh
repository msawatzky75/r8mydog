#delete old files
rm -rf /home/spiffpitt/public_html/
#download the new ones
wget -P /home/spiffpitt/public_html https://github.com/spiffpitt/r8mydog/archive/master.zip
#unzip the new ones
unzip /home/spiffpitt/public_html/master.zip -d /home/spiffpitt/public_html/
#remove the new zip folder, it isnt needed anymore
rm /home/spiffpitt/public_html/master.zip

#allow the movement of hidden files
shopt -s dotglob
#move all files from the r8mydog folder to the root
mv /home/spiffpitt/public_html/r8mydog-master/r8mydog/* /home/spiffpitt/public_html/

#update the auto deploy
chmod /home/spiffpitt/autoDeploy.sh 775
mv /home/spiffpitt/public_html/r8mydog-master/autoDeploy.sh /home/spiffpitt/

#remove uneeded files
rm -rf /home/spiffpitt/public_html/r8mydog-master
#list the files for verification
#ls /home/spiffpitt/public_html/ -AGl
