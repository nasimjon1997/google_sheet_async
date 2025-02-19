<?php

namespace App\Http\Controllers;

use App\Models\GoogleSheet;
use Illuminate\Http\Request;

class GoogleSheetController extends Controller
{
    public function index()
    {
        $spreadsheet = GoogleSheet::latest()->first(); // Получаем последний сохраненный spreadsheetId
        return view('google_sheets.index', compact('spreadsheet'));
    }

    public function update(Request $request)
    {
        // Валидируем данные
        $request->validate([
            'spreadsheet_id' => 'required|string',
        ]);

        // Обновляем или создаем запись с новым spreadsheetId
        $spreadsheet = GoogleSheet::firstOrCreate(
            [], // Если записи нет, создаем новую
            ['spreadsheet_id' => $request->spreadsheet_id]
        );

        // Обновляем значение
        $spreadsheet->update([
            'spreadsheet_id' => $request->spreadsheet_id,
        ]);

        return redirect()->route('google_sheets.index');
    }
}
