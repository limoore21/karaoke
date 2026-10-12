FROM php:8.2-apache

RUN apt-get update && apt-get install -y libicu-dev \
&& docker-php-ext-configure intl \
&& docker-php-ext-install intl mysqli pdo pdo_mysql

RUN a2enmod rewrite
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

RUN chown -R www-data:www-data /var/www/html