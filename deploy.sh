docker compose down
rm -Rf vendor
rm -f composer.lock
git pull
chmod 0777 .
chmod 0777 ./public/assets
docker compose up -d