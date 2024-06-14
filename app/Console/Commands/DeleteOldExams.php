<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Exam;
use Carbon\Carbon;

class DeleteOldExams extends Command
{
    protected $signature = 'exam:delete-old';
    protected $description = 'Delete exams older than one month';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $oneMonthAgo = Carbon::now()->subMonth();
        Exam::where('created_at', '<', $oneMonthAgo)->delete();
        $this->info('Old exams deleted successfully.');
    }
}