FROM php:7-apache

MAINTAINER Thomas Krasowski <thomaskrasowski@tuthub.com>

RUN apt-get update && \
    apt-get install -y wget git zip net-tools vim unzip default-libmysqlclient-dev libbz2-dev libmemcached-dev libsasl2-dev libfreetype6-dev libicu-dev libjpeg-dev libmemcachedutil2 libpng-dev libxml2-dev mariadb-client ffmpeg libimage-exiftool-perl python curl python-pip libzip-dev libonig-dev && \
    docker-php-ext-configure gd --with-freetype=/usr/include --with-jpeg=/usr/include && \
    docker-php-ext-install -j$(nproc) bcmath bz2 calendar exif gd gettext iconv intl mbstring mysqli opcache pdo_mysql zip && \
    pecl install redis && \
    docker-php-ext-enable redis && \
    rm -rf /tmp/* /var/lib/apt/lists/* /var/tmp/* /root/.cache && \
    a2enmod rewrite

# patch to use non-root port
RUN sed -i "s|Listen 80|Listen 8000|g" /etc/apache2/ports.conf && \
    sed -i "s|:80|:8000|g" /etc/apache2/sites-available/* && \
    echo "post_max_size = 10240M\nupload_max_filesize = 10240M" >> /usr/local/etc/php/php.ini

RUN pip install -U youtube-dl

RUN rm -rf /var/www/html/*
COPY . /var/www/html

# fix permissions
RUN chown -R www-data. /var/www/html

# create volume
RUN install -d -m 0755 -o www-data -g www-data /var/www/html/videos

# set non-root user
USER www-data
EXPOSE 8000
VOLUME ["/var/www/html/videos"]
