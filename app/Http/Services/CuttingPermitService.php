<?php

namespace App\Http\Services;
use App\Models\CuttingPermit;
use App\Models\Tree;
use Illuminate\Support\Facades\Storage;

class CuttingPermitService {
    public function getSelectableData()
    {
        $registeredTrees = Tree::select('id', 'treeId', 'treeType')
            ->where('status', 1)
            ->orderBy('treeId', 'ASC')->get();
        
        return [
            'registeredTrees' => $registeredTrees
        ];
    }

    public function saveCuttingPermit($payload, $request)
    {
        try {
            $data = $payload;
            $data['user_id'] = auth()->id();
            
            // Handle file upload
            if ($request->hasFile('document')) {
                $file = $request->file('document');
                
                // Validate file before processing
                if (!$file->isValid()) {
                    throw new \Exception('Invalid file uploaded.');
                }
                
                // Create directory if it doesn't exist
                $directory = 'cutting-permits/' . date('Y/m');
                
                // Generate unique filename
                $filename = auth()->id() . '_' . time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                
                // Store the file
                $documentPath = $file->storeAs($directory, $filename, 'public');
                
                if (!$documentPath) {
                    throw new \Exception('Failed to store the document.');
                }
                
                // Add file information to data
                $data['document_path'] = $documentPath;
                $data['document_original_name'] = $file->getClientOriginalName();
            } else {
                throw new \Exception('Document file is required.');
            }
            
            // Create the cutting permit record
            $cuttingPermit = CuttingPermit::create($data);
            
            return $cuttingPermit;
            
        } catch (\Exception $e) {
            // Clean up uploaded file if database creation fails
            if (isset($documentPath) && Storage::disk('public')->exists($documentPath)) {
                Storage::disk('public')->delete($documentPath);
            }
            
            throw $e;
        }
    }
}