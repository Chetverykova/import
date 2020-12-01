<?php

namespace App\Imports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\{
    ToModel, Importable, WithChunkReading, WithBatchInserts, WithValidation, SkipsOnFailure, SkipsOnError, 
    SkipsErrors, SkipsFailures, RegistersEventListeners
};

class CategoriesImport implements WithChunkReading, WithBatchInserts, SkipsOnError, WithValidation, ToModel, SkipsOnFailure
{
    use Importable,
    SkipsErrors, 
    SkipsFailures, 
    RegistersEventListeners;

    public function model(array $row)
    {
        return new Category([
            'type' => $row[0],
            'category' => $row[1],
            'subcategory' => $row[2]
        ]);
    }

    public function rules(): array
    {
        return [
            '0' => function($attribute, $value, $onFailure) {
                if (empty($value)) {
                    $onFailure('Category type is empty.');
                }
            },
            '1' => function($attribute, $value, $onFailure) {
                if (empty($value)) {
                    $onFailure('Category name is empty.');
                }
            },
            '2' => function($attribute, $value, $onFailure) {
                if (empty($value)) {
                    $onFailure('Subcategory name is empty.');
                }
            },
        ];
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function batchSize(): int
    {
        return 100;
    }
}
