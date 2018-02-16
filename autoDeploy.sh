rm -rf /home/spiffpitt/public_html/
wget -P /home/spiffpitt/public_html https://github.com/spiffpitt/WEBD-2006-Project/archive/master.zip
unzip /home/spiffpitt/public_html/master.zip -d /home/spiffpitt/public_html/
rm /home/spiffpitt/public_html/master.zip
mv /home/spiffpitt/public_html/WEBD-2006-Project-master/r8mydog/* /home/spiffpitt/public_html/
rm -rf /home/spiffpitt/public_html/WEBD-2006-Project-master
