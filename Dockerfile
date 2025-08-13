FROM php:8.1-apache

# 必要なPHP拡張機能をインストール (今回はpdo_mysql)
RUN docker-php-ext-install pdo_mysql

# カスタムしたApache設定ファイルをコンテナにコピー
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Apacheのリライトモジュールを有効化 (後々きれいなURLを使うために便利)
RUN a2enmod rewrite