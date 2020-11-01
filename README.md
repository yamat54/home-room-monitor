# 自宅室内監視ツール

MESHで取得したメトリック(温度・湿度)のデータを可視化するツールです。<br>
フレームワークはLaravelを使用しています。

## セットアップ

```
$ composer install
```
```
$ cp .env.example .env
```

## 起動

```
$ php artisan serve 
```
```
$ open http://127.0.0.1:8000/
```

## データメンテナンス

MESHでSlack連携していたメトリック(温度・湿度)のデータを<br>
SlackメッセージからCosmosDBへインポートするツールを用意しています。

### 1. Slackメッセージを読み込む

SlackでエクスポートしたJSONファイルを読み込みます。<br>
主に確認用です。

```
$ php artisan command:message read
```

### 2. Slackメッセージをインポートする

SlackメッセージをCosmosDBへインポートします。

```
$ php artisan command:message write
```

### 3. 再フォーマットしてデータを更新する

CosmosDBのデータを再フォーマットして更新します。

```
$ php artisan command:message write-format
```

### 4. データを確認する

CosmosDBのデータを確認します。

```
$ php artisan command:message read-db
```

## デモサイト
https://home-room-monitor.herokuapp.com
