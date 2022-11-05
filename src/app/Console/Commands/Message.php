<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\MeshData;
use Carbon\Carbon;

class Message extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:message {mode=read : read, write, write-format, read-db}{--dry-run : Dry run write}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Read Slack Message JSON, and Read/Write CosmosDB';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $mode = $this->argument("mode");
        $dry_run = $this->option('dry-run');
        if (!method_exists($this, $func_name = 'Exec'.Str::studly($mode))) {
            return 0;
        }

        $this->$func_name($dry_run);
        return 1;
    }

    /**
     * Slackメッセージのjsonを読み込む
     *
     * @param bool $dry_run
     * @return void
     */
    private function ExecRead(bool $dry_run = false)
    {
        $files = Storage::disk('local')->files();
        foreach ($files as $file_name)
        {
            if (!preg_match('/.json$/', $file_name)) {
                continue;
            }
            $json = Storage::disk('local')->get($file_name);
            $data = json_decode($json);
            print_r("--------------------------------------".PHP_EOL);
            foreach ($data as $row)
            {
                print_r(@$row->attachments[0]->text);
                print_r(PHP_EOL."--------------------------------------".PHP_EOL);
            }
        }
        return;
    }

    /**
     * SlackメッセージのjsonをCosmosDBへ書き込む
     *
     * @param bool $dry_run
     * @return void
     */
    private function ExecWrite(bool $dry_run = false)
    {
        $files = Storage::disk('local')->files();
        foreach ($files as $file_name)
        {
            if (!preg_match('/.json$/', $file_name)) {
                continue;
            }
            $json = Storage::disk('local')->get($file_name);
            $data = json_decode($json);
            $meshData = new MeshData();
            foreach ($data as $row)
            {
                // 生データ
                $text = @$row->attachments[0]->text;
                print_r($text);
                print_r(PHP_EOL.PHP_EOL);

                $metrics = explode(PHP_EOL, $text);
                if (count($metrics) !== 3) {
                    // 日時・温度・湿度の3要素揃っていない可能性が高いのでスキップ
                    print_r('skip.');
                    print_r(PHP_EOL."--------------------------------------".PHP_EOL);
                    continue;
                }

                // 連想配列に変換(日付・数値のみに加工)
                list($time, $temp, $humid) = $metrics;
                $metrics = [
                    'time' => $time = str_replace('日時：', '', $time),
                    'temp' => $temp = str_replace(['温度：', '℃'], '', $temp),
                    'humid' => $humid = str_replace(['湿度：', '％'], '', $humid),
                ];

                // 既存チェック
                if ($meshData->find($time)) {
                    print_r("time \"{$time}\" is exist.");
                } else {
                    print_r("time \"{$time}\" is not exist.");
                    print_r(PHP_EOL.PHP_EOL);
                    print_r($metrics);
                    if (!$dry_run) {
                        // データ追加
                        $meshData->save($metrics);
                        print_r(PHP_EOL.'save success.');
                    }
                }

                print_r(PHP_EOL."--------------------------------------".PHP_EOL);
            }
        }
        return;
    }

    /**
     * CosmosDBのデータをフォーマットして上書き
     *
     * @param bool $dry_run
     * @return void
     */
    private function ExecWriteFormat(bool $dry_run = false)
    {
        $meshData = new MeshData();
        $data = $meshData->findAll();
        foreach ($data as $row)
        {
            // 日付フォーマット
            if (isset($row->time)) {
                $row->time = Carbon::parse($row->time)->format('Y-m-d H:i:s');
            }
            print_r($row);

            if (!$dry_run) {
                // データ上書き
                $meshData->save((array)$row);
                print_r(PHP_EOL.'update success.');
            }

            print_r(PHP_EOL."--------------------------------------".PHP_EOL);
        }
        return;
    }

    /**
     * CosmosDBのデータを読み込む
     *
     * @param bool $dry_run
     * @return void
     */
    private function ExecReadDb(bool $dry_run = false)
    {
        $meshData = new MeshData();
        $data = $meshData->findAll();
        foreach ($data as $row) {
            print_r($row);
            print_r(PHP_EOL."--------------------------------------".PHP_EOL);
        }
        return;
    }
}
