FROM php:7.2-apache

MAINTAINER "Martin Ejstrup" <me@frankly.dk>

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng-dev \
    libicu-dev \
    libgd-dev \
    libxml2-dev \
    git \
    nano \
    bzip2 \
    unzip \
    zlib1g-dev \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
	&& docker-php-ext-install \
		gd \
		exif

RUN docker-php-ext-install json intl pdo pdo_mysql mbstring opcache soap bcmath mysqli zip

RUN apt-get update && apt-get install -y libmagickwand-6.q16-dev --no-install-recommends \
	&& ln -s /usr/lib/x86_64-linux-gnu/ImageMagick-6.8.9/bin-Q16/MagickWand-config /usr/bin \
	&& pecl install imagick \
	&& echo "extension=imagick.so" > /usr/local/etc/php/conf.d/ext-imagick.ini

# Add custom PHP configuration changes from php.ini
COPY php.ini /usr/local/etc/php/
# Copy and enable our own site configuration -- needed for .htaccess enable.
COPY web.conf /etc/apache2/sites-available/web.conf

RUN a2dissite 000-default && \
    a2ensite web

RUN a2enmod rewrite
	
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer global require "hirak/prestissimo:^0.3"
