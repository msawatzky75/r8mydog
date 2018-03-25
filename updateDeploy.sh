homedir=/home/spiffpitt
reponame=r8mydog
#update the auto deploy
chmod /home/spiffpitt/autoDeploy.sh 775
mv $homedir/public_html/$reponame-master/autoDeploy.sh $homedir

#remove uneeded files
#rm -rf $homedir/public_html/$reponame-master
