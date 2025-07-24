FROM php:8.2-apache

# Copia todos os arquivos do seu projeto para dentro do container do Apache
COPY . /var/www/html/

# Abra a porta 80 padrão do Apache
EXPOSE 80
