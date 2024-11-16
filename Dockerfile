FROM php:7.2.2-apache
RUN docker-php-ext-install mysqli
RUN a2enmod ssl
RUN echo "expose_php = Off" >> /usr/local/etc/php/conf.d/docker-php.ini
RUN a2enmod headers
RUN echo "Header unset Server" >> /etc/apache2/conf-enabled/security.conf
RUN echo "ServerTokens Prod" >> /etc/apache2/apache2.conf
RUN echo "ServerSignature Off" >> /etc/apache2/apache2.conf
