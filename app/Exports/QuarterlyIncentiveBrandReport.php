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
  
class QuarterlyIncentiveBrandReport implements FromArray,  WithHeadings, WithEvents
{
	public function __construct($division, $incentive_type, $financial_year, $brand)
    {
        $this->division_name = '';
        $this->division = $division;
        $this->incentive_type = $incentive_type;
        $this->financial_year = $financial_year;
        $this->brand = ucwords($brand);
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
            ['First Quarter Brand Incentive Calculation'],
            ['Ind', 'Code', 'Name', 'Category', 'SS', 'PSRs SS', '%Gr Required', 'Qualifier','Slab Amount', 'Amount', 'Total PSRs Earning', '1st Quarter '.$this->brand.' ', '', '', '', '', '', '', '', '', '', '', '', '2nd Quarter '.$this->brand.' ', '', '', '', '', '', '', '', '', '', '', '', '1st Half '.$this->brand.' ', '', '', '', '', '', '', '', '', '', '', '', 'Total Rupee Value', '', '', '', '', '', '', '', '', '', '', '', ''],
            ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', 'Net Unit 1', 'Net Last Unit 1', 'Target Unit 1', 'Net Val 1', 'Net Last Val 1', 'Target Val 1', 'Unit Ach 1', 'Unit Growth 1', 'Unit PMPT 1', 'Val Ach 1', 'Val Growth 1', 'Val PMPT 1', 'Net Unit 3', 'Net Last Unit 3', 'Target Unit 3', 'Net Val 3', 'Net Last Val 3', 'Target Val 3', 'Unit Ach 3', 'Unit Growth 3', 'Unit PMPT 3', 'Val Ach 3', 'Val Growth 3', 'Val PMPT 3', 'Net Unit 4', 'Net Last Unit 4', 'Target Unit 4', 'Net Val 4', 'Net Last Val 4', 'Target Val 4', 'Unit Ach 4', 'Unit Growth 4', 'Unit PMPT 4', 'Val Ach 4', 'Val Growth 4', 'Val PMPT 4', 'Net Unit 5', 'Net Last Unit 5', 'Target Unit 5', 'Net Val 5', 'Net Last Val 5', 'Target Val 5', 'Unit Ach 5','Unit Growth 5','Unit PMPT 5','Val Ach 5','Val Growth 5','Val PMPT 5'],
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
                                'size' => 11,
                                'bold' => true,
                                'color' => ['argb' => '0000000'],
                        ],                       
                    ];
                $event->sheet->getStyle('A3:AZ1200')->applyFromArray($styleArrayAll);
                $event->sheet->getStyle('A1:A2')->applyFromArray($styleArray1);
                $event->sheet->getStyle('A3:AJ4')->applyFromArray($styleArray);
                $event->sheet->getStyle('A3:AJ4')->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('AB3:AZ3')->getAlignment()->setWrapText(true);

                $event->sheet->getStyle('A3:BG4')->getFill()
                          ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('408D83');
                    
                $event->sheet->mergeCells('A3:A4');
                $event->sheet->mergeCells('B3:B4');
                $event->sheet->mergeCells('C3:C4');
                $event->sheet->mergeCells('D3:D4');
                $event->sheet->mergeCells('E3:E4');
                $event->sheet->mergeCells('F3:F4');
                $event->sheet->mergeCells('G3:G4');
                $event->sheet->mergeCells('H3:H4');
                $event->sheet->mergeCells('I3:I4');
                $event->sheet->mergeCells('J3:J4');
                $event->sheet->mergeCells('K3:K4');
                $event->sheet->mergeCells('L3:W3');
                $event->sheet->mergeCells('X3:AI3');
                $event->sheet->mergeCells('AJ3:AU3');
                $event->sheet->mergeCells('AV3:BG3');
            },
        ];
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        $result = DB::select("SELECT DISTINCT
                        incentive_data_br1.territory_code AS tc,
                        incentive_data_br1.area_code AS ac,
                        incentive_data_br1.region_code AS rc,
                        incentive_data_br1.zone_code AS zc,
                        incentive_data_br1.profileid AS pf,
                        incentive_data_br1.hierarchy AS hr,
                        incentive_data_br1.territory_name AS tn,
                        incentive_data_br1.territory_type AS cg,
                        incentive_data_br1.pool_strength AS ps,
                        incentive_data_br1.s_strength AS ss,
                        incentive_data_br1.gw_req AS gr,
                        CASE
                    WHEN incentive_data_br1.eligible = 5 THEN
                        'Yes'
                    ELSE
                        'No'
                    END AS eg,
                     incentive_data_br1.app_pcent AS slab_amount,

                    IF (
                        incentive_data_br1.eligible = 5,
                        incentive_data_br1.app_amount,
                        0
                    ) AS amount,
                     incentive_data_br1.a_qty_tot AS netunit1,
                     incentive_data_br1.p_a_qty_tot AS netlastunit1,
                     incentive_data_br1.b_qty_tot AS targetunit1,
                     incentive_data_br1.a_val_tot AS netval1,
                     incentive_data_br1.p_a_val_tot AS netlastval1,
                     incentive_data_br1.b_val_tot AS targetval1,
                     incentive_data_br1.a_qty_pcent AS unitach1,
                     incentive_data_br1.b_qty_growth AS unitgrowth1,
                     incentive_data_br1.unit_pmpt AS unitpmpt1,
                     incentive_data_br1.a_pcent AS valach1,
                     incentive_data_br1.b_qtr_growth AS valgrowth1,
                     incentive_data_br1.val_pmpt AS valpmpt1,
                     incentive_data_br1.next_month_a_qty AS netunit3,
                     incentive_data_br1.next_month_p_a_qty_tot AS netlastunit3,
                     incentive_data_br1.next_month_b_qty AS targetunit3,
                     incentive_data_br1.next_month_a_val AS netval3,
                     incentive_data_br1.next_month_p_a_val_tot AS netlastval3,
                     incentive_data_br1.next_month_b_val AS targetval3,
                     incentive_data_br1.next_month_a_qty_pcent AS unitach3,
                     incentive_data_br1.next_month_qty_growth AS unitgrowth3,
                     incentive_data_br1.next_month_unit_pmpt AS unitpmpt3,
                     incentive_data_br1.next_month_val_pcent AS valach3,
                     incentive_data_br1.next_month_val_growth AS valgrowth3,
                     incentive_data_br1.next_month_val_pmpt AS valpmpt3,
                     incentive_data_br1.fh_a_qty AS netunit4,
                     incentive_data_br1.fh_p_a_qty_tot AS netlastunit4,
                     incentive_data_br1.fh_b_qty AS targetunit4,
                     incentive_data_br1.fh_a_val AS netval4,
                     incentive_data_br1.fh_p_a_val_tot AS netlastval4,
                     incentive_data_br1.fh_b_val AS targetval4,
                     incentive_data_br1.fh_a_qty_pcent AS unitach4,
                     incentive_data_br1.fh_qty_growth AS unitgrowth4,
                     incentive_data_br1.fh_unit_pmpt AS unitpmpt4,
                     incentive_data_br1.fh_val_pcent AS valach4,
                     incentive_data_br1.fh_val_growth AS valgrowth4,
                     incentive_data_br1.fh_val_pmpt AS valpmpt4,
                     incentive_data_br1.tot_a_qty AS netunit5,
                     incentive_data_br1.tot_p_a_qty AS netlastunit5,
                     incentive_data_br1.tot_qty AS targetunit5,
                     incentive_data_br1.tot_a_val AS netval5,
                     incentive_data_br1.tot_p_a_val AS netlastval5,
                     incentive_data_br1.tot_b_val AS targetval5,
                     incentive_data_br1.tot_a_qty_pcent AS unitach5,
                     incentive_data_br1.tot_qty_growth AS unitgrowth5,
                     incentive_data_br1.tot_unit_pmpt AS unitpmpt5,
                     incentive_data_br1.tot_val_pcent AS valach5,
                     incentive_data_br1.tot_val_growth AS valgrowth5,
                     incentive_data_br1.tot_val_pmpt AS valpmpt5
                    FROM
                        incentive_data_br1
                    WHERE
                        incentive_data_br1.incentive_group = '".$this->brand."'
                    AND incentive_data_br1.profileid in(5,6,7,8)
                    AND incentive_data_br1.quarterid = 1
                    AND incentive_data_br1.divisionid = ".$this->division."
                    ORDER BY
                        zc,
                        rc,
                        hr,
                        ac,
                        pf");
        //echo "<pre>"; print_r($result); die;
        $qb_result = [];
        $ind = '';
        if(!empty($result))
        {
            foreach($result as $res)
            {   
                if($res->pf === 8)
                {
                    $ind = 'Zone';
                    $code = $res->zc;
                }
                else if($res->pf === 7)
                {
                    $ind = 'Region';
                    $code = $res->rc;
                }
                else if($res->pf === 6)
                {
                    $ind = 'Area';
                    $code = $res->ac;
                }
                else if($res->pf === 5)
                {
                    $ind = 'Territory';
                    $code = $res->tc;
                }
                else
                {
                    $ind = '';
                    $code = '';
                }
                $qb_result[] = array(
                                        'ind' => $ind,
                                        'tc' => $code,
                                        'tn' => $res->tn,
                                        'cg' => $res->cg,
                                        'ss' => $res->ss,
                                        'ps' => $res->ps,
                                        'gr' => $res->gr,
                                        'eg' => $res->eg,
                                        'slab_amount' => $res->slab_amount,
                                        'amount' => $res->amount,
                                        'total_psr_earning' => $res->amount,
                                        'netunit1' => $res->netunit1,
                                        'netlastunit1' => $res->netlastunit1,
                                        'targetunit1' => $res->targetunit1,
                                        'netval1' => $res->netval1,
                                        'netlastval1' => $res->netlastval1,
                                        'targetval1' => $res->targetval1,
                                        'unitach1' => $res->unitach1,
                                        'unitgrowth1' => $res->unitgrowth1,
                                        'unitpmpt1' => $res->unitpmpt1,
                                        'valach1' => $res->valach1,
                                        'valgrowth1' => $res->valgrowth1,
                                        'valpmpt1' => $res->valpmpt1,
                                        'netunit3' => $res->netunit3,
                                        'netlastunit3' => $res->netlastunit3,
                                        'targetunit3' => $res->targetunit3,
                                        'netval3' => $res->netval3,
                                        'netlastval3' => $res->netlastval3,
                                        'targetval3' => $res->targetval3,
                                        'unitach3' => $res->unitach3,
                                        'unitgrowth3' => $res->unitgrowth3,
                                        'unitpmpt3' => $res->unitpmpt3,
                                        'valach3' => $res->valach3,
                                        'valgrowth3' => $res->valgrowth3,
                                        'valpmpt3' => $res->valpmpt3,
                                        'netunit4' => $res->netunit4,
                                        'netlastunit4' => $res->netlastunit4,
                                        'targetunit4' => $res->targetunit4,
                                        'netval4' => $res->netval4,
                                        'netlastval4' => $res->netlastval4,
                                        'targetval4' => $res->targetval4,
                                        'unitach4' => $res->unitach4,
                                        'unitgrowth4' => $res->unitgrowth4,
                                        'unitpmpt4' => $res->unitpmpt4,
                                        'valach4' => $res->valach4,
                                        'valgrowth4' => $res->valgrowth4,
                                        'valpmpt4' => $res->valpmpt4,
                                        'netunit5' => $res->netunit5,
                                        'netlastunit5' => $res->netlastunit5,
                                        'targetunit5' => $res->targetunit5,
                                        'netval5' => $res->netval5,
                                        'netlastval5' => $res->netlastval5,
                                        'targetval5' => $res->targetval5,
                                        'unitach5' => $res->unitach5,
                                        'unitgrowth5' => $res->unitgrowth5,
                                        'unitpmpt5' => $res->unitpmpt5,
                                        'valach5' => $res->valach5,
                                        'valgrowth5' => $res->valgrowth5,
                                        'valpmpt5' => $res->valpmpt5,
                                    );
                $code = '';
                $ind = '';
                
            }
        }
        return $qb_result;
        //print_r($qb_result);
        //die;
    }


}


?>