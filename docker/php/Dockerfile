FROM php:7.4-fpm

# Install system packages for PHP extensions recommended for Yii 2.0 Framework
RUN apt-get update && \
    apt-get install -y \
            curl \
            wget \
            unzip \
            htop \
            zip \
            libmemcached-dev \
            git \
            bash-completion \
            curl \
            imagemagick \
            libfreetype6-dev \
            libcurl3-dev \
            libicu-dev \
            libmcrypt-dev \
            libfreetype6-dev \
            libjpeg-dev \
            libjpeg62-turbo-dev \
            libmagickwand-dev \
            libpq-dev \
            libpng-dev \
            libzip-dev \
            zlib1g-dev \
            mariadb-client \
            openssh-client \
            libxml2-dev \
            mc \
            gettext \
            cron \
            libgmp-dev \
            procps \
            nano \
            supervisor && \
    docker-php-ext-configure gd && \
    docker-php-ext-configure bcmath && \
    docker-php-ext-install  soap \
                            zip \
                            curl \
                            bcmath \
                            exif \
                            gd \
                            iconv \
                            intl \
                            opcache \
                            gmp \
                            pdo_mysql && \
    printf "\n" | pecl install \
        imagick \
        mcrypt \
        memcached \
        redis && \
    docker-php-ext-enable \
        imagick \
        memcached \
        redis

# Install composer
# ApiDoc generator
RUN curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer.phar \
        --install-dir=/usr/local/bin &&  \
    curl -sL https://deb.nodesource.com/setup_14.x | bash - && \
    apt install nodejs && \
    npm install apidoc -g

RUN pecl install xdebug-3.1.0 && docker-php-ext-enable xdebug
RUN pecl install grpc-1.55.0 && docker-php-ext-enable grpc

RUN apt-get install -y iputils-ping

WORKDIR /home/www

# Add configuration files
COPY docker/php/image-files/ /
COPY docker/php-dev/image-files/ /

# Add GITHUB_API_TOKEN support for composer
RUN chmod 700 \
        /usr/local/bin/docker-entrypoint.sh \
        /usr/local/bin/docker-run.sh \
        /usr/local/bin/composer

# Startup script for FPM
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["php-fpm"]
