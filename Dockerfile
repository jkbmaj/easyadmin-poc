FROM php:8.2-cli

COPY . /usr/src/myapp

WORKDIR /usr/src/myapp

RUN apt-get update && apt-get install -y \
        git \
        libicu-dev \
        libzip-dev \
        zip \
  && docker-php-ext-install zip intl

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --quiet \
    && php ./composer.phar install

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public/"]