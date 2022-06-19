# sflogserver

simple log server,  
centralized logging for your application.  
this api receive error log, access log, etc...for separating log from your app/db

## prepare

1. clone or download and extract this repo
2. create db in your mariadb/mysql
3. import *sflogserver.sql* to your db
4. copy *app/konfigurasi.contoh.php* to *app/konfigurasi_strike.php*, ajust as your db setup
5. copy *env.contoh.php* to *env.php"

## run if using docker

1. open terminal dan goto folder sflogserver-docker  
   `cd sflogserver-docker`
2. update composer  
   `docker compose run --rm -w /app sflogserver php composer.phar update`
5. run container   
   `docker compose up -d`
6. check http://localhost:1170

## how to send log to sflogserver

check example in httpclient/req_sflogserver.http

## how to access log data

currently i dont provide user interface to access log data,
just use your mysql db gui

## note

stop container  
`docker compose down`

exec console (new container dan auto destroy)  
`docker compose run --rm web /app/console/run main`

enter container (new container and auto destroy)  
`docker compose run --rm web bash`

enter container  
`docker exec -it sflogserver-docker-sflogserver-1 bash`  
