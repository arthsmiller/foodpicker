FROM php:8.1-fpm

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip libpng-dev libjpeg-dev \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    &&  curl -sL https://deb.nodesource.com/setup_20.x | bash - \
    && apt install -y nodejs

RUN npm install -g yarn

WORKDIR /var/www/foodpicker

RUN yarn install

ADD  php.ini /usr/local/etc/php/conf.d

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash
#RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony
RUN git config --global user.email "you@example.com" \ \
    && git config --global user.name "Your Name"