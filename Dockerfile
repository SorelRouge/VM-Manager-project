FROM php:6.3.3-apache
RUN apt-get update && apt-get upgrade -y
RUN docker-php-ext-install mysqli
RUN apt-get install php7.0-xml

RUN git clone https://github.com/blueimp/jQuery-File-Upload.git /var/www/upload
ADD jquery-file-upload/index.html /var/www/upload/index.html

RUN docker-php-ext-install pdo_mysql
EXPOSE 80
