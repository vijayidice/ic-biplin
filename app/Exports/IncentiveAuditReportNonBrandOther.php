<?php
  
namespace App\Exports;
  
use App\User;
//use Maatwebsite\Excel\Concerns\FromCollection;
//use Maatwebsite\Excel\Concerns\FromQuery;
//use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
//use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use DB;
  
class IncentiveAuditReportNonBrandOther implements FromArray, WithHeadings, WithEvents
{
	public function __construct($division, $financial_year, $profile_role, $territory_type)
    {
        $this->division_name = '';
        $this->div_array = ['24', '7', '10', '1', '2', '21', '15', '16', '4'];
        $this->division = $division;
        $this->financial_year = $financial_year;
        $this->territory_type = $territory_type;
        $this->profile_role = $profile_role;
        $divisions_array = DB::table("division")->select('name')->where('divisionid', $this->division)->get()->toArray();
        if(!empty($divisions_array))
        {
            $this->division_name = ucwords($divisions_array[0]->name);
        }
    }

	public function headings(): array
    {
        return [ 
                ['Ipca Laboratories Ltd.- '.$this->division_name.' Division'],
                ['Proposed Incentive Analysis for the year '.$this->financial_year.' PSR'],
                ['HQ BELOW 1.5 LAC PMPT', '', '', ''],
                ['Sr.No.', 'Territories', 'wt.Average', 'Total PSR', 'Total sales For the Qtr.Rs. in lacs', 'Incentive for the Qtr. Sales Achievement in Rs.', 'Incentive % to Sales - Qtr.','Total Quarterly Incentive for the year in Rs.', 'Annual Incentive in Rs.', 'Total Incentive in Rs.', 'Sales For the Year Rs. in lacs', 'Total Incentive % to Total yrly. Sales', 'Prospective earners in Nos.', 'Ratio between Qtrly incentive and Annual incentive', '', 'Total Quarterly Incentive for the year in Rs.', 'Annual incentive', 'Total incentive In Rs. Lacs', 'Sales from Qualifiers', 'Sales From Non Qualifiers', 'Non Qualifiers'],
                ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''],
                ['', '', '', '', '', '', '', '', '', '', '', '', '@60%', 'Qtr.', 'Annual', '', '', '', '', '', ''],
            ];
        /*if(in_array($this->division, $this->div_array ))
        {
            return [ 
                ['Ipca Laboratories Ltd.- '.$this->division_name.' Division'],
                ['Proposed Incentive Analysis for the year '.$this->financial_year.' PSR'],
                ['HQ BELOW 1.5 LAC PMPT', '', '', ''],
                ['Sr.No.', 'Territories', 'wt.Average', 'Total PSR', 'Total sales For the Qtr.Rs. in lacs', 'Incentive for the Qtr. Sales Achievement in Rs.', 'Incentive % to Sales - Qtr.','Total Quarterly Incentive for the year in Rs.', 'Annual Incentive in Rs.', 'Total Incentive in Rs.', 'Sales For the Year Rs. in lacs', 'Total Incentive % to Total yrly. Sales', 'Prospective earners in Nos.', 'Ratio between Qtrly incentive and Annual incentive', 'Total Quarterly Incentive for the year in Rs.', 'Annual incentive', 'Total incentive In Rs. Lacs', 'Sales from Qualifiers', 'Sales From Non Qualifiers', 'Non Qualifiers'],
                ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''],
                ['', '', '', '', '', '', '', '', '', '', '', '', '@60%', 'Qtr.', 'Annual', '', '', '', '', '', ''],
            ];
        }
        else
        {
            return [ 
                ['Ipca Laboratories Ltd.- '.$this->division_name.' Division'],
                ['Proposed Incentive Analysis for the year '.$this->financial_year.' PSR'],
                ['HQ BELOW 1.5 LAC PMPT', '', '', ''],
                ['Sr.No.', 'Territories', 'wt.Average', 'Total PSR', 'Total sales For the Qtr.Rs. in lacs', 'Incentive for the Qtr. Sales Achievement in Rs.', 'Incentive % to Sales - Qtr.','Total Quarterly Incentive for the year in Rs.', 'Annual Incentive in Rs.', 'Total Incentive in Rs.', 'Sales For the Year Rs. in lacs', 'Total Incentive % to Total yrly. Sales', 'Prospective earners in Nos.', 'Ratio between Qtrly incentive and Annual incentive', 'Total Quarterly Incentive for the year in Rs.', 'Annual incentive', 'Total incentive In Rs. Lacs', 'Sales from Qualifiers', 'Sales From Non Qualifiers', 'Non Qualifiers'],
                ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''],
                ['', '', '', '', '', '', '', '', '', '', '', '', '@60%', 'Qtr.', 'Annual', '', '', '', '', '', ''],
            ];
        }*/
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {

        return [

            AfterSheet::class    => function(AfterSheet $event) {
                $styleArray = [
                        'alignment' => [
                               'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ],                        
                       'font' => [
                                'name' => 'Calibri',
                                'size' => 11,
                                'bold' => true,
                                'color' => ['argb' => '0000000'],
                        ],
                    ];
                $styleArrayAll = [
                        'alignment' => [
                               'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ]
                    ];
                $styleArray1 = [
                        'font' => [
                                'name' => 'Calibri',
                                'size' => 13,
                                'bold' => true,
                                'color' => ['argb' => '0000000'],
                        ],
                        'alignment' => [
                               'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ]                      
                    ];
                $event->sheet->getStyle('A3:AU1200')->applyFromArray($styleArrayAll);
                $event->sheet->getStyle('A1:U1')->applyFromArray($styleArray1);
                $event->sheet->getStyle('A2:U2')->applyFromArray($styleArray1);
                $event->sheet->getStyle('A3:U9')->applyFromArray($styleArray);
                $event->sheet->getStyle('A3:U9')->getAlignment()->setWrapText(true);
                //$event->sheet->getStyle('AB3:AZ3')->getAlignment()->setWrapText(true);

                /*$event->sheet->getStyle('A3:AI4')->getFill()
                          ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('408D83');*/
                    
                $event->sheet->mergeCells('A1:U1');
                $event->sheet->mergeCells('A2:U2');
                $event->sheet->mergeCells('A3:D3');
                $event->sheet->mergeCells('A4:A6');
                $event->sheet->mergeCells('B4:B6');
                $event->sheet->mergeCells('C4:C6');
                $event->sheet->mergeCells('D4:D6');
                $event->sheet->mergeCells('E4:E6');
                $event->sheet->mergeCells('F4:F6');
                $event->sheet->mergeCells('G4:G6');
                $event->sheet->mergeCells('H4:H6');
                $event->sheet->mergeCells('I4:I6');
                $event->sheet->mergeCells('J4:J6');
                $event->sheet->mergeCells('K4:K6');
                $event->sheet->mergeCells('L4:L6');
                $event->sheet->mergeCells('M4:M5');
                $event->sheet->mergeCells('N4:O5');
                $event->sheet->mergeCells('P4:P6');
                $event->sheet->mergeCells('Q4:Q6');
                $event->sheet->mergeCells('R4:R6');
                $event->sheet->mergeCells('S4:S6');
                $event->sheet->mergeCells('T4:T6');
                $event->sheet->mergeCells('U4:U6');
            },
        ];
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        $result =  DB::select("SELECT incentive_summary.ach_val_fr,incentive_summary.ach_val_to,incentive_summary.wt_avg,incentive_summary.tot_psr,incentive_summary.tot_qtr_sale, incentive_summary.qtr_incentive1,incentive_summary.incentive_pcent1,incentive_summary.qtr_incentive2,incentive_summary.incentive_pcent2, incentive_summary.qtr_incentive3,incentive_summary.incentive_pcent3,incentive_summary.qtr_incentive_total,incentive_summary.annual_incentive, incentive_summary.total_incentive,incentive_summary.yearly_sale,incentive_summary.tot_incentive_pcent,incentive_summary.prospective_earn,incentive_summary.ratio_qtr, incentive_summary.ratio_yrl,incentive_summary.qtr_incentive_total1,incentive_summary.annual_incentive1,incentive_summary.total_incentive1,incentive_summary.sales_qualify, incentive_summary.sales_nqualify,incentive_summary.non_qualifier FROM incentive_summary where incentive_summary.divisionid= ".$this->division." AND incentive_summary.fyear='".$this->financial_year."' AND incentive_summary.profileid= ".$this->profile_role." and incentive_summary.territory_type = '".$this->territory_type."'");
        //echo "<pre>"; print_r($result); die;
        if(!empty($result))
        {
            $inc_audit_arr = [];
            $i =1;
            $total_psr = 0;
            $total_prospective_earner = 0;
            $total_quarterly_incentive_year = 0;
            $total_annual_incentive1 = 0;
            $total_incentive = 0;
            $total_sale_from_quqlir = 0;
            $total_from_non_qualifier = 0;
            $total_non_qualifiers = 0; 
            foreach ($result as $res) 
            {
                $total_psr = $total_psr + $res->tot_psr;
                $total_prospective_earner = $total_prospective_earner + $res->prospective_earn;
                $total_quarterly_incentive_year = $total_quarterly_incentive_year + $res->qtr_incentive_total1;
                $total_annual_incentive1 = $total_annual_incentive1 + $res->annual_incentive1;
                $total_incentive = $total_incentive + $res->total_incentive1;
                $total_sale_from_quqlir = $total_sale_from_quqlir + $res->sales_qualify;
                $total_from_non_qualifier = $total_from_non_qualifier + $res->sales_nqualify;
                $total_non_qualifiers = $total_non_qualifiers + $res->non_qualifier;
                $inc_audit_arr[] = array(
                                    'sno' => $i,
                                    'ach_val_fr' => $res->ach_val_fr,
                                    'ach_val_to' => $res->ach_val_to,
                                    'wt_avg' => $res->wt_avg,
                                    'tot_psr' => $res->tot_psr,
                                    'tot_qtr_sale' => $res->tot_qtr_sale,
                                    'qtr_incentive1' => $res->qtr_incentive1,
                                    'incentive_pcent1' => $res->incentive_pcent1,
                                    'qtr_incentive2' => $res->qtr_incentive2,
                                    'incentive_pcent2' => $res->incentive_pcent2,
                                    'qtr_incentive3' => $res->qtr_incentive3,
                                    'incentive_pcent3' => $res->incentive_pcent3,
                                    'qtr_incentive_total' => $res->qtr_incentive_total,
                                    'annual_incentive' => $res->annual_incentive,
                                    'total_incentive' => $res->total_incentive,
                                    'yearly_sale' => $res->yearly_sale,
                                    'tot_incentive_pcent' => $res->tot_incentive_pcent,
                                    'prospective_earn' => $res->prospective_earn,
                                    'ratio_qtr' => $res->ratio_qtr,
                                    'ratio_yrl' => $res->ratio_yrl,
                                    'qtr_incentive_total1' => $res->qtr_incentive_total1,
                                    'annual_incentive1' => $res->annual_incentive1,
                                    'total_incentive1' => $res->total_incentive1,
                                    'sales_qualify' => $res->sales_qualify,
                                    'sales_nqualify' => $res->sales_nqualify,
                                    'non_qualifier' => $res->non_qualifier,
                                );
                $i++;
            }
            $inc_audit_arr[] = array(
                                    'sno' => '',
                                    'ach_val_fr' => '',
                                    'ach_val_to' => '',
                                    'wt_avg' => '',
                                    'tot_psr' => $total_psr,
                                    'tot_qtr_sale' => '',
                                    'qtr_incentive1' => '',
                                    'incentive_pcent1' => '',
                                    'qtr_incentive2' => '',
                                    'incentive_pcent2' => '',
                                    'qtr_incentive3' => '',
                                    'incentive_pcent3' => '',
                                    'qtr_incentive_total' => '',
                                    'annual_incentive' => '',
                                    'total_incentive' => '',
                                    'yearly_sale' => '',
                                    'tot_incentive_pcent' => '',
                                    'prospective_earn' => $total_prospective_earner,
                                    'ratio_qtr' => '',
                                    'ratio_yrl' => '',
                                    'qtr_incentive_total1' => $total_quarterly_incentive_year,
                                    'annual_incentive1' => $total_annual_incentive1,
                                    'total_incentive1' => $total_incentive,
                                    'sales_qualify' => $total_sale_from_quqlir,
                                    'sales_nqualify' => $total_from_non_qualifier,
                                    'non_qualifier' => $total_non_qualifiers,
                                );
            return $inc_audit_arr;
        }
        else
        {
            return $result;
        }
    }
}


?>