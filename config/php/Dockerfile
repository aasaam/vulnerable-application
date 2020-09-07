FROM php:7-fpm

RUN apt-get update -y \
  && apt-get -y install unixodbc-dev libpq-dev \
  && docker-php-ext-install pdo pdo_mysql pdo_pgsql pgsql \
  && pecl install sqlsrv pdo_sqlsrv \
  && docker-php-ext-enable sqlsrv pdo_sqlsrv \
  && apt-get autoremove -y \
  && apt-get clean \
  && rm -rf /root/.cache && rm -r /var/lib/apt/lists/* && rm -rf /tmp && mkdir /tmp && chmod 777 /tmp && truncate -s 0 /var/log/*.log
