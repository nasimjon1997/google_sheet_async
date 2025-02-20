<?php

namespace App\Console\Commands;

use App\Models\GoogleSheet;
use Illuminate\Console\Command;
use Google_Client;
use Google_Service_Sheets;

class FetchGoogleSheetData extends Command
{
    protected $signature = 'google:fetch {count?}';
    protected $description = 'Получает данные из Google Sheets и выводит их в консоль';

    public function handle()
    {
        $count = $this->argument('count') ? (int) $this->argument('count') : null;

        // Инициализация Google Sheets API
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google-credentials.json'));
        $client->addScope(Google_Service_Sheets::SPREADSHEETS_READONLY);

        $spreadsheet = GoogleSheet::first();
        $service = new Google_Service_Sheets($client);
        $spreadsheetId = $spreadsheet->spreadsheet_id; // ID вашего документа
        $range = 'A2:B'; // Диапазон для чтения данных (ИД модели и комментарии)

        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $rows = $response->getValues();

        if (empty($rows)) {
            $this->info('Данные отсутствуют.');
            return;
        }

        $totalRows = count($rows);
        $limit = $count ?? $totalRows;

        $this->info("Получено $totalRows строк, отображаем $limit:");

        $bar = $this->output->createProgressBar($limit);
        $bar->start();

        foreach (array_slice($rows, 0, $limit) as $row) {
            $bar->advance();
            $this->line("ID: {$row[0]} | Комментарий: {$row[1]}");
        }

        $bar->finish();
        $this->newLine();
    }
}
