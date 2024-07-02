<?php

namespace App\Services;

use Google_Client;
use Google_Service_Sheets;
use Google_Service_Sheets_Spreadsheet;
use Google_Service_Sheets_SpreadsheetProperties;
use Google_Service_Drive;
use Google_Service_Drive_Permission;

class GoogleSheetsService
{
    protected $client;
    protected $sheetsService;
    protected $driveService;
    protected $spreadsheetId;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setAuthConfig(config('google.sheets.credentials_path'));
        $this->client->addScope(Google_Service_Sheets::SPREADSHEETS);
        $this->client->addScope(Google_Service_Drive::DRIVE);
        $this->sheetsService = new Google_Service_Sheets($this->client);
        $this->driveService = new Google_Service_Drive($this->client);
    }

    public function setSpreadsheetId($spreadsheetId)
    {
        $this->spreadsheetId = $spreadsheetId;
    }

    public function appendRow($range, $values)
    {
        $body = new \Google_Service_Sheets_ValueRange([
            'values' => $values
        ]);

        $params = [
            'valueInputOption' => 'RAW'
        ];

        return $this->sheetsService->spreadsheets_values->append($this->spreadsheetId, $range, $body, $params);
    }

    public function createSpreadsheet($title)
    {
        $spreadsheet = new Google_Service_Sheets_Spreadsheet([
            'properties' => new Google_Service_Sheets_SpreadsheetProperties([
                'title' => $title
            ])
        ]);

        $spreadsheet = $this->sheetsService->spreadsheets->create($spreadsheet, [
            'fields' => 'spreadsheetId'
        ]);

        return $spreadsheet->spreadsheetId;
    }

    public function shareSpreadsheet($spreadsheetId, $email, $role)
    {
        $permission = new Google_Service_Drive_Permission([
            'type' => 'user',
            'role' => $role,
            'emailAddress' => $email
        ]);

        return $this->driveService->permissions->create($spreadsheetId, $permission);
    }
}
