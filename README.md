# Slack Message Converter

MESHでSlack連携していたメトリック(温度・湿度)のデータを、<br>
SlackメッセージからCosmosDBへインポートするための個人ツールです。<br>
フレームワークはLaravelを使用しています。

## 1. Slackメッセージを読み込む

SlackでエクスポートしたJSONファイルを読み込みます。<br>
主に確認ようです。

```bash
$ php artisan command:message read
```

## 2. Slackメッセージをインポートする

SlackメッセージをCosmosDBへインポートします。

```bash
$ php artisan command:message write
```
