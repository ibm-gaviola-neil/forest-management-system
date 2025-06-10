<?php

namespace App\Exports;

use App\Http\Domains\BloodTypeDomain;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportExport implements FromCollection, WithHeadings
{
    protected $reports;
    protected $tab;

    public function __construct($reports, $tab){
        $this->reports = $reports;
        $this->tab = $tab;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->reports;
    }

    public function headings(): array {
        return $this->getHeader()[$this->tab ?? 'issuance'];
    }

    public function getHeader(){
        return [
            'issuance' => BloodTypeDomain::EXPORT_HEADING_ISSUANCE,
            'donor' => BloodTypeDomain::EXPORT_HEADING_DONOR
        ];
    }
}
