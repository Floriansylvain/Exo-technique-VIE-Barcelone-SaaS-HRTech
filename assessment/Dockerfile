FROM php:8.5-alpine
WORKDIR /var/www/html

RUN apk add --no-cache bash

EXPOSE 80

CMD ["php", "-S", "0.0.0.0:80", "-t", "/var/www/html"]
