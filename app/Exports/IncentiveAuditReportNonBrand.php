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
  
class IncentiveAuditReportNonBrand implements FromArray, WithHeadings, WithEvents
{
	public function __construct($division, $financial_year, $profile_role, $territory_type, $intima_type)
    {
        $this->division_name = '';
        $this->div_array = ['24', '7', '10', '1', '2', '21', '15', '16', '4'];
        $this->division = $division;
        $this->financial_year = $financial_year;
        $this->territory_type = $territory_type;
        $this->profile_role = $profile_role;
        $this->intima_type = $intima_type;


        $this->brand1_pcent = '';
        $this->brand2_pcent = '';
        $this->brand3_pcent = '';

        $this->brand1_name = '';
        $this->brand2_name = '';
        $this->brand3_name = '';
        $this->pearn_pcent = '';

        //echo $this->division.'#'.$this->financial_year.'#'.$this->territory_type.'#'.$profile_role; 

        $brand_percents = DB::table("incentive_summary")->select('brand1_pcent', 'brand2_pcent', 'brand3_pcent', 'brand1_name', 'brand2_name', 'brand3_name', 'pearn_pcent')->where('divisionid', $this->division)->where('fyear', $this->financial_year)->where('territory_type', $this->territory_type)->where('profileid', $this->profile_role)->get()->toArray();

        //echo "<pre>"; print_r($brand_percents); die;

        if(!empty($brand_percents))
        {
            $brands_per = $brand_percents[0];

            $this->brand1_name = $brands_per->brand1_name;
            $this->brand2_name = $brands_per->brand2_name;
            $this->brand3_name = $brands_per->brand3_name;


            $this->brand1_pcent = '@'.$brands_per->brand1_pcent.'%';
            $this->brand2_pcent = '@'.$brands_per->brand2_pcent.'%';
            $this->brand3_pcent = '@'.$brands_per->brand3_pcent.'%'; 
            $this->pearn_pcent  = '@'.$brands_per->pearn_pcent.'%';
        }

        $divisions_array = DB::table("division")->select('name')->where('divisionid', $this->division)->get()->toArray();
        if(!empty($divisions_array))
        {
            $this->division_name = ucwords($divisions_array[0]->name);
        }
    }

