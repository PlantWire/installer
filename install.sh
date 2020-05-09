#!/bin/bash
if [[ $(id -u) -ne 0 ]] ; then echo "Please run as root" ; exit 1 ; fi

bold=$(tput bold)
normal=$(tput sgr0)

for i in "$@"
do
case $i in
#    -e=*|--extension=*)
#    EXTENSION="${i#*=}"
#    shift # past argument=value
#    ;;
    -h|--help)
    HELP=true
    shift # past argument with no value
    ;;
    -u|--uninstall)
    UNINSTALL=true
    shift # past argument with no value
    ;;
    *)
          # unknown option
    ;;
esac
done

if [ "$HELP" = true ]
then
    echo ""
    echo "#####################"
    echo "${bold}###pWire installer###"
    echo "#####################"
    echo "OPTIONS:${normal}"
    echo ""
    printf "\t -u, --uninstall:\n"
    printf "\t\t Uninstalls pwire-server and its dependencies.\n"
    printf "\t -h, --help:\n"
    printf "\t\t Shows this help message.\n"
else
    if [ "$UNINSTALL" != true ]
    then
        # Installer setup
        apt update
        apt -y install curl
        
        # Install Server
        cp redis.conf /etc/redis/redis.conf
        mkdir -p /etc/pwire
        cp -r server /etc/pwire
        cp pwire-server.service /etc/systemd/system/pwire-server.service
        systemctl daemon-reload
        systemctl enable pwire-server
        # Install PHP
        apt -y install lsb-release apt-transport-https ca-certificates
        wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
        echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/php.list
        apt update
        apt -y install php7.3
        apt -y install php7.3-fpm
        apt -y install php7.3-{bcmath,json,mbstring,xml,common,pgsql,redis}
        systemctl start php7.3-fpm
        php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
        php -r "if (hash_file('sha384', 'composer-setup.php') === 'e0012edf3e80b6978849f5eff0d4b4e4c79ff1609dd1e613307e16318854d24ae64f26d17af3ef0bf7cfb710ca74755a') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
        php composer-setup.php --filename=composer --install-dir=/usr/bin
        php -r "unlink('composer-setup.php');"
        # Install Caddy
        apt -y install gcc g++
        mkdir -p /etc/pwire/caddy
        mkdir -p /etc/pwire/caddy/lib
        mkdir -p $HOME/go
        mkdir -p $HOME/golang
        groupadd --system caddy
        useradd --system --gid caddy --create-home --home-dir /etc/pwire/caddy/lib --shell /usr/sbin/nologin --comment "Caddy web server" caddy
        usermod -aG www-data caddy
        wget https://dl.google.com/go/go1.14.1.linux-armv6l.tar.gz
        tar -C $HOME/golang -xzf go1.14.1.linux-armv6l.tar.gz
        rm go1.14.1.linux-armv6l.tar.gz
        git clone "https://github.com/caddyserver/caddy.git"
        cd caddy/cmd/caddy
        git checkout v2.0.0-beta.20
        export GOPATH=$HOME/go
        export GO111MODULE=on
        $HOME/golang/go/bin/go build
        cp caddy /etc/pwire/caddy
        cd ../../../
        rm -r $HOME/golang
        rm -r $HOME/go
        rm -r caddy
        cp Caddyfile /etc/pwire/caddy
        chown -R caddy:caddy /etc/pwire/caddy
        cp pwire-caddy.service /etc/systemd/system/pwire-caddy.service
        systemctl daemon-reload
        systemctl enable pwire-caddy
        # Install Postgre
        apt install -y postgresql
	    sudo -i -u postgres bash -c "psql --command=\"CREATE USER pwire WITH PASSWORD 'pwire' NOCREATEDB;\""
        sudo -i -u postgres bash -c "psql --command=\"CREATE DATABASE pwire;\""
        sudo -i -u postgres bash -c "psql --command=\"GRANT ALL PRIVILEGES ON DATABASE pwire TO pwire;\""      
        # Install Node.Js
        curl -sL https://deb.nodesource.com/setup_12.x | sudo -E bash -
        apt install -y nodejs
        # Install Frontend
        npm i -g laravel-echo-server
        cp -r frontend /etc/pwire
        cp .env /etc/pwire/frontend
        php /etc/pwire/frontend/artisan key:generate
        php /etc/pwire/frontend/artisan storage:link
        php /etc/pwire/frontend/artisan migrate --force
        php /etc/pwire/frontend/artisan view:cache
        php /etc/pwire/frontend/artisan route:cache
        php /etc/pwire/frontend/artisan config:cache
        cp pwire-frontend.service /etc/systemd/system/pwire-frontend.service
        cp pwire-eventing.service /etc/systemd/system/pwire-eventing.service
        systemctl daemon-reload
        systemctl enable pwire-frontend
        systemctl enable pwire-eventing
        systemctl daemon-reload
        chown -R www-data:www-data /etc/pwire/frontend
        (crontab -u caddy -l 2>/dev/null; echo "* * * * * cd /etc/pwire/frontend && php artisan schedule:run >> /dev/null 2>&1") | crontab -
        # Cleanup
        apt -y remove gcc g++
        apt -y autoremove
    else
        apt update
        # Uninstall Server
        systemctl stop pwire-server
        rm -r /etc/pwire
        apt -y purge redis-server
        systemctl disable pwire-server
        rm /etc/systemd/system/pwire-server.service
        systemctl daemon-reload
        # Uninstall PHP
        apt -y purge php7.4-{bcmath,json,mbstring,xml,common,pgsql,redis}
        apt -y purge php7.4-fpm
        apt -y purge php7.4
        # Uninstall nodejs
        apt -y purge nodejs
        rm /etc/apt/sources.list.d/nodesource.list
        # Debian
        rm /etc/apt/trusted.gpg.d/php.gpg
        rm /etc/apt/sources.list.d/php.list
        apt update
        apt -y autoremove
        rm /usr/bin/composer
        # Uninstall frontend
        find /var/spool/cron/crontabs/caddy -type -f -exec crontab -r -u caddy {} \;
        systemctl stop pwire-frontend
        systemctl stop pwire-eventing
        rm /etc/systemd/system/pwire-frontend.service
        rm /etc/systemd/system/pwire-eventing.service
        # Uninstall Caddy
        systemctl stop pwire-caddy
        systemctl stop pwire-caddy
        rm /etc/systemd/system/pwire-caddy.service
        systemctl daemon-reload
        userdel caddy
        groupdel caddy
        # Uninstall Postgres
        apt purge postgresql
    fi
fi
