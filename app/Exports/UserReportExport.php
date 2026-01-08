<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserReportExport implements FromCollection, WithHeadings
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
            $user = $group['user'];

            foreach ($group['entries'] as $entry) {

                $duration = (float) $entry['duration_number'];
                $unit = strtolower($entry['duration_unit']);

                $durationInMinutes = match ($unit) {
                    'minute', 'minutes' => $duration,
                    'hour', 'hours'     => $duration * 60,
                    'day', 'days'       => $duration * 1440,
                    default             => null, // or throw
                };

                $rows[] = [
                    'log_date'          => $entry['log_date'],
                    'user'              => $user,
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
