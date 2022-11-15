FROM yiisoftware/yii2-php:8.1-apache
WORKDIR /app/

COPY ./ .
RUN composer install
RUN a2enmod rewrite
RUN php init --env=Development --overwrite=All --delete=All
RUN echo "<?php return ['components' => ['db' => ['class' => 'yii\db\Connection', 'dsn' => 'sqlite:'.__DIR__ . '/sqlite.db', 'username' => 'root', 'password' => '', 'charset' => 'utf8'], 'mailer' => [ 'class' => \yii\symfonymailer\Mailer::class, 'viewPath' => '@common/mail', 'useFileTransport' => true, ], ], ];" > ./common/config/main-local.php
RUN php init.php prepareSQLite
RUN php init.php prepareSampleData

RUN sed -i -e 's|/app/web|/app/frontend/web|g' /etc/apache2/sites-available/000-default.conf