	public function headings(): array
    {
        /*if(in_array($this->division, $this->div_array ))
        {*/
            return [ 
                ['Ipca Laboratories Ltd.- '.$this->division_name.' Division'],
                ['Proposed Incentive Analysis for the year '.$this->financial_year.' PSR'],
                ['For '.ucwords($this->territory_type).' Pools'],
                ['', 'PMPT in Lacs', '', '', '', '', ''.$this->brand1_name.'', '', ''.$this->brand2_name.'', '', ''.$this->brand3_name.'', '' ],
                ['', '','','', '', '', ''.$this->brand1_pcent, '', ''.$this->brand2_pcent, '', ''.$this->brand3_pcent, ''],
                ['Sr.No.', 'From', 'To', 'wt.Average', 'Total PSR', 'Total sales For the Qtr.Rs. in lacs', 'Incentive for the Qtr. Sales Achievement in Rs.', 'Incentive % to Sales - Qtr.', 'Incentive for the Qtr. Sales Achievement in Rs.', 'Incentive % to Sales - Qtr.', 'Incentive for the Qtr. Sales Achievement in Rs.', 'Incentive % to Sales - Qtr.', 'Total Quarterly Incentive for the year in Rs.', 'Annual Incentive in Rs.', 'Total Incentive in Rs.', 'Sales For the Year Rs. in lacs', 'Total Incentive % to Total yrly. Sales', 'Prospective earners in Nos.', 'Ratio between Qtrly incentive and Annual incentive', '', 'Total Quarterly Incentive for the year in Rs.', 'Annual incentive', 'Total incentive Rs. In lacs', 'Sales from Qualifiers', 'Sales From Non Qualifiers', 'Non Qualifiers'],
                ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '' ],
                ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '' ],
                ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', $this->pearn_pcent, 'Qtr.', 'Annual', '', '', '', '', '', '' ],
            ];
        /*}
        else
        {
            return [ 
                ['Ipca Laboratories Ltd.- '.$this->division_name.' Division'],
                ['Proposed Incentive Analysis for the year '.$this->financial_year.' PSR'],
                ['For '.ucwords($this->territory_type).' Pools'],
                ['', 'PMPT in Lacs', '', '', '', '', ''.$this->brand1_name.'', '', ''.$this->brand2_name.'', '', ''.$this->brand3_name.'', '' ],
                ['', '','','', '', '', ''.$this->brand1_pcent, '', ''.$this->brand2_pcent, '', ''.$this->brand3_pcent, ''],
                ['Sr.No.', 'From', 'To', 'wt.Average', 'Total PSR', 'Total sales For the Qtr.Rs. in lacs', 'Incentive for the Qtr. Sales Achievement in Rs.', 'Incentive for the Qtr. Sales Achievement in Rs.','Incentive % to Sales - Qtr.', 'Incentive for the Qtr. Sales Achievement in Rs.', 'Incentive % to Sales - Qtr.', 'Incentive for the Qtr. Sales Achievement in Rs.', 'Incentive % to Sales - Qtr.', 'Total Quarterly Incentive for the year in Rs.', 'Annual Incentive in Rs.', 'Total Incentive in Rs.', 'Sales For the Year Rs. in lacs', 'Total Incentive % to Total yrly. Sales', 'Prospective earners in Nos.', 'Ratio between Qtrly incentive and Annual incentive', '', 'Total Quarterly Incentive for the year in Rs.', 'Annual incentive', 'Total incentive Rs. In lacs', 'Sales from Qualifiers', 'Sales From Non Qualifiers', 'Non Qualifiers'],
                ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '' ],
                ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '' ],
                ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '@67.33%', 'Qtr.', 'Annual', '', '', '', '', '', '' ],
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
                $event->sheet->getStyle('A3:AZ1200')->applyFromArray($styleArrayAll);
                $event->sheet->getStyle('A1:Z1')->applyFromArray($styleArray1);
                $event->sheet->getStyle('A2:Z2')->applyFromArray($styleArray1);
                $event->sheet->getStyle('A3:Z9')->applyFromArray($styleArray);
                $event->sheet->getStyle('A3:Z9')->getAlignment()->setWrapText(true);
                //$event->sheet->getColumnDimension('F')->setAutoSize(true) ;

                /*$column_array = ['F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
                $event->sheet->getColumnDimension($column_array)->setWidth(18);*/
                /*$event->sheet->getColumnDimension('D')->setWidth(14);
                $event->sheet->getColumnDimension('E')->setWidth(12);
                $event->sheet->getColumnDimension('F')->setWidth(18);
                $event->sheet->getColumnDimension('G')->setWidth(18);
                $event->sheet->getColumnDimension('H')->setWidth(18);
                $event->sheet->getColumnDimension('I')->setWidth(18);
                $event->sheet->getColumnDimension('J')->setWidth(18);
                $event->sheet->getColumnDimension('K')->setWidth(18);
                $event->sheet->getColumnDimension('L')->setWidth(18);
                $event->sheet->getColumnDimension('M')->setWidth(18);
                $event->sheet->getColumnDimension('N')->setWidth(18);
                $event->sheet->getColumnDimension('O')->setWidth(18);
                $event->sheet->getColumnDimension('P')->setWidth(18);
                $event->sheet->getColumnDimension('Q')->setWidth(18);
                $event->sheet->getColumnDimension('R')->setWidth(18);
                $event->sheet->getColumnDimension('S')->setWidth(18);
                $event->sheet->getColumnDimension('T')->setWidth(18);
                $event->sheet->getColumnDimension('U')->setWidth(18);
                $event->sheet->getColumnDimension('V')->setWidth(18);
                $event->sheet->getColumnDimension('W')->setWidth(18);
                $event->sheet->getColumnDimension('X')->setWidth(18);
                $event->sheet->getColumnDimension('Y')->setWidth(18);
                $event->sheet->getColumnDimension('Z')->setWidth(18);*/
                //$event->sheet->getStyle('AB3:AZ3')->getAlignment()->setWrapText(true);

                /*$event->sheet->getStyle('A3:AI4')->getFill()
                          ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('408D83');*/
                    
                $event->sheet->mergeCells('A1:Z1');
                $event->sheet->mergeCells('A2:Z2');
                $event->sheet->mergeCells('A3:D3');
                $event->sheet->mergeCells('B4:D5');
                $event->sheet->mergeCells('E3:F3');
                $event->sheet->mergeCells('E4:F4');
                $event->sheet->mergeCells('G5:H5');
                $event->sheet->mergeCells('G4:H4');
                $event->sheet->mergeCells('I5:J5');
                $event->sheet->mergeCells('I4:J4');
                $event->sheet->mergeCells('K5:L5');
                $event->sheet->mergeCells('K4:L4');
                $event->sheet->mergeCells('A6:A9');
                $event->sheet->mergeCells('B6:B9');
                $event->sheet->mergeCells('C6:C9');
                $event->sheet->mergeCells('D6:D9');
                $event->sheet->mergeCells('E6:E9');
                $event->sheet->mergeCells('F6:F9');
                $event->sheet->mergeCells('G6:G9');
                $event->sheet->mergeCells('H6:H9');
                $event->sheet->mergeCells('I6:I9');
                $event->sheet->mergeCells('J6:J9');
                $event->sheet->mergeCells('K6:K9');
                $event->sheet->mergeCells('L6:L9');
                $event->sheet->mergeCells('M6:M9');
                $event->sheet->mergeCells('N6:N9');
                $event->sheet->mergeCells('O6:O9');
                $event->sheet->mergeCells('P6:P9');
                $event->sheet->mergeCells('Q6:Q9');
                $event->sheet->mergeCells('R6:R8');
                $event->sheet->mergeCells('S6:T8');
                $event->sheet->mergeCells('U6:U9');
                $event->sheet->mergeCells('V6:V9');
                $event->sheet->mergeCells('W6:W9');
                $event->sheet->mergeCells('X6:X9');
                $event->sheet->mergeCells('Y6:Y9');
                $event->sheet->mergeCells('Z6:Z9');
            },
        ];
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
    	if($this->division == '14' && $this->intima_type != '')
    	{
    		$result =  DB::select("SELECT incentive_summary.group_code,incentive_summary.ach_val_fr,incentive_summary.ach_val_to,incentive_summary.wt_avg,incentive_summary.tot_psr,incentive_summary.tot_qtr_sale, incentive_summary.qtr_incentive1,incentive_summary.incentive_pcent1,incentive_summary.qtr_incentive2,incentive_summary.incentive_pcent2, incentive_summary.qtr_incentive3,incentive_summary.incentive_pcent3,incentive_summary.qtr_incentive_total,incentive_summary.annual_incentive, incentive_summary.total_incentive,incentive_summary.yearly_sale,incentive_summary.tot_incentive_pcent,incentive_summary.prospective_earn,incentive_summary.ratio_qtr, incentive_summary.ratio_yrl,incentive_summary.qtr_incentive_total1,incentive_summary.annual_incentive1,incentive_summary.total_incentive1,incentive_summary.sales_qualify, incentive_summary.sales_nqualify,incentive_summary.non_qualifier FROM incentive_summary where incentive_summary.divisionid= ".$this->division." AND incentive_summary.fyear='".$this->financial_year."' AND incentive_summary.profileid= ".$this->profile_role."  AND incentive_summary.territory_type='".$this->territory_type."' AND group_code=".$this->intima_type."");
    	}
    	else
    	{
        	$result =  DB::select("SELECT incentive_summary.group_code,incentive_summary.ach_val_fr,incentive_summary.ach_val_to,incentive_summary.wt_avg,incentive_summary.tot_psr,incentive_summary.tot_qtr_sale, incentive_summary.qtr_incentive1,incentive_summary.incentive_pcent1,incentive_summary.qtr_incentive2,incentive_summary.incentive_pcent2, incentive_summary.qtr_incentive3,incentive_summary.incentive_pcent3,incentive_summary.qtr_incentive_total,incentive_summary.annual_incentive, incentive_summary.total_incentive,incentive_summary.yearly_sale,incentive_summary.tot_incentive_pcent,incentive_summary.prospective_earn,incentive_summary.ratio_qtr, incentive_summary.ratio_yrl,incentive_summary.qtr_incentive_total1,incentive_summary.annual_incentive1,incentive_summary.total_incentive1,incentive_summary.sales_qualify, incentive_summary.sales_nqualify,incentive_summary.non_qualifier FROM incentive_summary where incentive_summary.divisionid= ".$this->division." AND incentive_summary.fyear='".$this->financial_year."' AND incentive_summary.profileid= ".$this->profile_role."  AND incentive_summary.territory_type='".$this->territory_type."' AND group_code!=5");
    	}
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