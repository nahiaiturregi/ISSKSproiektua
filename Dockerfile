FROM php:7.2.2-apache
RUN echo "expose_php = Off" >> /usr/local/etc/php/conf.d/docker-php.ini 
RUN echo "ServerTokens Prod" >> /etc/apache2/apache2.conf
RUN echo "ServerSignature Off" >> /etc/apache2/apache2.conf
RUN docker-php-ext-install mysqli
