<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Document;
use Illuminate\Http\Request;
use ZipArchive;
use Symfony\Component\HttpFoundation\StreamedResponse;

class IdeaExportController extends Controller
{
    public function exportCombined()
    {
        
        $masterZipFileName = 'combined_export.zip';
        $zip = new ZipArchive();
        $zipPath = storage_path("app/public/$masterZipFileName");

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
           
            $csvFileName = 'ideas_export.csv';
            $csvFilePath = storage_path("app/public/$csvFileName");

           
            $callback = function () use ($csvFilePath) {
                $file = fopen($csvFilePath, 'w');
                fputcsv($file, ['Idea ID', 'Title', 'Description', 'Submitted By', 'Category ID', 'Created At']);
                $ideas = Idea::all();
                foreach ($ideas as $idea) {
                    fputcsv($file, [
                        $idea->idea_id,
                        $idea->title,
                        $idea->description,
                        optional($idea->user)->name ?? 'Anonymous',
                        $idea->category_id,
                        $idea->created_at,
                    ]);
                }
                fclose($file);
            };
            $callback();

           
            $zip->addFile($csvFilePath, $csvFileName);

           
            $documentsZipFileName = 'documents_export.zip';
            $documentsZipPath = storage_path("app/public/$documentsZipFileName");

            $documentsZip = new ZipArchive();
            if ($documentsZip->open($documentsZipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                $documents = Document::all();
                foreach ($documents as $document) {
                    $filePath = storage_path("app/public/" . $document->file_path);
                    if (file_exists($filePath)) {
                        $documentsZip->addFile($filePath, basename($filePath));
                    }
                }
                $documentsZip->close();
            }

            
            $zip->addFile($documentsZipPath, $documentsZipFileName);

            
            $zip->close();

           
            return response()->download($zipPath)->deleteFileAfterSend(true);
        }

        return response()->json(['error' => 'Could not generate the files'], 500);
    }
}

