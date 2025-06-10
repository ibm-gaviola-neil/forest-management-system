<?php

namespace App\Http\Services;

use App\Exports\ReportExport;
use App\Http\Domains\BloodTypeDomain;
use App\Http\Domains\TraitAdmin;
use App\Http\Repositories\InventoryRepository;
use App\Http\Repositories\ReportRepository;
use App\Models\Province;
use Date;
use Maatwebsite\Excel\Facades\Excel;

class ReportService{
    use TraitAdmin;

    protected $inventoryService;
    protected $inventoryRepository;
    protected $reportRepository;

    public function __construct(InventoryService $inventoryService, ReportRepository $reportRepository, InventoryRepository $inventoryRepository) {
        $this->inventoryService = $inventoryService;
        $this->reportRepository = $reportRepository;
        $this->inventoryRepository = $inventoryRepository;
    }

    public function getReportData($request){     
        return [
            'provinces' => Province::orderBy('provDesc', 'ASC')->get(),
            'reportData' => isset($request->tab) ? $this->setReportData($request)[$request->tab] : $this->setReportData($request)['issuance'],
            'address' => $this->getDonorRequestAddress($request),
            'blood_types' => $this->inventoryService->getBloodTypeCount($request, $this->getDonorRequestAddress($request)),
            'donors' => [],
            'request' => $request,
            'months' => BloodTypeDomain::MONTHS,
            'years' => array_combine(
                range(date('Y'), 2000),
                range(date('Y'), 2000)
            )
            
        ];
    }

    public function setReportData($request){
        return [
            'issuance' => $this->reportRepository->getBloodIssuanceReportData($request),
            'donor' => $this->inventoryRepository->getData($request, $this->getDonorRequestAddress($request)),
        ];
    }

    public function exportReport($request)
    {
        $reportData = $this->setReportData($request);
        $tab = $request->tab ?? 'issuance'; // default to 'issuance' if tab is not set
        $date = Date::now();
        $fileName = $tab . '-report-' . $date->format('Y-m-d') . '.xlsx';

        return Excel::download(new ReportExport($reportData[$tab] ?? [], $tab), $fileName);
    }
}