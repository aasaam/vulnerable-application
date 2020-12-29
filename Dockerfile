FROM php:8-fpm

ARG BUILD_OCI_PATH=/opt/oracle

RUN export DEBIAN_FRONTEND=noninteractiv \
  && export ACCEPT_EULA=Y \
  && apt-get update -y \
  && apt-get -y install libpq-dev ca-certificates curl wget gnupg unzip \
  # oracle
  && mkdir -p $BUILD_OCI_PATH \
  && cd /tmp \
  && wget -c -O instantclient.zip https://github.com/pwnlabs/oracle-instantclient/raw/master/instantclient-basiclite-linux.x64-12.2.0.1.0.zip \
  && wget -c -O instantclient-sdk.zip https://github.com/pwnlabs/oracle-instantclient/raw/master/instantclient-sdk-linux-12.2.0.1.0.zip \
  && unzip instantclient.zip -d $BUILD_OCI_PATH \
  && unzip instantclient-sdk.zip -d $BUILD_OCI_PATH \
  && ln -s $BUILD_OCI_PATH/instantclient_12_2/libclntsh.so.12.* $BUILD_OCI_PATH/instantclient_12_2/libclntsh.so \
  && ln -s $BUILD_OCI_PATH/instantclient_12_2/libclntshcore.so.12.* $BUILD_OCI_PATH/instantclient_12_2/libclntshcore.so \
  && ln -s $BUILD_OCI_PATH/instantclient_12_2/libocci.so.12.* $BUILD_OCI_PATH/instantclient_12_2/libocci.so \
  && docker-php-ext-configure pdo_oci --with-pdo-oci=instantclient,$BUILD_OCI_PATH/instantclient_12_2,12.2 \
       && echo "instantclient,$BUILD_OCI_PATH/instantclient_12_2/" | pecl install oci8 \
       && docker-php-ext-install \
               pdo_oci \
       && docker-php-ext-enable \
               oci8 \
  # msssql
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
