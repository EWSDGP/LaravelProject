<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Symfony\Component\HttpFoundation\StreamedResponse;

class IdeaExportController extends Controller
{
 
   
        public function exportCSV()
        {
            $fileName = 'ideas_export.csv';
            $headers = [
                "Content-Type" => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
            ];
    
            $callback = function () {
                $file = fopen('php://output', 'w');
    
                
                fputcsv($file, ['Idea ID', 'Title', 'Description', 'Submitted By', 'Category ID', 'Created At']);
    
                
                $ideas = Idea::with('user')->get();
    
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
    
            return response()->stream($callback, 200, $headers);
        }
    
    

    
    public function exportZIP()
    {
        $zipFileName = 'documents_export.zip';
        $zipPath = storage_path("app/public/$zipFileName");

        $zip = new ZipArchive;

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            $documents = \App\Models\Document::all();

            foreach ($documents as $document) {
                $filePath = storage_path("app/public/" . $document->file_path);
                
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, basename($filePath));
                }
            }

            $zip->close();
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}
