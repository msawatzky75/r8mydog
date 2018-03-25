homedir=/home/spiffpitt
reponame=r8mydog
#delete old files
rm -rf $homedir/public_html/
#download the new ones
wget -P $homedir/public_html https://github.com/spiffpitt/$reponame/archive/master.zip
#unzip the new ones
unzip $homedir/public_html/master.zip -d $homedir/public_html/
#remove the new zip folder, it isnt needed anymore
rm $homedir/public_html/master.zip

#update the auto deploy
chmod /home/spiffpitt/autoDeploy.sh 775
mv $homedir/public_html/$reponame-master/autoDeploy.sh $homedir

#allow the movement of hidden files
shopt -s dotglob
#move all files from the r8mydog folder to the root
mv $homedir/public_html/$reponame-master/r8mydog/* $homedir/public_html/

#remove uneeded files
rm -rf $homedir/public_html/$reponame-master
#list the files for verification
#ls /home/spiffpitt/public_html/ -AGl
