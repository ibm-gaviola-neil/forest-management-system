<?php

namespace App\Http\Services;

use App\Models\ChainsawRequest;
use App\Models\ChainsawRequirement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ChainsawService {
    public function getChainsawData($role = 'applicant', $request)
    {
        $data = [];

        $query = ChainsawRequest::query();

        $query->when(filled($request->search), function ($q) use ($request, $role) {
            $keyword = $request->search;
            $q->where(function($sub) use ($keyword, $role) {
                $sub->where('serial_number', 'LIKE', "%{$keyword}%")
                    ->orWhere('model', 'LIKE', "%{$keyword}%")
                    ->orWhere('brand', 'LIKE', "%{$keyword}%");

                if ($role === 'general_admin') {
                    $sub->orWhereHas('user', function($userQuery) use ($keyword) {
                        $userQuery->where('last_name', 'LIKE', "%{$keyword}%")
                                ->orWhere('first_name', 'LIKE', "%{$keyword}%");
                    });
                }
            });
        });

        $query->when(filled($request->status), function ($q) use ($request) {
            $status = $request->status;
            if($status !== "NaN") {
                $q->where('status', $status);
            }
        });

        if ($role === 'applicant') {
            $query->where('user_id', auth()->user()->id);
        } 

        if ($role === 'general_admin') {
            $query->with('user');
        }  

        $data = $query->orderBy('serial_number', 'DESC')->paginate(20);

        return $data;
    }

    public function saveChainsaw($payload, $request)
    {
        try {
            DB::beginTransaction();
            
            $data = $payload;
            $data['user_id'] = auth()->id();
            
            // Create the cutting permit record first (without document fields)
            $chainsaw = ChainsawRequest::create($data);
            
            // Handle multiple document uploads
            if ($request->hasFile('documents')) {
                $files = $request->file('documents');
                
                $this->storeRequirements($files, $chainsaw);
            } else {
                throw new \Exception('At least one document file is required.');
            }
            
            DB::commit();
            return $chainsaw;
            
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

    public function editChainsaw($payload, $request, $chainsaw)
    {
        try {
            DB::beginTransaction();
            
            $data = $payload;
            $data['user_id'] = auth()->id();
            
            // Create the cutting permit record first (without document fields)
            $chainsaw->update($payload);
            $requirements = ChainsawRequirement::where('chainsaw_request_id', $chainsaw->id)->exists();
            
            // Handle multiple document uploads
            if ($request->hasFile('documents')) {
                $files = $request->file('documents');
                
                $this->storeRequirements($files, $chainsaw);
            } else {
                if (!$requirements) {
                    throw new \Exception('At least one document file is required.');
                }
            }
            
            DB::commit();
            return $chainsaw;
            
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

    public function storeRequirements($files, ChainsawRequest $chainsaw)
    {
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
            $chainsaw->requirements()->create([
                'file_name' => $filename,
                'original_filename' => $file->getClientOriginalName(),
                'file_path' => $documentPath,
                'file_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
            ]);
        }
    }
}