<?php

namespace App\Models\Admin;


use App\Models\User;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Storage;

//class QuestionsImport implements ToModel, WithHeadingRow, WithValidation
class QuestionsImport implements ToCollection, WithHeadingRow, WithValidation, ToModel
{
    private $rows = 0;

    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {
            $question = Question::create([
                'name' => $row['name'],
                'type' => $row['type'],
                'level' => $row['level'],
                'description' => $row['description'],
                'lesson_id' => $row['lesson_id'],
                'points' => $row['points'],
                'time' => $row['time'],
                'photo' => empty($row['photo']) ? null : $this->downloadThumbnail($row['photo']),
            ]);

        }
    }

    public function model(array $row)
    {
        ++$this->rows;
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }

    public function rules(): array
    {
        return [

        ];
    }

    public function downloadThumbnail($url)
    {
        try {
            $filePath = null;
            // Fetch the image content from the remote URL
            $imageContent = file_get_contents($url);
            // Check if the content was fetched successfully
            if ($imageContent !== false) {
                // Generate a unique filename
                $filename = uniqid() . '.' . pathinfo($url, PATHINFO_EXTENSION);

                // Save the image to the 'products' directory in the storage disk
                $filePath = 'images/questions/'. $filename;
                \Illuminate\Support\Facades\Storage::disk('questions')->put($filename, $imageContent);


            } else {
                // Handle error if image content couldn't be fetched
                Log::info('Failed to fetch the remote image.');
            }
            Log::info('$filePath: ' . $filePath);

            return $filePath;
        } catch (\Exception $e) {
            // Log any exceptions
            Log::error('Exception occurred: ' . $e->getMessage());
            return null;
        }

    }

    public function downloadGalleryImages($urls)
    {
        $data = array();
        foreach (explode(',', str_replace(' ', '', $urls)) as $url) {
            $data[] = $this->downloadThumbnail($url);
        }
        return implode(',', $data);
    }
}
