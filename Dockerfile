FROM php:8.2-fpm
<<<<<<< HEAD
RUN docker-php-ext-install pdo_mysql
=======

RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY ./src/ /var/www/html/

EXPOSE 9000

CMD ["php-fpm"]
>>>>>>> 1828790e637659df352bd1ceda1394e43f07e3a5
