FROM php:8.2-apache

# Atualiza pacotes e instala dependências do postgres
RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo_pgsql pgsql

# Copie seus arquivos PHP para o apache (ajuste caminho se necessário)
COPY . /var/www/html

# (Opcional) Defina o diretório de trabalho
WORKDIR /var/www/html

# (Opcional) Configure o Apache para regravação de URLs
RUN a2enmod rewrite
