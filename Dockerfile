FROM php:7-buster

ARG BUILD_OCI_PATH=/opt/oracle
ARG BUILD_OCI_FULL_PATH=/opt/oracle/instantclient_12_2

RUN export DEBIAN_FRONTEND=noninteractiv \
  && export ACCEPT_EULA=Y \
  && apt-get update -y \
  && apt-get -y install libpq-dev ca-certificates curl wget gnupg unzip libaio1 libaio-dev \
  # oracle
  && mkdir -p $BUILD_OCI_PATH \
  && cd /tmp \
  && wget -q -c -O instantclient.zip https://github.com/pwnlabs/oracle-instantclient/raw/master/instantclient-basiclite-linux.x64-12.2.0.1.0.zip \
  && wget -q -c -O instantclient-sdk.zip https://github.com/pwnlabs/oracle-instantclient/raw/master/instantclient-sdk-linux-12.2.0.1.0.zip \
  && unzip instantclient.zip -d $BUILD_OCI_PATH \
  && unzip instantclient-sdk.zip -d $BUILD_OCI_PATH \
  && ln -s $BUILD_OCI_FULL_PATH/libclntsh.so.12.* $BUILD_OCI_FULL_PATH/libclntsh.so \
  && ln -s $BUILD_OCI_FULL_PATH/libclntshcore.so.12.* $BUILD_OCI_FULL_PATH/libclntshcore.so \
  && ln -s $BUILD_OCI_FULL_PATH/libocci.so.12.* $BUILD_OCI_FULL_PATH/libocci.so \
  && echo "$BUILD_OCI_FULL_PATH/" > /etc/ld.so.conf.d/oracle-insantclient.conf \
  && echo "/opt/microsoft/msodbcsql17/lib64/" > /etc/ld.so.conf.d/msodbcsql17.conf \
  && ldconfig \
  && docker-php-ext-configure pdo_oci --with-pdo-oci=instantclient,$BUILD_OCI_FULL_PATH,12.2 \
       && echo "instantclient,$BUILD_OCI_FULL_PATH/" | pecl install oci8-2.2.0 \
       && docker-php-ext-install \
               pdo_oci \
       && echo "oci success build" \
       && docker-php-ext-enable \
               oci8 \
  && echo "PHPINFO: OCI" \
  && php -i | grep oci \
  # msssql
  && curl -Ls https://packages.microsoft.com/config/debian/10/prod.list > /etc/apt/sources.list.d/mssql-release.list \
  && curl -Ls https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
  && apt-get update -y \
  && apt-get install msodbcsql17 mssql-tools unixodbc unixodbc-dev -y \
  && docker-php-ext-install pdo pdo_mysql pdo_pgsql pgsql \
  && pecl install sqlsrv pdo_sqlsrv \
  && docker-php-ext-enable sqlsrv pdo_sqlsrv \
  && echo "PHPINFO: SQLSRV" \
  && php -i | grep sqlsrv \
  && echo "==== PHPINFO: ALL ====" \
  && php -i \
  && echo "======================" \
  && apt-get autoremove -y \
  && apt-get clean \
  && rm -rf /root/.cache && rm -r /var/lib/apt/lists/* && rm -rf /tmp && mkdir /tmp && chmod 777 /tmp && truncate -s 0 /var/log/*.log
