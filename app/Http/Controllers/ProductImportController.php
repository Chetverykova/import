<?php

namespace App\Http\Controllers;

use App\Imports\CategoriesImport;
use Illuminate\Http\Request;
use App\Imports\ProductsImport;

class ProductImportController extends Controller
{
    public function show()
    {
        return view('products.import');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xls,xlsx|max:20000'
        ]);

        $file = $request->file('file')->store('import');

        set_time_limit(600);

        $categoryImport = new CategoriesImport();
        $categoryImport->import($file);
        $categoryFailures = $categoryImport->failures();
        
        $productImport = new ProductsImport();
        $productImport->import($file);
        $productFailures = $productImport->failures();
        
        return view('products.import', ['productFailures' => $productFailures, 'categotyFailure' => $categoryFailures]);
    }
}
