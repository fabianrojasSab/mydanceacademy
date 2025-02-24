FROM richarvey/nginx-php-fpm:latest
COPY . .
# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1
# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr
# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1
# Instala Composer y las dependencias
RUN composer install --optimize-autoloader --no-dev
# Instala Node.js y npm desde los repositorios de Alpine
RUN apk update && \
    apk add --no-cache nodejs npm
# Instala las dependencias de Node.js
RUN npm install
# Compila los assets
RUN npm run build
# Da permisos de ejecución al script de despliegue
RUN chmod +x scripts/00-laravel-deploy.sh
EXPOSE 80
CMD ["scripts/00-laravel-deploy.sh"]