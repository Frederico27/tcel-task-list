<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Documents;
use App\Models\PendingTask;
use Carbon\Carbon;

class CheckMissedTasks extends Command
{
    protected $signature = 'tasks:check-missed';
    protected $description = 'Check and create missed pending tasks based on document periods for the current year';

    public function handle()
    {
        $today = Carbon::today();
        $documents = Documents::with('periods')->get();

        foreach ($documents as $doc) {
            $creatingTaskDays = (int) ($doc->creating_task ?? 0);

            foreach ($doc->periods as $period) {
                $values = $this->normalizePeriodValue($period->period_value);

                switch ($period->period_type) {
                    case 'daily':
                        // Periksa apakah tugas untuk hari ini sudah ada, jika belum buat tugas
                        $this->createTaskIfNotExists($doc->id_documents, $today);
                        break;

                    case 'weekly':
                        foreach ($values as $dayName) {
                            $dayName = trim($dayName);
                            if ($dayName === '') continue;

                            // Start from the most recent occurrence of the specified weekday (on or before today)
                            $currentWeekday = $this->getNextOrSameWeekday($today, $dayName);
                            if ($currentWeekday->gt($today)) {
                                $currentWeekday->subWeek(); // Go to previous week if the calculated date is in the future
                            }

                            // Iterate backward to the start of the year
                            $startOfYear = Carbon::create($today->year, 1, 1)->startOfDay();
                            while ($currentWeekday->gte($startOfYear)) {
                                // Create task for this weekday if it doesn't exist
                                $creationDate = $currentWeekday->copy()->subDays($creatingTaskDays);
                                $this->createTaskIfNotExists($doc->id_documents, $currentWeekday);

                                // Move to the previous week
                                $currentWeekday->subWeek();
                            }
                        }
                        break;

                    case 'yearly':
                        foreach ($values as $dateString) {
                            $dateString = trim($dateString);
                            if ($dateString === '') continue;

                            foreach ([$today->year] as $year) {
                                try {
                                    $occurrence = Carbon::createFromFormat('j F Y', $dateString . ' ' . $year);
                                } catch (\Exception $e) {
                                    try {
                                        $occurrence = Carbon::createFromFormat('d F Y', $dateString . ' ' . $year);
                                    } catch (\Exception $e2) {
                                        try {
                                            $occurrence = Carbon::createFromFormat('d M Y', $dateString . ' ' . $year); // 10 Sep 2025
                                        } catch (\Exception $e3) {
                                            $this->error("Failed to parse date: $dateString");
                                            continue;
                                        }
                                    }
                                }
                            }


                            // Check if the date is in the current year and in the past
                            if ($occurrence->year === $today->year && $occurrence->lessThanOrEqualTo($today)) {
                                $creationDate = $occurrence->copy()->subDays($creatingTaskDays);
                                $this->createTaskIfNotExists($doc->id_documents, $occurrence);
                            }
                        }
                        break;
                }
            }
        }

        $this->info("Checked and created missed pending tasks successfully.");
    }

    private function normalizePeriodValue($value)
    {
        if (is_array($value)) return $value;

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }

            // Fallback: split comma atau titik koma
            $parts = preg_split('/[\,\;]+/', $value);
            return array_map('trim', array_filter($parts, fn($v) => $v !== ''));
        }

        return [];
    }

    private function getNextOrSameWeekday(Carbon $reference, $weekday)
    {
        $map = [
            'sunday' => 0,
            'monday' => 1,
            'tuesday' => 2,
            'wednesday' => 3,
            'thursday' => 4,
            'friday' => 5,
            'saturday' => 6
        ];

        $key = strtolower($weekday);
        if (!isset($map[$key])) return $reference->copy()->startOfDay();

        $target = $map[$key];
        $ref = $reference->copy()->startOfDay();

        // Hitung selisih hari ke target (positive jika hari yang lebih baru, negatif jika hari yang lebih lama)
        $daysToAdd = ($target - $ref->dayOfWeek + 7) % 7;

        // Jika daysToAdd adalah 0, kita berada di hari yang sama, sehingga cari hari sebelumnya jika diperlukan
        if ($daysToAdd == 0 && $ref->lt($reference)) {
            $daysToAdd = -7; // Ambil hari yang sudah lewat, dalam hal ini Kamis minggu lalu
        }

        return $ref->copy()->addDays($daysToAdd);
    }

    private function createTaskIfNotExists($documentId, Carbon $date)
    {
        $dateString = $date->toDateString();

        $exists = PendingTask::where('id_documents', $documentId)
            ->whereDate('periode_date', $dateString)
            ->exists();

        if (!$exists) {
            PendingTask::create([
                'id_documents' => $documentId,
                'periode_date' => $dateString,
                'upload' => '',
                'status' => 'waiting_document',
            ]);

            $this->info("Created missed pending_task for document {$documentId} date {$dateString}");
        }
    }
}
