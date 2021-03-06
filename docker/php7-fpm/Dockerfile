FROM php:7.1-fpm

# Install PHP extensions
RUN apt-get update && apt-get install -y \
      zlib1g-dev \
      sqlite3 \
      libsqlite3-dev \
      libicu-dev \
      libpq-dev \
      libmcrypt-dev \
    && rm -r /var/lib/apt/lists/* \
    && docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
    && docker-php-ext-install \
      intl \
      mbstring \
      mcrypt \
      pcntl \
      pdo_mysql \
      pdo_pgsql \
      pdo_sqlite \
      pgsql \
      zip \
      opcache

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# install phpunit
RUN curl https://phar.phpunit.de/phpunit.phar -L > phpunit.phar \
  && chmod +x phpunit.phar \
  && mv phpunit.phar /usr/local/bin/phpunit \
  && phpunit --version

# install cron
RUN apt-get update && apt-get -y install rsyslog

# Change uid and gid of apache to docker user uid/gid
RUN chown -R www-data:www-data /var/www



WORKDIR /var/www/html


COPY start.sh /usr/local/bin/start
RUN chmod u+x /usr/local/bin/start


CMD ["/usr/local/bin/start"]