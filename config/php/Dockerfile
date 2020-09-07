FROM php:7-fpm

RUN export DEBIAN_FRONTEND=noninteractiv \
  && export ACCEPT_EULA=Y \
  && apt-get update -y \
  && apt-get -y install libpq-dev curl gnupg \
  && curl https://packages.microsoft.com/config/debian/10/prod.list > /etc/apt/sources.list.d/mssql-release.list \
  && curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
  && apt-get update -y \
  && apt-get install msodbcsql17 mssql-tools unixodbc-dev -y \
  && docker-php-ext-install pdo pdo_mysql pdo_pgsql pgsql \
  && pecl install sqlsrv pdo_sqlsrv \
  && docker-php-ext-enable sqlsrv pdo_sqlsrv \
  && apt-get autoremove -y \
  && apt-get clean \
  && rm -rf /root/.cache && rm -r /var/lib/apt/lists/* && rm -rf /tmp && mkdir /tmp && chmod 777 /tmp && truncate -s 0 /var/log/*.log
