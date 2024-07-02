<?php

namespace App\Http\Controllers\Api;

use App\Services\GoogleSheetsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoogleSheetsController extends Controller
{
    protected GoogleSheetsService $googleSheetsService;

    public function __construct(GoogleSheetsService $googleSheetsService)
    {
        $this->googleSheetsService = $googleSheetsService;
    }

    public function addRow(Request $request)
    {
        $data = [
            [$request->input('column1'), $request->input('column2')]
        ];

        $spreadsheetId = $request->input('spreadsheet_id');

        $this->googleSheetsService->setSpreadsheetId($spreadsheetId);
        $this->googleSheetsService->appendRow('Sheet1!A1', $data);

        return response()->json(['message' => 'Data added successfully']);
    }

    public function createSpreadsheet(Request $request)
    {
        $title = $request->input('title');
        $spreadsheetId = $this->googleSheetsService->createSpreadsheet($title);

        return response()->json(['spreadsheet_id' => $spreadsheetId]);
    }
}
