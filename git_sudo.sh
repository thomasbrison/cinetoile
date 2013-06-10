cd ~/site_cinetoile/
sudo git commit -am $1 
sudo git push

cd /var/www/Cinetoile/
sudo git pull

cd ~/site_cinetoile/
