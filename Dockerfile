FROM php:8.2-apache

COPY . /var/www/html/

RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/api|' /etc/apache2/sites-available/000-default.conf \
 && sed -i 's|<Directory /var/www/html/>|<Directory /var/www/html/api/>|' /etc/apache2/apache2.conf

RUN a2enmod rewrite

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

