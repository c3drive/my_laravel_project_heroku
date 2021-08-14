# my-laravel-project
         ___        ______     ____ _                 _  ___  
        / \ \      / / ___|   / ___| | ___  _   _  __| |/ _ \ 
       / _ \ \ /\ / /\___ \  | |   | |/ _ \| | | |/ _` | (_) |
      / ___ \ V  V /  ___) | | |___| | (_) | |_| | (_| |\__, |
     /_/   \_\_/\_/  |____/   \____|_|\___/ \__,_|\__,_|  /_/ 
 ----------------------------------------------------------------- 


Hi there! Welcome to AWS Cloud9!

To get started, create some files, play with the terminal,
or visit https://docs.aws.amazon.com/console/cloud9/ for our documentation.

Happy coding!
## laravel
```bash
cms/cms/
 ├──app
 │  └──Http
 │      └──Controllers/　…コントローラ
 ├──database
 │  └──migrations/　…DB登録の情報や処理
 │  └──seeds/　…自動テスト
 ├──public/ …公開情報を格納
 │  ├──upload/　…ユーザがアップしたファイルなど（要インストール）
 │  └──phpMyAdmin/　…phpMyAdmin（要インストール）
 ├──resources
 │  ├──lang
 │  │  │  └──ja　…日本語（要インストール）
 │  ├──views
 │  │  ├──auth/　…ログイン認証用テンプレート
 │  │  ├──common
 │  │  │  └──error.blade.php　…エラービュー
 │  │  ├──layouts
 │  │  │  └── app.blade.php　…各ビューのベース
 │  │  └──xxxx.blade.php　…各ビュー
 ├──routes
 │  └──web.php　…ルート定義
 └──app
```

## Cloud9：PHP7.2_Updateコマンド 
```bash
sudo yum -y install php72 php72-cli php72-common php72-devel php72-mysqlnd php72-pdo php72-xml php72-gd php72-intl php72-mbstring php72-mcrypt php72-opcache php72-pecl-apcu php72-pecl-imagick php72-pecl-memcached php72-pecl-redis php72-pecl-xdebug
sudo alternatives --set php /usr/bin/php-7.2
php -v
```

## Composer（ライブラリ管理ツール）
```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/bin/composer
composer
```

## Laravelインストーラーをダウンロード
```bash
composer global require "laravel/installer"
```

## SWap作成：メモリ不足エラーにならないためにt2.microには512MのSwapを用意
```bash
sudo dd if=/dev/zero of=/swapfile bs=1M count=512
sudo chmod 600 /swapfile
sudo mkswap /swapfile
sudo swapon /swapfile
```

## Laravel6.* をcmsディレクトリに設置（インストール） 
```bash
composer create-project laravel/laravel cms 6.* --prefer-dist
```

## SWap削除（上記コマンド終了したらSWap削除します）
```bash
sudo swapoff /swapfile
sudo rm /swapfile
sudo swapoff -a && swapon -a
#swapon: cannot open /var/swapfile: Permission denied と出ますが無視してOK
```

## MySQL起動＆Apache起動
```bash
sudo service mysqld restart
cd cms
php artisan serve --port=8080
```

1 Preview→ [Preview Running Application]選択
2 /resouces/views/welcome.blade.php を編集して見よう！
3 ブラウザ・更新で確認 →　変更確認できればOK

## DB起動確認(rootユーザでDB作成)・phpMyAdmin設定
```mysql
mysql -u root -p
[Enter] ※パスワードなし
create database c9;
show databases;
use c9;
show tables;
update mysql.user set password=password('root') where user='root';
flush privileges;
exit;
```

## エラ〜メッセージなどの日本語化
```bash
$ php -r "COPY('https://readouble.com/laravel/6.x/ja/install-ja-lang-files.php', 'install-ja-lang.php');"
$ php -f install-ja-lang.php
$ php -r "unlink('install-ja-lang.php');"
```

## phpMyAdminインストール
```bash
$ cd cms/public/
$ wget https://files.phpmyadmin.net/phpMyAdmin/4.8.3/phpMyAdmin-4.8.3-all-languages.zip
$ unzip phpMyAdmin-4.8.3-all-languages.zip
$ mv phpMyAdmin-4.8.3-all-languages phpMyAdmin
```
https://{ホスト}/phpMyAdmin/index.phpへアクセス
root/root

## ログイン実装（t2.smallだとメモリ不足）
```bash
$ composer require laravel/ui:^1.0 -dev
$ php artisan ui vue --auth
$ npm install
$ npm run dev
```

## Class作成
```bash
// cms/app/Book.php作成
$ php artisan make:model Book
```
```bash:一緒にマイグレーションを生成したい場合
$ php artisan make:model Book -m
$ php artisan make:model Book -migration
```

## Controller作成
```bash
$ $ php artisan make:controller BooksController
```

## tinker（モデルの記述コードのチェックができる）
```bash
$ sudo service mysqld restart
$ cd cms
$ php artisan tinker
>>>$all = App\Book::all(); // boolsテーブルの全データ取得
>>>$books = Book::find(1); // boolsテーブルの主キー（item_id）が1のデータ取得
>>>exit;
```

## Seeder（テストデータを自動生成できる）

```bash
$ sudo service mysqld restart
$ cd cms
$ php artisan make:seeder BooksTableSeeder
```
/cms/database/seeds/BooksTableSeeder.phpを編集
参考：[GitHub:Fakerで使用できるフォーマット一覧](https://github.com/fzaninotto/Faker#formatters)

```bash
$ php artisan db:seed --class="BooksTableSeeder"
$ mysql -u root -p

>>>use c9;
>>>SELECT * FROM books;
>>>exit;
```

## デバッグ
以下を追記し、ブラウザ実行でデバッグ画面。Queriesにチェックを入れるとそのページで実行されたSQLが見れる
```php:/cms/app/Http/Controllers/BooksController.php
ddd($books);
```
## 基本的なコマンド覚書

MySQL起動（ログインしたら必ず実行）
```bash
sudo service mysqld restart
```

Webサーバー起動（ログインしたら必ず実行 ※cmsフォルダ内で実行する必要がある！）
```bash
cd cms
php artisan serve --port=8080
```

Migration
```bash
// cms/database/migrations/2021_08_10_112114_create_books_table.phpが作成
$ php artisan make:migration create_books_table --create=books // マイグレーションファイル作成

// Migrationファイル編集して実行（テーブル作成）
$ php artisan migrate

// テーブル削除（このあとテーブル作成から必要）
$ php artisan migrate:reset

// テーブル初期化（データクリアアンド再作成）
$ php artisan migrate:refresh
```
