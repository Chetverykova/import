<?php

namespace App\Imports;

use App\Models\{Category, Product};
use Maatwebsite\Excel\Concerns\{ToModel, Importable, WithChunkReading, WithBatchInserts, WithValidation, 
    SkipsOnFailure, SkipsOnError, SkipsErrors, SkipsFailures};

class ProductsImport implements WithChunkReading, WithBatchInserts, SkipsOnError, WithValidation,ToModel, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    public function model(array $row)
    {
        $category = Category::where('type', '=', $row[0])
        ->where('category', '=', $row[1])
        ->where('subcategory', '=', $row[2])
        ->first();

        if (!empty($category)) {
            return new Product([
                'manufacturer' => $row[3],
                'product' => $row[4],
                'set_number' => $row[5],
                'description' => $row[6],
                'price' => $row[7],
                'assuarance' => $row[8],
                'in_stock' => $row[9],
                'category_id' => $category->id
            ]);
        }
    }

    public function rules(): array
    {
        return [
            '3' => function($attribute, $value, $onFailure) {
                if (empty($value)) {
                    $onFailure('Manufacturer name is empty.');
                }
            },
            '4' => function($attribute, $value, $onFailure) {
                if (empty($value)) {
                    $onFailure('Product name is empty.');
                }
            },
            '5' => function($attribute, $value, $onFailure) {
                if (empty($value)) {
                    $onFailure('Set number is empty.');
                }
            },
            '6' => function($attribute, $value, $onFailure) {
                if (empty($value)) {
                    $onFailure('Descriptionr is empty.');
                }
            },
            '7' => function($attribute, $value, $onFailure) {
                if (empty($value)) {
                    $onFailure('Descriptionr is empty.');
                } elseif (gettype($value) == 'string') {
                    $onFailure('Wrong price format.');
                }
            },
            '8' => function($attribute, $value, $onFailure) {
                if (empty($value)) {
                    $onFailure('Descriptionr is empty.');
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
