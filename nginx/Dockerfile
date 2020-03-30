FROM debian:jessie

RUN apt-get update && apt-get install -y \
    nginx \
    locales
RUN apt-get update && apt-get install -y --no-install-recommends apt-utils

## Set LOCALE to UTF8
RUN locale-gen nl_NL.UTF-8 && dpkg-reconfigure locales
ENV LANG nl_NL.UTF-8
ENV LANGUAGE nl_NL.UTF-8
ENV LC_ALL nl_NL.UTF-8

ADD nginx.conf /etc/nginx/
ADD conf/*.conf /etc/nginx/sites-available/
#ADD ssl/* /etc/nginx/certs/

RUN ln -s /etc/nginx/sites-available/*.conf /etc/nginx/sites-enabled/
RUN rm /etc/nginx/sites-enabled/default

RUN echo "upstream php-upstream { server php:9000; }" > /etc/nginx/conf.d/upstream.conf

RUN usermod -u 1000 www-data

CMD ["nginx"]

EXPOSE 80
EXPOSE 443
EXPOSE 21
