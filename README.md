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

## @shopify/draggable インストール
sail npm install @shopify/draggable --save