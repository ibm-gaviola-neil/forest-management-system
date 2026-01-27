<?php

namespace App\Http\Services;

use App\Models\Incident;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class IncidentService
{
    public function saveIncident($payload, $request)
    {
        try {
            DB::beginTransaction();

            $data = $payload;
            $data['user_id'] = auth()->id();

            // Create the cutting permit record first (without document fields)
            $incident = Incident::create($data);

            // Handle multiple document uploads
            if ($request->hasFile('attachments')) {
                $files = $request->file('attachments');

                $this->storeAttachments($files, $incident);
            } else {
                throw new \Exception('At least one document file is required.');
            }

            DB::commit();
            return $incident;
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

    public function editIncident($payload, $request, $incident)
    {
        try {
            DB::beginTransaction();

            $data = $payload;
            $data['user_id'] = auth()->id();
            $data['is_anonymous'] =  $request->is_anonymous ?? 0;

            // Create the cutting permit record first (without document fields)
            $incident->update($data);
            $attachments = $incident->attachments()->exists();

            // Handle multiple document uploads
            if ($request->hasFile('attachments')) {
                $files = $request->file('attachments');

                $this->storeAttachments($files, $incident);
            } else {
                if (!$attachments) {
                    throw new \Exception('At least one document file is required.');
                }
            }

            DB::commit();
            return $incident;
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

    public function storeAttachments(array $files, Incident $incident): void
    {
        foreach ($files as $file) {
            if (!($file instanceof UploadedFile) || !$file->isValid()) {
                throw new \Exception('Invalid file uploaded: ' . ($file?->getClientOriginalName() ?? 'unknown'));
            }

            $directory = 'incidents/' . date('Y/m');

            $originalName = $file->getClientOriginalName();
            $extension    = strtolower($file->getClientOriginalExtension() ?: $file->guessExtension() ?: '');
            $mimeType     = $file->getMimeType() ?? 'application/octet-stream';

            $isImage = Str::startsWith($mimeType, 'image/');
            $isVideo = Str::startsWith($mimeType, 'video/');

            $filename = sprintf(
                '%s_%s_%s.%s',
                auth()->id() ?? 'guest',
                now()->format('YmdHisv'),
                Str::slug(pathinfo($originalName, PATHINFO_FILENAME)),
                $extension
            );

            $filePath = $file->storeAs($directory, $filename, 'public');

            if (!$filePath) {
                throw new \Exception('Failed to store the document: ' . $originalName);
            }

            // Use the correct relation for IncidentAttachment, e.g. attachments()
            $incident->attachments()->create([
                'file_path'      => $filePath,
                'file_name'      => $filename,
                'file_type'      => $mimeType,
                'file_size'      => (string) $file->getSize(),   // your column is string
                'file_extension' => $extension,
                'is_image'       => $isImage,
                'is_video'       => $isVideo,
            ]);
        }

        // Optional: keep Incident flags in sync
        $incident->update([
            'has_photos' => $incident->attachments()->where('is_image', true)->exists(),
            'has_videos' => $incident->attachments()->where('is_video', true)->exists(),
        ]);
    }

    public function getIncidentData($role, $request)
    {
        $data = [];

        $query = Incident::query();

        $query->when(filled($request->search), function ($q) use ($request, $role) {
            $keyword = $request->search;
            $q->where(function($sub) use ($keyword, $role) {
                $sub->where('id', 'LIKE', "%{$keyword}%")
                    ->orWhere('report_name', 'LIKE', "%{$keyword}%")
                    ->orWhere('location', 'LIKE', "%{$keyword}%");  
            });
        });

        $query->when(filled($request->status), function ($q) use ($request) {
            $status = $request->status;
            $q->where('status', $status);
        });

        $query->when(filled($request->start_date) && filled($request->end_date), function ($q) use ($request) {
            $q->whereBetween('incident_date', [$request->start_date, $request->end_date]);
        });

        $query->when(filled($request->type), function ($q) use ($request) {
            $status = $request->type;
            $q->where('incident_type', $status);
        });

        $data = $query->orderBy('created_at', 'DESC')
            ->paginate(20);

        return $data;
    }
}
