<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Documents;
use App\Models\PendingTask;
use Carbon\Carbon;

class GenerateTasks extends Command
{
    protected $signature = 'tasks:generate';
    protected $description = 'Generate pending tasks based on document periods';

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
                        // daily selalu dibuat hari ini
                        $this->createTaskIfNotExists($doc->id_documents, $today);
                        break;

                    case 'weekly':
                        foreach ($values as $dayName) {
                            $dayName = trim($dayName);
                            if ($dayName === '') continue;

                            $occurrence = $this->getNextOrSameWeekday($today, $dayName);
                            $creationDate = $occurrence->copy()->subDays($creatingTaskDays);

                            // buat task jika hari ini antara creationDate..occurrence
                            if ($today->betweenIncluded($creationDate, $occurrence)) {
                                $this->createTaskIfNotExists($doc->id_documents, $occurrence);
                            }
                        }
                        break;

                    case 'yearly':
                        foreach ($values as $dateString) {
                            $dateString = trim($dateString);
                            if ($dateString === '') continue;

                            // cek occurrence di tahun ini dan tahun depan
                            foreach ([$today->year, $today->year + 1] as $year) {
                                try {
                                    $occurrence = Carbon::createFromFormat('j F Y', $dateString . ' ' . $year);
                                } catch (\Exception $e) {
                                    // fallback format d F
                                    try {
                                        $occurrence = Carbon::createFromFormat('d F Y', $dateString . ' ' . $year);
                                    } catch (\Exception $e2) {
                                        continue; // tidak bisa parse
                                    }
                                }

                                $creationDate = $occurrence->copy()->subDays($creatingTaskDays);

                                if ($today->betweenIncluded($creationDate, $occurrence)) {
                                    $this->createTaskIfNotExists($doc->id_documents, $occurrence);
                                    break; // sudah buat task untuk dateString ini
                                }
                            }
                        }
                        break;
                }
            }
        }

        $this->info("Pending tasks generated successfully.");
    }

    private function normalizePeriodValue($value)
    {
        if (is_array($value)) return $value;

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }

            // fallback: split comma atau titik koma
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

        $daysToAdd = ($target - $ref->dayOfWeek + 7) % 7; // 0–6
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
                'status' => 'null'
            ]);

            $this->info("Created pending_task for document {$documentId} date {$dateString}");
        }
    }
}
