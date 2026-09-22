FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql
RUN a2enmod rewrite

RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
    && echo '<Directory "/var/www/html/public">' > /etc/apache2/conf-available/app.conf \
    && echo '    Options Indexes FollowSymLinks' >> /etc/apache2/conf-available/app.conf \
    && echo '    AllowOverride All' >> /etc/apache2/conf-available/app.conf \
    && echo '    Require all granted' >> /etc/apache2/conf-available/app.conf \
    && echo '</Directory>' >> /etc/apache2/conf-available/app.conf \
    && echo 'FallbackResource /index.php' >> /etc/apache2/apache2.conf \
    && a2enconf app

WORKDIR /var/www/html