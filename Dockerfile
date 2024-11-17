FROM php:8.1.0-apache
RUN docker-php-ext-install mysqli
RUN a2enmod ssl
RUN echo "expose_php = Off" >> /usr/local/etc/php/conf.d/docker-php.ini
RUN a2enmod headers
RUN echo "Header unset Server" >> /etc/apache2/conf-enabled/security.conf
RUN echo "ServerTokens Prod" >> /etc/apache2/apache2.conf
RUN echo "ServerSignature Off" >> /etc/apache2/apache2.conf
RUN echo "Header unset X-Powered-By" >> /etc/apache2/conf-enabled/security.conf
RUN echo "Header always set X-Frame-Options \"SAMEORIGIN\"" >> /etc/apache2/conf-enabled/security.conf
RUN echo "Header always set Content-Security-Policy \"default-src 'self'; script-src 'self' https://localhost:81/js/; style-src 'self'; img-src 'self';\"" >> /etc/apache2/conf-enabled/security.conf
RUN echo "Header always set Strict-Transport-Security \"max-age=31536000; includeSubDomains; preload\"" >> /etc/apache2/conf-enabled/security.conf
RUN echo "Header always set X-Content-Type-Options \"nosniff\"" >> /etc/apache2/conf-enabled/security.conf
