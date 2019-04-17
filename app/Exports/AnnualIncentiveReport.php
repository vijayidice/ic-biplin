<?php
  
namespace App\Exports;
  
use App\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
//use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use DB;
  
class AnnualIncentiveReport implements FromArray,  WithHeadings, WithEvents
{
	public function __construct($division,  $financial_year)
    {
        $this->division_name = '';
        $this->division = $division;
        $this->financial_year = $financial_year;
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
            ['Ind', 'Code', 'Name', 'SS', 'PSRs SS', 'Category', 'Annual Target', 'Annual PMPT', 'Qualifier', 'Slab Amount', 'Amount', 'PSR Total Earning', 'Year Total Rupee Value', '', '', '', '', ''],
            ['', '', '', '', '', '', '', '', '', '', '', '', 'Net Val3', 'Net Last Val3', 'Target Val3', 'Val Ach3', 'Net Growth3', 'Val Pmpt3'],
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

                $event->sheet->getStyle('A3:R4')->getFill()
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
                $event->sheet->mergeCells('L3:L4');
                $event->sheet->mergeCells('M3:R3');
            },
        ];
    }
    
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        echo 'SELECT incentive_data.territory_code AS tc, incentive_data.area_code AS ac, incentive_data.region_code AS rc, incentive_data.zone_code AS zc, pool_strength,     incentive_data.hierarchy AS hr, incentive_data.s_strength AS sanct_strength,   incentive_data.territory_name AS territoryname, incentive_data.territory_type AS category, incentive_data.profileid AS pf, incentive_data.anual_target AS annualtarget,  incentive_data.pmpt_target AS pmpttarget, CASE WHEN incentive_data.pmpt_target < 422000 THEN 15 ELSE 10 END AS growthrate, incentive_data.min_brand AS productreq, incentive_data.must_brand + incentive_data.no_of_brands AS brandsachieved, CASE WHEN incentive_data.eligible = 5 THEN "Yes" ELSE "No" END AS eli, incentive_data.eligible AS new_eli, CASE WHEN incentive_data.app_pcent != 0 THEN incentive_data.app_pcent ELSE incentive_data.app_amount END AS slab_amount, IF (incentive_data.eligible = 5, incentive_data.incentive_amt, 0) AS amount, incentive_data.fh_gw AS halfgrowth, incentive_data.fh_ach AS halfach, incentive_data.next_mon_ach AS octach, incentive_data.next_mon_gw AS octgrowth,  incentive_data.a_val_tot AS netval3, incentive_data.p_a_val_tot AS netlastval3, incentive_data.b_val_tot AS targetval3, incentive_data.a_pcent AS valach3, incentive_data.b_qtr_growth AS valgrowth3, incentive_data.a_val_pmpt AS valpmpt3, incentive_data.next_month_a_val AS netval4, incentive_data.next_month_p_a_val AS netlastval4,  incentive_data.next_month_b_val AS targetval4, incentive_data.next_mon_ach AS valach4,  incentive_data.next_mon_gw AS valgrowth4, incentive_data.next_month_val_pmpt AS valpmpt4 FROM incentive_data WHERE incentive_data.profileid IN (5, 6, 7, 8) AND incentive_data.fyear = "'.$this->financial_year.'" AND incentive_data.incentive_type = "anual_ach" AND incentive_data.divisionid = '.$this->division.' ORDER BY zc, rc, hr, ac, pf'; 
    	$result = DB::select('SELECT incentive_data.territory_code AS tc, incentive_data.area_code AS ac, incentive_data.region_code AS rc, incentive_data.zone_code AS zc, pool_strength,     incentive_data.hierarchy AS hr, incentive_data.s_strength AS sanct_strength,   incentive_data.territory_name AS territoryname, incentive_data.territory_type AS category, incentive_data.profileid AS pf, incentive_data.anual_target AS annualtarget,  incentive_data.pmpt_target AS pmpttarget, CASE WHEN incentive_data.pmpt_target < 422000 THEN 15 ELSE 10 END AS growthrate, incentive_data.min_brand AS productreq, incentive_data.must_brand + incentive_data.no_of_brands AS brandsachieved, CASE WHEN incentive_data.eligible = 5 THEN "Yes" ELSE "No" END AS eli, incentive_data.eligible AS new_eli, CASE WHEN incentive_data.app_pcent != 0 THEN incentive_data.app_pcent ELSE incentive_data.app_amount END AS slab_amount, IF (incentive_data.eligible = 5, incentive_data.incentive_amt, 0) AS amount, incentive_data.fh_gw AS halfgrowth, incentive_data.fh_ach AS halfach, incentive_data.next_mon_ach AS octach, incentive_data.next_mon_gw AS octgrowth,  incentive_data.a_val_tot AS netval3, incentive_data.p_a_val_tot AS netlastval3, incentive_data.b_val_tot AS targetval3, incentive_data.a_pcent AS valach3, incentive_data.b_qtr_growth AS valgrowth3, incentive_data.a_val_pmpt AS valpmpt3, incentive_data.next_month_a_val AS netval4, incentive_data.next_month_p_a_val AS netlastval4,  incentive_data.next_month_b_val AS targetval4, incentive_data.next_mon_ach AS valach4,  incentive_data.next_mon_gw AS valgrowth4, incentive_data.next_month_val_pmpt AS valpmpt4 FROM incentive_data WHERE incentive_data.profileid IN (5, 6, 7, 8) AND incentive_data.fyear = "'.$this->financial_year.'" AND incentive_data.incentive_type = "anual_ach" AND incentive_data.divisionid = '.$this->division.' ORDER BY zc, rc, hr, ac, pf');

            echo "<pre>"; print_r($result);  die;
            $qb_result = [];
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
                                        'territoryname' => $res->territoryname,
                                        'sanct_strength' => $res->sanct_strength,
                                        'pool_strength' => $res->pool_strength,
                                        'category' => $res->category,
                                        'annualtarget' => $res->annualtarget,
                                        'pmpttarget' => $res->pmpttarget,
                                        'eli' => $res->eli,
                                        'slab_amount' => $res->slab_amount,
                                        'amount' => $res->amount,
                                        'total_psr_earning' => $res->amount,
                                        'netval3' => $res->netval3,
                                        'netlastval3' => $res->netlastval3,
                                        'targetval3' => $res->targetval3,
                                        'valach3' => $res->valach3,
                                        'valgrowth3' => $res->valgrowth3,
                                        'valpmpt3' => $res->valpmpt3,
                                    );
                    $code = '';
                    $ind = '';
                }
            }
            return $qb_result;
    }
}


?>