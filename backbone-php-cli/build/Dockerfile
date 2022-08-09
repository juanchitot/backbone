FROM php:7.4-cli
RUN useradd ubuntu -u 1000 -m -d /home/ubuntu -U
RUN pecl install xdebug  && docker-php-ext-enable  xdebug

run apt-get update &&  apt-get install -y  netcat openssl libzip-dev git \
    zlib1g-dev \
    libzip-dev \
    unzip

RUN docker-php-ext-install zip mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql


run echo "alias phpdbg='php -dxdebug.mode=debug -dxdebug.client_host=192.168.1.2 -dxdebug.client_port=9000 -dxdebug.start_with_request=yes -dxdebug.idekey=xdebug-phpstorm' "  >> /home/ubuntu/.bash_aliases


run php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
run php composer-setup.php
run php -r "unlink('composer-setup.php');"

run mkdir /app
user ubuntu
WORKDIR /app
