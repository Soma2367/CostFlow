# CostFlow

サブスクリプションと固定費を管理し、収入に対する支出の割合を可視化するアプリケーション

## 概要

CostFlowは、月々のサブスクリプションや固定費を一元管理し、収入に対する支出の割合を把握できるWebアプリケーションです。

## 技術スタック

### バックエンド
- **Laravel**: 12.41.1
- **PHP**: 8.5
- **PostgreSQL**: 17
- **Redis**: Alpine (キャッシュ)

### フロントエンド
- **Vite**: 7.2.6
- **Laravel Vite Plugin**: 2.0.1
- **Tailwind CSS**: 3.x
- **Alpine.js**: 3.x (Laravel Breezeに含まれる)

### 開発環境
- **Docker**: Laravel Sail
- **Meilisearch**: 検索エンジン
- **Mailpit**: メール確認 (開発用)
- **Selenium**: E2Eテスト用

### 主要パッケージ
- **Laravel Breeze**: 認証機能
- **Blade UI Kit**: アイコン管理
  - blade-icons
  - blade-heroicons

## 開発環境構成

### Docker Services

| サービス | イメージ | ポート | 用途 |
|---------|---------|--------|------|
| laravel.test | sail-8.5/app | 80, 5173 | Laravelアプリケーション |
| pgsql | postgres:17 | 5432 | データベース |
| redis | redis:alpine | 6379 | キャッシュ |
| meilisearch | getmeili/meilisearch | 7700 | 検索エンジン |
| mailpit | axllent/mailpit | 1025, 8025 | メール確認 |
| selenium | selenium/standalone-chromium | - | E2Eテスト |

## セットアップ

### 必要なもの
- Docker Desktop
- Git

### インストール手順

1. **リポジトリをクローン**
```bash
git clone <repository-url>
cd costflow
```

2. **環境変数をコピー**
```bash
cp .env.example .env
```

3. **Dockerコンテナを起動**
```bash
./vendor/bin/sail up -d
```

4. **依存関係をインストール**
```bash
./vendor/bin/sail composer install
./vendor/bin/sail npm install
```

5. **アプリケーションキーを生成**
```bash
./vendor/bin/sail artisan key:generate
```

6. **データベースマイグレーション**
```bash
./vendor/bin/sail artisan migrate
```

7. **フロントエンド開発サーバーを起動**
```bash
./vendor/bin/sail npm run dev
```

## 使用方法

### アプリケーションにアクセス
- **アプリケーション**: http://localhost
- **Vite開発サーバー**: http://localhost:5173
- **Mailpit (メール確認)**: http://localhost:8025
- **Meilisearch**: http://localhost:7700

### よく使うコマンド

```bash
# コンテナ起動
sail up -d

# コンテナ停止
sail down

# Artisanコマンド
sail artisan <command>

# Composer
sail composer <command>

# NPM
sail npm <command>

# データベースリセット
sail artisan migrate:fresh --seed

# テスト実行
sail artisan test

# キャッシュクリア
sail artisan cache:clear
sail artisan config:clear
sail artisan view:clear
```

### Sailエイリアス設定(オプション)

毎回 `./vendor/bin/sail` と入力するのが面倒な場合:

```bash
alias sail='./vendor/bin/sail'
```

`.zshrc` または `.bashrc` に追加すると永続化されます。

## データベース構成

### PostgreSQL設定
- **Port**: 5432
- **Database**: costflow (デフォルト)
- **Username**: sail (デフォルト)
- **Password**: password (デフォルト)

### 主要テーブル
- **users**: ユーザー情報
- **subscriptions**: サブスクリプション管理
- **fixed_costs**: 固定費管理

## プロジェクト構造

```
costflow/
├── app/                    # アプリケーションコード
├── database/               # マイグレーション、シーダー
├── resources/
│   ├── css/               # Tailwind CSS
│   ├── js/                # JavaScript
│   └── views/             # Bladeテンプレート
│       ├── components/    # 再利用可能なコンポーネント
│       └── layouts/       # レイアウトファイル
├── routes/                # ルート定義
├── docker-compose.yml     # Docker構成
└── vite.config.js        # Vite設定
```

## UI/UX

### レイアウト
- サイドバーナビゲーション (縦並び)
- レスポンシブデザイン対応

### カラースキーム
- Primary: Indigo
- Background: Gray-50
- Accent: Gray-100

## トラブルシューティング

### ポートが使用中の場合

`.env` ファイルで以下を変更:
```env
APP_PORT=8000
FORWARD_DB_PORT=54320
```

### コンテナが起動しない場合

```bash
sail down
docker system prune -a
sail up -d
```

### Viteが起動しない場合

```bash
sail npm install
rm -rf node_modules package-lock.json
sail npm install
sail npm run dev
```

## 開発ガイドライン

### コミットメッセージ
- 日本語で記述
- 変更内容を明確に

例:
```
サブスクリプション管理機能を追加
パッケージ追加: blade-iconsをインストール
サイドバーレイアウトに変更
```

### コーディング規約
- Laravel標準に準拠
- Tailwind CSSのユーティリティクラスを使用
- コンポーネントの再利用を優先

## ライセンス

MIT

## 作成者

ソウマ

## バージョン履歴

- **v0.1.0** (2025-12-09)
  - 初期セットアップ
  - Laravel 12.41.1
  - サイドバーナビゲーション実装
  - 認証機能 (Laravel Breeze)
