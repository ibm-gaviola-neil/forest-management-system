<?php

namespace App\Http\Services;

use App\Http\Repositories\CuttingPermitRepository;
use App\Models\CuttingPermit;
use App\Models\Tree;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CuttingPermitService {
    private $cuttingPermitRepository;

    public function __construct(CuttingPermitRepository $cuttingPermitRepository)
    {
        $this->cuttingPermitRepository = $cuttingPermitRepository;
    }

    public function getCuttingPermitData($role = 'applicant', $request)
    {
        return $this->cuttingPermitRepository->getCuttingPermitData($role, $request);
    }

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
            DB::beginTransaction();
            
            $data = $payload;
            $data['user_id'] = auth()->id();
            
            // Create the cutting permit record first (without document fields)
            $cuttingPermit = CuttingPermit::create($data);
            
            // Handle multiple document uploads
            if ($request->hasFile('documents')) {
                $files = $request->file('documents');
                
                foreach ($files as $file) {
                    if (!$file->isValid()) {
                        throw new \Exception('Invalid file uploaded: ' . $file->getClientOriginalName());
                    }
                    
                    $directory = 'cutting-permits/' . date('Y/m');
                    $filename = auth()->id() . '_' . time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                    $documentPath = $file->storeAs($directory, $filename, 'public');
                    
                    if (!$documentPath) {
                        throw new \Exception('Failed to store the document: ' . $file->getClientOriginalName());
                    }
                    
                    // Create entry in cutting_permit_requirements table
                    $cuttingPermit->requirements()->create([
                        'file_name' => $filename,
                        'original_filename' => $file->getClientOriginalName(),
                        'file_path' => $documentPath,
                        'file_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),
                    ]);
                }
            } else {
                throw new \Exception('At least one document file is required.');
            }
            
            DB::commit();
            return $cuttingPermit;
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Clean up any stored files if an error occurs
            if (isset($directory)) {
                $uploadedFiles = Storage::disk('public')->files($directory);
                foreach ($uploadedFiles as $file) {
                    // Only delete files that match our user ID pattern to avoid deleting other users' files
                    if (strpos(basename($file), auth()->id() . '_' . time() . '_') === 0) {
                        Storage::disk('public')->delete($file);
                    }
                }
            }
            
            throw $e;
        }
    }

    public function cancelCuttingPermit(CuttingPermit $cuttingPermit)
    {
        try {
            $isCancel = $cuttingPermit->markAsCancel();

            if (!$isCancel) {
                throw new \Exception('Cutting permit is already cancelled.');
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        return $cuttingPermit;
    }
}