<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Document;
use Illuminate\Http\Request;
use ZipArchive;
use Symfony\Component\HttpFoundation\StreamedResponse;


class IdeaExportController extends Controller
{
    public function exportCombined(Request $request)
    {
       
        $request->validate([
            'academic_year' => 'required|exists:closure_dates,ClosureDate_id'
        ]);
    
        $academicYearId = $request->input('academic_year');
    
        
        $masterZipFileName = 'combined_export.zip';
        $zip = new ZipArchive();
        $zipPath = storage_path("app/public/$masterZipFileName");
    
        
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
    
            
            $csvFileName = 'ideas_export.csv';
            $csvFilePath = storage_path("app/public/$csvFileName");
    
            
            $callback = function () use ($csvFilePath, $academicYearId) {
                $file = fopen($csvFilePath, 'w');
                
                fputcsv($file, ['Idea ID', 'Title', 'Description', 'Submitted By', 'Department Name', 'Category Name', 'File Path', 'Created At']);
                
               
                $ideas = Idea::whereHas('closureDate', function ($query) use ($academicYearId) {
                    $query->where('ClosureDate_id', $academicYearId);
                })->with(['category', 'documents', 'user.department'])->get();
    
               
                foreach ($ideas as $idea) {
                    $filePaths = $idea->documents->pluck('file_path')->implode(', ');
    
                    fputcsv($file, [
                        $idea->idea_id,
                        $idea->title,
                        $idea->description,
                        optional($idea->user)->name ?? 'Anonymous',
                        optional($idea->user->department)->name ?? 'No Department', 
                        optional($idea->category)->category_name ?? 'No Category',
                        $filePaths ?: 'No Documents', 
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
                
                $documents = Document::whereHas('idea.closureDate', function ($query) {
                    $query->where('Comment_ClosureDate', '<', now());
                })->get();
    
                
                foreach ($documents as $document) {
                    $filePath = storage_path("app/public/" . $document->file_path);
                    if (file_exists($filePath)) {
                        $documentsZip->addFile($filePath, basename($filePath));
                    }
                }
                $documentsZip->close();
            }
    
            
            if (file_exists($documentsZipPath)) {
                $zip->addFile($documentsZipPath, $documentsZipFileName);
            } 
            
            $zip->close();
    
            
            return response()->download($zipPath)->deleteFileAfterSend(true);
        }
    
        
        return response()->json(['error' => 'Could not generate the files'], 500);
    }
    
}

