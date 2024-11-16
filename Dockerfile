FROM php:7.3.0-apache
RUN docker-php-ext-install mysqli
RUN a2enmod ssl
RUN echo "expose_php = Off" >> /usr/local/etc/php/conf.d/docker-php.ini
RUN echo "ServerTokens Prod" >> /etc/apache2/apache2.conf
RUN echo "ServerSignature Off" >> /etc/apache2/apache2.conf

