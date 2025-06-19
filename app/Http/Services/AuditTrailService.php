<?php

namespace App\Http\Services;

use App\Http\Repositories\AuditTrailRepository;

class AuditTrailService{
    protected $auditTrailRepository;

    public function __construct(AuditTrailRepository $auditTrailRepository){
        $this->auditTrailRepository = $auditTrailRepository;
    }

    public function setAuditTrail($request){
        return [
            'request' => $request,
            'activities' => $this->auditTrailRepository->getAuditrailData($request),
        ];
    }
}