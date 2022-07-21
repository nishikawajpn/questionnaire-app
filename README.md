# アンケートアプリ

選択形式のアンケート（最大10択）をつくったり、回答したり、コメントを投稿したりできるアプリケーションです。

<!-- # DEMO

"hoge"の魅力が直感的に伝えわるデモ動画や図解を載せる -->

# Features

アンケートに回答すると、即座に選択肢ごとの割合を表示します。未回答時、この数字は見えません。

<!-- # Requirement

* huga 3.5.2
* hogehuga 1.0.2 -->

<!-- # Installation

Requirementで列挙したライブラリなどのインストール方法を説明する

```bash
pip install huga_package
``` -->

# Usage

下記ファイルへ、DB情報（ホスト・DB名・ユーザー名・パスワード）を入力してください。
/php/db/datasource.php

必要に応じて、DSN（データソース名）も変更してください。

テストデータのSQLは、data.sqlファイルに記載しています。

# Note

CSSの編集は、/_src/sass/内のscssファイルで行い、gulp.jsでコンパイルして、/assets/css/内に出力されます。

CSSを編集する場合、まずは必要なパッケージをインストールします。

```bash
npm install
```

次に、gulp.jsでコンパイルします。

```bash
gulp release
```

<!-- # Author

作成情報を列挙する

* 作成者
* 所属
* E-mail -->

<!-- # License
ライセンスを明示する

"hoge" is under [MIT license](https://en.wikipedia.org/wiki/MIT_License).

社内向けなら社外秘であることを明示してる

"hoge" is Confidential. -->



<!-- # アンケートアプリ

トピックについて複数の選択肢から回答したり、コメントしたりできるアンケートアプリです。


## 技術スタック

HTML5, CSS3, Sass(SCSS), JavaScript, PHP, SQL


## Features

HTML5やSass、JavaScript（ES6）、PHPを使って、MVCモデルで作成しました。
Sass（SCSS）は、タスクランナー（gulp）によりコンパイルしています。 -->
