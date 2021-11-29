FROM php:fpm
RUN apt-get update \
    && apt-get install -y zlib1g-dev g++ wget git libicu-dev libzip-dev zip \
	&& docker-php-ext-install intl opcache pdo pdo_mysql \
	&& pecl install apcu \
	&& docker-php-ext-enable apcu \
	&& docker-php-ext-configure zip \
	&& docker-php-ext-install zip

# Install symfony
RUN wget https://get.symfony.com/cli/installer -O - | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

# Install composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Add user/group 1000:1000 docker:docker
RUN groupadd --system -g 1000 docker
RUN adduser --system --uid 1000 --disabled-password --ingroup docker docker
USER docker:docker

WORKDIR /srv/app
