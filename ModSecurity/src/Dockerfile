FROM php:7-apache

RUN apt update  -y
RUN apt install -y libapache2-mod-security2 git
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli && docker-php-ext-install pdo_mysql

RUN git clone https://github.com/digininja/DVWA.git /tmp/DVWA

RUN rm -rf /tmp/DVWA/.git

WORKDIR /var/www/html

RUN cp -r /tmp/DVWA/* .

COPY conf/config.inc.php config/config.inc.php

RUN cp /etc/modsecurity/modsecurity.conf-recommended /etc/modsecurity/modsecurity.conf

RUN git clone https://github.com/SpiderLabs/owasp-modsecurity-crs.git

RUN cd owasp-modsecurity-crs && mv crs-setup.conf.example /etc/modsecurity/crs-setup.conf && mv rules/ /etc/modsecurity

COPY conf/000-default.conf /etc/apache2/sites-enabled/000-default.conf
COPY conf/security2.conf /etc/apache2/mods-enabled/security2.conf

# RUN sed -i 's/DetectionOnly/On/g' /etc/modsecurity/modsecurity.conf

COPY conf/bruteforce.conf /etc/modsecurity/bruteforce.conf

RUN chown -R www-data:www-data /var/www
RUN a2dismod security2
RUN a2enmod security2
RUN a2enmod remoteip
RUN service apache2 restart