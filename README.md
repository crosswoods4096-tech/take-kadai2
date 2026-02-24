## アプリケーション名
CoachTech 問い合わせフォーム

## 環境構築
リポジトリからダウンロード
```
git clone git@github.com:crosswoods4096-tech/take-kadai2.git
```
srcディレクトリの「.env.example」をコピーして「.env」を作成し、DBの設定を変更
```
cp .env.example .env
```
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```
dockerコンテナを構築
```
docker-compose up -d --build
```
phpコンテナにログインしてLaravelをインストール
```
docker-compose exec php bash
composer install
```
アプリケーションキーを作成
```
php artisan key:generate
```
DBのテーブルを作成
```
php artisan migrate
```
DBのテーブルにダミーデータを投入
```
php artisan db:seed
```
storageディレクトリの書き込み権限を設定
```
chmod -R 777 storage
```

## ER図
![ER図](ER.drawio.png)

