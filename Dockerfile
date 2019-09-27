
FROM jdecode/kode:0.3

#RUN curl -sSO https://dl.google.com/cloudagents/install-monitoring-agent.sh
#RUN bash install-monitoring-agent.sh

#Stackdriver logging agent
#RUN curl -sSO https://dl.google.com/cloudagents/install-logging-agent.sh
#RUN bash install-logging-agent.sh

#ARG NR_INSTALL_SILENT
#ARG NR_INSTALL_NOKSH
#ARG NR_INSTALL_KEY

#RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

ARG _APP_KEY
ENV APP_KEY=${_APP_KEY}

RUN git pull origin master
RUN chown -R www-data:www-data storage bootstrap
RUN composer install -n --prefer-dist
