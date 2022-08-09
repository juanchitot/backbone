ARG  APACHE_TAG=2.4

FROM httpd:${APACHE_TAG}


RUN apt-get update && apt-get install -y  libapache2-mod-php7.4 \
  php-xdebug php-mysql php-curl php-xml php-xmlwriter vim

run apt-get install -y composer

RUN a2enmod php7.4
