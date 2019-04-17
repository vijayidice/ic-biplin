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
  
class IncentiveAuditReportBrand implements FromArray, WithHeadings, WithEvents
{
	public function __construct($division, $financial_year, $profile_role, $territory_type, $brand_options, $esv_pcent, $pearn_pcent, $exp_pcent)
    {
        $this->division_name = '';
        $this->division = $division;
        $this->financial_year = $financial_year;
        $this->territory_type = $territory_type;
        $this->profile_role = $profile_role;
        $this->brand_options = $brand_options;
        $this->esv_pcent = $esv_pcent;
        $this->exp_pcent = $exp_pcent;
        $this->pearn_pcent = $pearn_pcent;
        $divisions_array = DB::table("division")->select('name')->where('divisionid', $this->division)->get()->toArray();
        if(!empty($divisions_array))
        {
            $this->division_name = ucwords($divisions_array[0]->name);
        }
    }

	public function headings(): array
    {
        return [ 
            [' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '],
            ['Ipca Laboratories Ltd.- '.$this->division_name.' Division', '', '', '', '', '', '', '', '', '', '', 'Prospective Earner %:', '', ''.$this->pearn_pcent.'%'],
            ['Proposed Incentive Analysis for the year '.$this->financial_year.' PSR', '', '', '', '', '', '', '', '', '', '', 'ESV Weightage Avg:', '', ''.$this->esv_pcent.' %'],
            ['Brand Group: '.$this->brand_options.''],
            ['Sr.No.', 'PMPT no. of units', '', 'No. of PSR', 'Incentive per strip in Rs.', 'Wt.avg. PMPT '.$this->financial_year.'', 'Sales in value for the qtr.', 'Incentive per Qtr.','Incentive to Qtr. Sales %', 'Overall incentive earnings', 'Sales from expected Qualifiers (Qtr.)', 'Sales from non Qualifiers (Qtr.).', 'Expected Qualifiers', 'Non-Qualifiers'],
            ['', '', '', '', '', '', '', '', '', '', '', '', '', ''],
            ['', '', '', '', '', '', '', '', '', '', '', '', '', ''],
            ['', 'From', 'To', '', '', '', 'Rs.', 'Rs.', '', 'Rs.', 'Rs.', 'Rs.', ''.$this->exp_pcent.'%', ''],
        ];
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
                                'size' => 12,
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
                                'size' => 12,
                                'bold' => true,
                                'color' => ['argb' => '0000000'],
                        ],                       
                    ];
                $event->sheet->getStyle('A4:AN1200')->applyFromArray($styleArrayAll);
                $event->sheet->getStyle('A1:A2')->applyFromArray($styleArray1);
                $event->sheet->getStyle('A2:N2')->applyFromArray($styleArray);
                $event->sheet->getStyle('A3:N8')->applyFromArray($styleArray);

               // $event->sheet->getDelegate()->setWidth('L', 500);
                
                //$event->sheet->getStyle('A3:N3')->getAlignment()->setWrapText(true);
                //$event->sheet->getStyle('AB3:AZ3')->getAlignment()->setWrapText(true);

                /*$event->sheet->getStyle('A3:AI4')->getFill()
                          ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('408D83');*/
                    
                //$event->sheet->mergeCells('A1:Z1');
                $event->sheet->mergeCells('A2:K2');
                $event->sheet->mergeCells('A3:K3');
                $event->sheet->mergeCells('L2:M2');
                $event->sheet->mergeCells('L3:M3');
                $event->sheet->mergeCells('A4:D4');
                $event->sheet->mergeCells('A5:A8');
                $event->sheet->mergeCells('B5:C7');
                $event->sheet->mergeCells('D5:D8');
                $event->sheet->mergeCells('E5:E8');
                $event->sheet->mergeCells('F5:F8');
                $event->sheet->mergeCells('G5:G7');
                $event->sheet->mergeCells('H5:H7');
                $event->sheet->mergeCells('I5:I8');
                $event->sheet->mergeCells('J5:J7');
                $event->sheet->mergeCells('K5:K7');
                $event->sheet->mergeCells('L5:L7');
                $event->sheet->mergeCells('M5:M7');
                $event->sheet->mergeCells('N5:N8');
            },
        ];
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
    	$result =  DB::select("SELECT incentive_summaryP.ach_val_fr, incentive_summaryP.ach_val_to, incentive_summaryP.tot_psr, incentive_summaryP.incentive_pcent1, incentive_summaryP.wt_avg, incentive_summaryP.tot_qtr_sale, incentive_summaryP.qtr_incentive_total, incentive_summaryP.tot_incentive_pcent, incentive_summaryP.total_incentive, incentive_summaryP.sales_qualify, incentive_summaryP.sales_nqualify, incentive_summaryP.exp_qualifier, incentive_summaryP.non_qualifier FROM incentive_summaryP WHERE divisionid= ".$this->division." AND profileid= ".$this->profile_role." AND fyear='".$this->financial_year."' AND territory_type='".$this->territory_type."' AND noofbrand_bud='".$this->brand_options."'");
        
        //echo "<pre>"; print_r($result); die;
        if(!empty($result))
        {
            $inc_audit_arr = [];
            $i =1;
            $total_psr = 0;
            $total_sale_value_qtr = 0;
            $total_inc_per_qtr = 0;
            $total_inc_to_qtr_sale = 0;
            $total_sales_from_expected_qalifr = 0;
            $total_from_non_qalifr = 0;
            $total_expected_qalifrs = 0;
            $total_non_qalifrs = 0;
            foreach ($result as $res) {
                $total_psr = $total_psr + $res->tot_psr;
                $total_sale_value_qtr = $total_sale_value_qtr + $res->tot_qtr_sale;
                $total_inc_per_qtr = $total_inc_per_qtr + $res->qtr_incentive_total;
                $total_inc_to_qtr_sale = $total_inc_to_qtr_sale + $res->tot_incentive_pcent;
                $total_sales_from_expected_qalifr = $total_sales_from_expected_qalifr + $res->sales_qualify;
                $total_from_non_qalifr = $total_from_non_qalifr + $res->sales_nqualify;
                $total_expected_qalifrs = $total_expected_qalifrs + $res->exp_qualifier;
                $total_non_qalifrs = $total_non_qalifrs + $res->non_qualifier;

                $inc_audit_arr[] = array(
                                    'sno' => $i,
                                    'ach_val_fr' => $res->ach_val_fr,
                                    'ach_val_to' => $res->ach_val_to,
                                    'tot_psr' => $res->tot_psr,
                                    'incentive_pcent1' => $res->incentive_pcent1,
                                    'wt_avg' => $res->wt_avg,
                                    'tot_qtr_sale' => $res->tot_qtr_sale,
                                    'qtr_incentive_total' => $res->qtr_incentive_total,
                                    'tot_incentive_pcent' => $res->tot_incentive_pcent,
                                    'total_incentive' => $res->total_incentive,
                                    'sales_qualify' => $res->sales_qualify,
                                    'sales_nqualify' => $res->sales_nqualify,
                                    'exp_qualifier' => $res->exp_qualifier,
                                    'non_qualifier' => $res->non_qualifier,
                                );
                $i++;
            }
            $inc_audit_arr[] = array(
                                    'sno' => '',
                                    'ach_val_fr' => '',
                                    'ach_val_to' => '',
                                    'tot_psr' => $total_psr,
                                    'incentive_pcent1' => '',
                                    'wt_avg' => '',
                                    'tot_qtr_sale' => $total_sale_value_qtr,
                                    'qtr_incentive_total' => $total_inc_per_qtr,
                                    'tot_incentive_pcent' => $total_inc_to_qtr_sale,
                                    'total_incentive' => '',
                                    'sales_qualify' => $total_sales_from_expected_qalifr,
                                    'sales_nqualify' => $total_from_non_qalifr,
                                    'exp_qualifier' => $total_expected_qalifrs,
                                    'non_qualifier' => $total_non_qalifrs,
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