<?php

namespace App\Imports;

use App\Models\Candidate;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class CandidatesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Normalize headers: lowercase, remove dots, spaces, dashes, trailing underscores
        $row = collect($row)->mapWithKeys(function ($value, $key) {
            // Use Stringable, but convert to string at the end
            $key = Str::of($key)
                ->lower()
                ->replace([' ', '.', '-'], '_')
                ->rtrim('_')
                ->toString(); // <- IMPORTANT
            return [$key => $value];
        })->toArray();

        // Handle sr_no variations
        $sr_no = $row['sr_no'] ?? $row['srno'] ?? $row['s_no'] ?? null;

        return new Candidate([
            'sr_no' => $sr_no,
            'roll_no' => $row['roll_no'] ?? null,
            'name' => $row['name'] ?? null,
            'father_name' => $row['father_name'] ?? null,
            'cnic' => $row['cnic'] ?? null,
            'post_applied_for' => $row['post_applied_for'] ?? null,
            'postal_address' => $row['postal_address'] ?? null,
            'mobile_no' => $row['mobile_no'] ?? null,
            'paper' => $row['paper'] ?? null,
            'test_date' => $row['test_date'] ?? null,
            'session' => $row['session'] ?? null,
            'reporting_time' => $row['reporting_time'] ?? null,
            'conduct_time' => $row['conduct_time'] ?? null,
            'venue' => $row['venue'] ?? null,
        ]);
    }
}
