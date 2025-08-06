# ドラマバカ一代 PHP版 基本仕様書 v1.0

## 文書情報
- **作成日**: 2025年8月6日
- **最終更新**: 2025年8月6日
- **バージョン**: 1.0
- **作成者**: Gemini & nakayamamasayuki

---

## 1. プロジェクト概要

### プロジェクト名
**ドラマバカ一代** (Drabaka)

### コンセプト
ドラマ好きの皆さんのための感想シェアサイト  
2000年代レトロデザインとモダン技術の融合による新感覚ドラマレビューサイト

### ターゲットユーザー
- ドラマ好きのユーザー（年齢問わず）
- 匿名で気軽に感想を共有したいユーザー
- モバイルでサクサク利用したいユーザー

### 差別化ポイント
- **完全モバイルファースト**: スマートフォン最適化設計
- **クリーンな収益モデル**: 寄付・ドネーション型運営予定
- **2000年代レトロUI**: 懐かしさと現代性の融合
- **軽量・高速**: PHP + MariaDBによる堅実な構成

---

## 2. 技術仕様

### フロントエンド
- **言語**: HTML5, CSS3, JavaScript (ES6+)
- **スタイリング**: CSS Modules or BEM + カスタムCSS
- **レスポンシブ**: Mobile First Design

### バックエンド・インフラ
- **サーバーサイド**: PHP 8.1+
- **データベース**: MariaDB 10.5+ (MySQL互換)
- **Webサーバー**: Apache
- **ホスティング**: Xserver
- **認証**: 匿名ベース（PHPセッション管理）

### 開発環境
- **ローカル環境**: Docker (PHP, MariaDB, Apache)
- **パッケージマネージャー**: Composer (予定)
- **バージョン管理**: Git

---

## 3. データベース設計

(Next.js版の設計を継承。`docs/移管計画/database_schema.sql` を正とする)

### テーブル構成

#### dramas テーブル
```sql
CREATE TABLE dramas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  `year` INT NOT NULL,
  season ENUM('spring', 'summer', 'autumn', 'winter') NOT NULL,
  broadcaster VARCHAR(100) NOT NULL,
  timeslot VARCHAR(50),
  air_day VARCHAR(20),
  genre VARCHAR(100),
  synopsis TEXT,
  main_cast TEXT,
  status ENUM('airing', 'completed', 'upcoming') DEFAULT 'upcoming' NOT NULL,
  featured_weekly BOOLEAN DEFAULT FALSE,
  featured_popular BOOLEAN DEFAULT FALSE,
  featured_priority INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

#### reviews テーブル
```sql
CREATE TABLE reviews (
  id CHAR(36) PRIMARY KEY,
  drama_id INT NOT NULL,
  nickname VARCHAR(50) DEFAULT '名無しさん' NOT NULL,
  rating INT NOT NULL,
  comment TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (drama_id) REFERENCES dramas(id) ON DELETE CASCADE
);
```

#### likes テーブル
```sql
CREATE TABLE likes (
  id CHAR(36) PRIMARY KEY,
  review_id CHAR(36) NOT NULL,
  user_session VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (review_id) REFERENCES reviews(id) ON DELETE CASCADE,
  UNIQUE KEY unique_like (review_id, user_session)
);
```

---

## 4. アーキテクチャ

### ディレクトリ構成 (案)
```
/Users/nakayamamasayuki/Documents/GitHub/draba/
├── src/                      # PHPソースコード
│   ├── public/               # 公開ディレクトリ (index.php, css, js, images)
│   │   ├── index.php         # フロントコントローラー
│   │   └── assets/           # CSS, JS, 画像
│   ├── app/                  # アプリケーションロジック
│   │   ├── controllers/      # リクエスト処理
│   │   ├── models/           # データモデルとDB操作
│   │   ├── views/            # HTMLテンプレート
│   │   └── core/             # コア機能 (DB接続, ルーターなど)
│   └── vendor/               # Composer依存関係
├── docs/                     # ドキュメント
│   ├── 基本設計書/
│   └── 移管計画/
├── db/                       # データベース関連
│   └── init/
│       └── 01_schema.sql
└── docker-compose.yml
```

---

## 5. 機能仕様

(Next.js版の設計を基本的に踏襲)

### 5.1 コア機能

#### トップページ (/)
- **今週の要注目**: 週間おすすめドラマ表示
- **話題のドラマ**: 人気・注目ドラマ一覧
- **最新の感想**: 最近投稿されたレビュー表示
- **お知らせ**: サイト更新情報
- **このサイトについて**: サイト説明・機能紹介

#### ドラマ詳細ページ (/drama.php?id=[id])
- **基本情報表示**: タイトル、放送局、時間、あらすじ等
- **統計情報**: 平均評価、レビュー数、評価分析
- **レビュー投稿フォーム**: ★5段階評価 + コメント
- **レビュー一覧**: 投稿されたレビューの表示
- **いいね機能**: レビューへの共感機能

#### サイドバー・ナビゲーション
- **放送中のドラマ**: 曜日別放送スケジュール
- **統計エリア**: サイト全体の統計情報
- **モバイルハンバーガーメニュー**: スマホ対応ナビ

---
(以降の項目は、Next.js版の仕様書を参考にしつつ、随時追記・修正していく)
