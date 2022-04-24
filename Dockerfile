FROM php:8.1-fpm

RUN apt-get update

# Instalando dependência necessária para o pdo_pgsql
RUN apt install -y libpq-dev 

# Instalando dependências do PHP
RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install intl opcache pdo pdo_pgsql pgsql  \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

# Instalando o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalando o symfony cli
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

RUN mkdir -p /usr/back-vinho
WORKDIR /usr/back-vinho

COPY . .

RUN composer install

EXPOSE 8000

CMD php bin/console doctrine:migrations:migrate && symfony server:start