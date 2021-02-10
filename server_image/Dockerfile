FROM library/php:8.0-rc-apache

RUN apt-get -y update \
&& apt-get install -y libicu-dev\
&& docker-php-ext-configure intl \
&& docker-php-ext-install intl \
&& docker-php-ext-install pdo_mysql

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
RUN a2ensite 000-default.conf
RUN a2enmod rewrite

#docker exec -it php_container bash
#ps aux | grep php
RUN chown -R 28 /var/www/html && chmod -R 777 /var/www/html
