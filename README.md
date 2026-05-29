# share

## 概要

ユーザー同士でコミュニケーションを楽しめるSNSアプリです。  
メッセージの投稿や閲覧を通じて、他のユーザーとの交流が出来ます。

![ホーム画面](https://github.com/user-attachments/assets/a5f0cad8-9a06-4c46-9b17-6f1b4918ee55)

## 機能一覧

- **会員登録・ログイン**
- **投稿一覧取得**
- **投稿追加機能**
- **投稿削除機能**
- **いいね機能**
- **コメント機能**

## 環境構築

**インストール**

1. プロジェクトのクローン

```
git clone git@github.com:oohashitakayuki/share.git
```

2. プロジェクトディレクトリに移動

```
cd share
```

3. Yarnをインストール

```
docker-compose run --rm node yarn install
```

4. コンテナを作成

```
docker-compose up -d --build
```

**Laravel 環境構築**

1. プロジェクトディレクトリからPHPコンテナにログイン

```
docker-compose exec php bash
```

2. Composerをインストール

```
composer install
```

3. .env.exampleをコピーして.envを作成

```
cp .env.example .env
```

4. .envに以下の環境変数を設定

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```

5. アプリケーションキーの作成

```
php artisan key:generate
```

6. マイグレーションの実行

```
php artisan migrate
```

**Firebase Authentication 利用設定**

1. Firebaseプロジェクトの作成

https://firebase.google.com/  
にアクセスし、「コンソールへ移動」をクリック

「新しいFirebaseプロジェクトを作成」をクリック

プロジェクト名を入力し、「プロジェクトを作成」をクリック  
(例：SHARE)

2. ライブラリの導入(フロントエンド)

プロジェクトディレクトリからNodeコンテナにログイン

```
docker-compose exec node bash
```

Firebase Javascript SDKをインストール

```
yarn add firebase@8
```

3. ライブラリの導入(バックエンド)

プロジェクトディレクトリからPHPコンテナにログイン

```
docker-compose exec php bash
```

Firebase Admin SDKをインストール

```
composer require kreait/firebase-php:^7.14 -W
```

4. ユーザー認証の設定

コンソールのサイドバーから  
「セキュリティ」→「Authentication」→「始める」をクリック  
「ログイン方法」を開いて「メール/パスワード」を選択し、  
「メール/パスワード」の隣にある「有効にする」のスイッチをオンにして  
「保存」をクリック

コンソールのサイドバーから「設定」→「全般」→マイアプリにある「ウェブ」のアイコンをクリック  
アプリのニックネームを入力し、「アプリを登録」をクリック  
(例：SHARE)  
「npmを使用する」が選択されているかを確認し、「コンソールに進む」をクリック

プロジェクトディレクトリからshare-frontend/pluginsディレクトリに移動

```
cd share-frontend
cd plugins
```

pluginsディレクトリ以下にfirebase.jsを作成

```
touch firebase.js
```

firebase.jsに以下の内容を入力

```
// Import the functions you need from the SDKs you need
import firebase from "firebase/app"
import 'firebase/auth'
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: “マイアプリで確認した設定値”,
  authDomain: "マイアプリで確認した設定値",
  projectId: "マイアプリで確認した設定値",
  storageBucket: "マイアプリで確認した設定値",
  messagingSenderId: "マイアプリで確認した設定値",
  appId: "マイアプリで確認した設定値"
};

if (!firebase.apps.length) {
  firebase.initializeApp(firebaseConfig)
}

export const auth = firebase.auth()
export default firebase
```

5. サービスアカウントキーの取得

「サービスアカウント」を開いて「Admin SDK 構成スニペット」で「Node.js」が選択されているかを確認し、  
「新しい秘密鍵を生成」をクリック→「キーを生成」をクリックしてJSONファイルをダウンロード

ダウンロードしたJSONファイルのファイル名を  
「firebase_credentials.json」に変更

プロジェクトディレクトリへ戻り、share-backendディレクトリに移動

```
cd ../../
cd share-backend
```

share-backendディレクトリ以下にfirebaseディレクトリを作成

```
mkdir firebase
```

firebaseディレクトリ以下にJSONファイルを配置

.envの末尾にサービスアカウントキーのパスを追加

```
FIREBASE_CREDENTIALS=/var/www/firebase/firebase_credentials.json
```

プロジェクトディレクトリに移動し、コンテナを再起動

```
docker-compose restart
```

## 使用技術(実行環境)

- PHP 8.2.31
- Laravel 8.83.29
- Vue.js 2.7.16
- Nuxt.js 2.18.1
- Firebase Javascript SDK 8.10.1
- Firebase Admin SDK 7.23.0
- MySQL 8.0.46
- Docker 29.5.2

## テーブル設計

![テーブル設計](https://github.com/user-attachments/assets/d3a38d61-5ea3-4aad-92f2-f9d11057ede0)

## ER図

![ER図](https://github.com/user-attachments/assets/8e6476bd-182b-437e-a03d-f16b951ed814)

## URL

- 開発環境(フロントエンド)：http://localhost:3000
- 開発環境(バックエンド)：http://localhost:8080
- phpMyAdmin：http://localhost:8081
