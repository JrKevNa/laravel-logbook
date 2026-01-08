<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DailyReportExport implements FromCollection, WithHeadings
{
    protected $logsGrouped;

    public function __construct(array $logsGrouped)
    {
        $this->logsGrouped = $logsGrouped;
    }

    public function collection()
    {
        $rows = [];

        foreach ($this->logsGrouped as $group) {
            foreach ($group['entries'] as $entry) {

                $duration = (float) $entry['duration_number'];
                $unit = strtolower($entry['duration_unit']);

                $durationInMinutes = match ($unit) {
                    'minute', 'minutes' => $duration,
                    'hour', 'hours'     => $duration * 60,
                    'day', 'days'       => $duration * 60 * 24,
                    default             => null, // or 0, or throw
                };

                $rows[] = [
                    'log_date'          => $entry['log_date'],
                    'user'              => $entry['creator']['name'] ?? 'N/A',
                    'duration_minutes'  => $durationInMinutes,
                    'duration_unit'     => 'Minutes',
                    'activity'          => $entry['activity'] ?? '',
                ];
            }
        }

        return collect($rows);
    }


    public function headings(): array
    {
        return [
            'Log Date',
            'User',
            'Duration Number',
            'Duration Unit',
            'Activity',
        ];
    }
}
