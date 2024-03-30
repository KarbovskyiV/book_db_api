<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportCSVBookRequest;
use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    /**
     * Imports data from a CSV file and inserts it into the database.
     *
     * @param ImportCSVBookRequest $request.
     * @return JsonResponse
     */
    public function importCSVDataToDatabase(ImportCSVBookRequest $request): JsonResponse
    {
        $file = $request->file('file');

        if ($file) {
            $stream = fopen($file->getPathname(), 'r');

            $header = fgetcsv($stream);
            $header = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $header);

            $rows = [];
            while (($row = fgetcsv($stream)) !== false) {
                $rows[] = $row;
            }

            fclose($stream);

            $books = [];
            foreach ($rows as $row) {
                $books[] = array_combine($header, $row);
            }

            try {
                Book::query()->insert($books);
                return response()->json(['message' => 'Data imported successfully']);
            } catch (\Exception $e) {
                Log::error('Error importing CSV: ' . $e->getMessage());

                return response()->json(['error' => 'Failed to import data'], 500);
            }
        }

        return response()->json(['error' => 'File not found'], 400);
    }

    public function getBooksInfo(): Collection
    {
        return Book::all(['title', 'authors', 'publisher', 'year']);
    }

    public function index(): Collection
    {
        return Book::all();
    }
}
