# グループ分けWEBアプリケーション

## 初期環境構築

### Laravel Sail インストール
curl -s https://laravel.build/grouping-app | bash

### PhpMyAdminの追加
#### docker-compose.yml
    phpmyadmin:
        image: phpmyadmin/phpmyadmin
        links:
            - mysql:mysql
        ports:
            - 8080:80
        environment:
            MYSQL_USERNAME: '${DB_USERNAME}'
            MYSQL_ROOT_PASSWORD: '${DB_PASSWORD}'
            PMA_HOST: mysql
        networks:
            - sail
#### コマンド
sail up

### Laravel Breeze Inertia Vue インストール
sail composer require laravel/breeze --dev
sail artisan breeze:install
Inertia Vueを選択
オプションは不要
テストはPHPUnit

### DBマイグレート
sail artisan migrate

### デバッグバーのインストール
#### コマンド
sail composer require --dev barryvdh/laravel-debugbar
#### margin-bottomの余白を消す（app.blade.php）
        @if (config('app.debug'))
        <script>
            PhpDebugBar.DebugBar.prototype.recomputeBottomOffset = () => {};
        </script>
        @endif

### バリデーションの設定導入
sail artisan lang:publish
sail composer require askdkc/breezejp --dev
php artisan breezejp

### ストレージのリンク
sail artisan storage:link

## @shopify/draggable インストール
sail npm install @shopify/draggable --save

## sass-embedded インストール
sail npm install -D sass-embedded

## toastr インストール
sail npm install --save toastr

## メールの設定(開発環境用)
### Mailtrapの設定
Mailtrapにログイン
左側リストのEmail Testing -> Inboxes を選択
My Inbox を選択
Integration でSMTP の設定にした状態で、PHP -> Laravel 9+ を選択
Copy して、プロジェクトの.env に必要な項目を上書き（MAIL_PASSWORD はCopy しないと表示されない）

### 非同期処理
.env に次の項目を変更
QUEUE_CONNECTION=database

ターミナルでワーカー起動
sail artisan queue:work
*queue:workプロセスをバックグラウンドで永続的に実行し続けるには、Supervisorなどのプロセスモニタを使用して、キューワーカの実行が停止しないようにする必要があります。

## Sanctum インストール
### コマンド
sail artisan install:api

### bootstrap/app.php
$middleware->statefulApi(); を追加
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();
    })

### config/sanctum.php （必要に応じて）
APIへのリクエストを許可するクライアントのドメインを設定

## flatpickr インストール
sail npm i flatpickr --save