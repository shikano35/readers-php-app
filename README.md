この作品は 2024 年 7 月に作成しました

## 動作手順

### MAMP

1. 「/Applications/MAMP/htdocs/」内に本プロジェクトを添付
2. MAMP を起動
3. ターミナルに「/Applications/MAMP/Library/bin/mysql -u root -p」と入力し、実行
4. MySQL サーバに接続している状態で「\. /Applications/MAMP/htdocs/readers/init.sql」を実行
5. 「`http://localhost:8888/readers/public/`」によってトップページを表示

### XAMPP

1. 「/Applications/XAMPP/xamppfiles/htdocs/」内に本プロジェクトを添付
2. XAMPP Control Panel の「Apache Web Server」と「MySQL Database」を起動
3. ターミナルに「/Applications/XAMPP/xamppfiles/bin/mysql -u root -p」と入力し、MySQL サーバを実行
4. MySQL サーバに接続している状態で「\. /Applications/XAMPP/xamppfiles/htdocs/readers/init.sql」を実行
5. 「`http://localhost/readers/public/index.php`」によってトップページを表示

## 管理者権限

メールアドレス: system@system
パスワード: system
