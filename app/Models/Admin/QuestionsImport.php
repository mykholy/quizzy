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
            if (empty($row['type']))
                continue;
            $teacher_id = null;
            if (auth('teacher')->check())
                $teacher_id = auth('teacher')->id();

            $question = Question::create([
                'teacher_id' => $teacher_id,
                'name' => trim($row['name']),
                'type' => trim($row['type']),
                'level' => trim($row['level']),
                'description' => trim($row['description']),
                'lesson_id' => trim($row['lesson_id']),
                'points' => trim($row['points']),
                'reference' => trim($row['reference']),
                'time' => trim($row['time']),
                'photo' => empty($row['photo']) ? null : $this->downloadThumbnail(trim($row['photo']), 'questions'),
                'file' => empty($row['file']) ? null : $this->downloadThumbnail(trim($row['file']), 'questions'),
            ]);

            $answes = ['answer_1', 'answer_2', 'answer_3', 'answer_4'];
            $correct_answers = isset($row['correct_answers']) ? explode(',', $row['correct_answers']) : [];
            foreach ($answes as $index => $answer) {
                $index++;
                if ($question->type == Question::$QUESTION_TYPE_TRUE_FALSE && $index > 2)
                    break;
                if (($question->type == Question::$QUESTION_TYPE_SHORT_ANSWER || $question->type == Question::$QUESTION_TYPE_LONG_ANSWER) && $index > 1)
                    break;

                $data = [
                    'title' => trim($row[$answer]),
                    'answer_two_gap_match' => trim($row['answer_two_gap_match']) ?? null,
                    'answer_view_format' => empty($row["answer_view_format_$index"]) ? "text" : trim($row["answer_view_format_$index"]),
                    'photo' => empty($row["answer_photo_$index"]) ? null : $this->downloadThumbnail(trim($row["answer_photo_$index"]), 'answers'),
                    'is_correct' => in_array($index, $correct_answers),
                ];
                $this->addAnswer($question, $data);

            }

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

    public function downloadThumbnail($url, $folder)
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
                $filePath = "images/$folder/" . $filename;
                \Illuminate\Support\Facades\Storage::disk("$folder")->put($filename, $imageContent);


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

    public function addAnswer($question, $request_data)
    {
        $request_data['question_type'] = $question->type;
        $request_data['question_id'] = $question->id;

        //update other answer
        if ((($question->type == Question::$QUESTION_TYPE_SINGLE_CHOICE || $question->type == Question::$QUESTION_TYPE_TRUE_FALSE) && $request_data['is_correct'])) {
            if ($question->answers && !empty($request_data['is_correct']))
                $question->answers()->update([
                    'is_correct' => false,
                ]);
        } elseif ($question->type == Question::$QUESTION_TYPE_MULTIPLE_CHOICE || $question->question_type == Question::$QUESTION_TYPE_TRUE_FALSE) {
            if (!$request_data['is_correct'])
                $request_data['is_correct'] = false;
        }


        /** @var Answer $answer */
        $answer = Answer::create($request_data);

    }
}
