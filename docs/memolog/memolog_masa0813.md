2025_0813_1100
ドラマバカサイトPHP版開発を再開します

http://localhost:8081/

ありがとうございます、そうです！
思い出しました、これですね、
ローカル確認できたところでしたね。

＠/Users/nakayamamasayuki/Documents/GitHub/draba/docs/memolog/memolog_masa0810.ini
いちおう、ログチャットでこんな感じですすめてました。


そうです、この番組データをもってきたんですよね。
はい、お願いします


こんかい、わたしが進捗を把握していなかったのっがわたしのミスなんですが、
進捗を把握しやすいように、
別件でつけている、メモのようなものを例としてもってきました。
＠/Users/nakayamamasayuki/Documents/GitHub/draba/docs/代行作業log

本件でもこれを踏襲して、だれがいつどのように、
などメモしておくことを提案します。
つきましては、このファルダの把握からお願いします

はい、まさに把握してもらったとおりです。
雑にわたしてしまって失礼しました。
はい、別件の情報は例として、お示ししたかっただけですので、一度全部クリーンアップしてください。まっさらにしてから、このワークフローをつかって、私達のログを作成してください

そして、このワークフロー自体も、わたしたちの憲法として、
gemini.mdに記載お願いします


ありがとうございます、
またワークフローがととのってよかったです。
今後もアドバイスあったら随時お願いします

ローカル確認したUIはかなりいいんですよね。

＠/Users/nakayamamasayuki/Documents/GitHub/draba/docs/memolog/memolog_masa0806_1800.ini
/Users/nakayamamasayuki/Documents/GitHub/draba/docs/memolog/memolog_masa0806.ini
/Users/nakayamamasayuki/Documents/GitHub/draba/docs/memolog/memolog_masa0809.ini
/Users/nakayamamasayuki/Documents/GitHub/draba/docs/memolog/memolog_masa0810.ini

履歴たどってもらえると助かりますが、
9/30移行はVPS版に確実にのりかえるしなー、
というのがみえてるので、、
人間のわたしとしては、本音をいうと、自分が始めといててをつけた案件にもかかわらず、
正直、PHP版にそんなに情熱をもてていないんですね。

そう、もはやnextjsさわってると、PHPに興奮しないというか、、

まあ、どうせ、これから先20年とかは、nextjsがフレームワークは第1線、で輝くんだろうし、
まあ、逆にだからこそ、この1ヶ月のあいだに研究しつくしておこうとも思うんですがね。

そうですね。もうさっそくxserverにデプロイして本番でも反映すること、DBともつながることを見通してから進めれば、逆に少しモチベあがるでしょうか？
ローカルで実験してからのほうがいいのかな？


ありがとうございます、
B案：モチベーション優先で「デプロイ」に挑戦する
でいきましょう、

結局逆に、ここでレンタルサーバーならVPSより環境構築マイルドだったな、みたいな
知見を広げておけそうだし、
デザイン、環境構築含めて、まあやってきましょう


xserver管理画面から情報メモしてきました。↓
@/Users/nakayamamasayuki/Documents/GitHub/mn/documents/server/xserver

DBはwordpressでつかったときに、MySQLはあると思うんですが、よくわかってません。
まだ、それ以外はとくにないですね。

本件だと、mariaDBとかでしたけ？
設定おまかせします。


なるほど、そうかvpsだと、SSHキーを渡せば、設定DB、postgreSQLとかも、代行お願いできるけど、
レンタルサーバーだと、直接DB操作はできないということでしょうか？


ssh-keygen -y -f /Users/nakayamamasayuki/Documents/GitHub/draba/docs/資料/xserver/xs125748.key



ssh-ed25519AAAAC3NzaC1lZDI1NTE5AAAAIKqGBJsH4wA9/d32Jt8ShnRLcB2hBAX5KwWB64i1IWxh draba-xserver-key-20250813




MariaDB10.5 バージョン	10.5.x
MariaDB10.5 ホスト名	localhost
MariaDB10.5 IPアドレス	127.0.0.1
標準文字コード	EUC-JP、UTF-8、Shift_JIS、Binaryからお選びいただけます。

MySQL設定
関連マニュアル
MySQLデータベース、MySQL用ユーザの作成・削除を行うことができます。
MySQL用ユーザにアクセス権を与えることで初めてデータベースへのアクセスが可能になります。

MySQL一覧
 
MySQL追加
 
MySQLユーザ一覧
 
MySQLユーザ追加
 
MySQL情報
データベース	アクセス権所有ユーザ	アクセス権未所有ユーザ	変更	削除
xs125748_draba
ドラマバカPHP版

ユーザーはいません
 

xs125748_wp1( localhost )
 
xs125748_wp1 WordPress利用中	

xs125748_wp1( localhost )
 

xs125748_wp2( localhost )
 
xs125748_wp2 WordPress利用中	

xs125748_wp2( localhost )
 

xs125748_wp1( localhost )
 
xs125748_wp3 WordPress利用中	

xs125748_wp3( localhost )
 

xs125748_wp1( localhost )
 
xs125748_wp4 WordPress利用中	

xs125748_wp4( localhost )
 

xs125748_wp1( localhost )
 
xs125748_wp5 WordPress利用中	

xs125748_wp5( localhost )
 

xs125748_wp1( localhost )
 
mysql自体はできたんだけど、ユーザー追加がどうやるんだろう？