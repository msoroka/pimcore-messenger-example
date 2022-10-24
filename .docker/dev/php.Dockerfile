FROM pimcore/pimcore:PHP8.1-fpm

RUN rm -rf /var/lib/apt/lists/ && curl -sL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install nodejs -y

ARG UID
ARG GID

RUN chmod 777 -R /usr/bin
RUN chmod 777 -R /usr/lib

WORKDIR /var/www

RUN usermod -s /bin/bash www-data \
    && groupmod --non-unique --gid ${GID} www-data \
    && usermod --non-unique --uid ${UID} --gid ${GID} www-data

RUN chown -R www-data:www-data /var/www
