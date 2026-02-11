# CostFlow
サブスクリプションと固定費を管理し、収入に対する支出の割合を可視化するアプリケーション

## 概要
CostFlowは、月々のサブスクリプションや固定費を一元管理し、収入に対する支出の割合を把握できるWebアプリケーションです。

## URL / ER図 / 画面設計図 

### URL
CostFlow - https://costflow.fly.dev<br>
画面右上の始めるボタンから新規登録をし、使うことができます。

### ER図
ER図 - https://drawsql.app/teams/amos-9/diagrams/costflow

### 画面設計図
画面設計図 - https://www.figma.com/design/zbmLY4QvsA8P0QxcqLFrwu/%E5%9B%BA%E5%AE%9A%E8%B2%BB%E7%AE%A1%E7%90%86%E3%82%A2%E3%83%97%E3%83%AAFW?node-id=0-1&p=f&t=RsFwimZ0HO2T8dSD-0
### LP
<img width="2940" height="3248" alt="Image" src="https://github.com/user-attachments/assets/c5fd7a89-490b-490a-8678-e510dbf93922" />

### 管理画面
<img width="2940" height="1906" alt="Image" src="https://github.com/user-attachments/assets/f8c77aa3-fd14-40ef-b727-4e25f3b3ffcc" />

### サブスク管理画面
<img width="2940" height="2092" alt="Image" src="https://github.com/user-attachments/assets/af30d6c1-f907-4541-8512-cc29135efbd0" />

### 固定費管理画面
<img width="2940" height="2092" alt="Image" src="https://github.com/user-attachments/assets/12327a86-37ee-4310-98eb-05a6d8ac3321" />

## 機能一覧

### 認証機能
- ユーザー登録・ログイン・ログアウト
- パスワードリセット

### ダッシュボード
- 月額合計の表示
- 収入に対する支出割合
- サブスク・固定費一覧表示
- サブスク・固定費ごとの合計金額表示
- 月収の登録・更新
- 支出割合の自動計算
- **ApexChartsによる円グラフ可視化**
  
### サブスクリプション管理
- サブスク一覧表示
- 新規登録・編集・削除・詳細表示
- 高負担な項目をTOP3表示
- カテゴリ分類（エンタメ・仕事・学習など）
- 支払日の設定
- 有効/一時停止/解約ステータス切り替え
- **メモ機能**

### 固定費管理
- 固定費一覧表示
- 新規登録・編集・削除・詳細表示
- 高負担な項目をTOP3表示
- カテゴリ分類（エンタメ・仕事・学習など）
- 支払日の設定
- 有効/一時停止/解約ステータス切り替え
- **メモ機能**

## テスト
- **PHPUnit**: 27件のフィーチャーテスト
- CRUD操作、認証、認可のテスト

## 技術スタック

### バックエンド
- **Laravel**: 12.x
- **PHP**: 8.4
- **PostgreSQL**: 17
- **Redis**: Alpine (キャッシュ・セッション管理)

### フロントエンド
- **Vite**: 7.2.6
- **Laravel Vite Plugin**: 2.0.1
- **Tailwind CSS**: 3.x
- **Alpine.js**: 3.x (Laravel Breezeに含まれる)
- **ApexCharts**: データ可視化

### 開発環境・インフラ
- **Docker**: Laravel Sail (開発環境)
- **Fly.io**: 本番環境デプロイ

### 主要パッケージ
- **Laravel Breeze**: 認証機能
- **Blade UI Kit (Heroicons)**: アイコン管理
- **Laravel Vite Plugin**: Vite統合
