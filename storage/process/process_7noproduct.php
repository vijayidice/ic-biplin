<?php
"update incentive_summary, (
select incentive_slab.divisionid, incentive_slab.profileid, incentive_slab.territory_type, incentive_slab.incentive_type, incentive_slab.fyear,
incentive_slab.ach_val_fr, incentive_slab.ach_val_to,incentive_slab.app_pcent
from incentive_slab
where incentive_slab.divisionid = 7
and incentive_slab.profileid = 5
and incentive_slab.territory_type = 'metro/non-metro'
and incentive_slab.group_code in (1,2)
and incentive_slab.txn_no = 1
and incentive_slab.noofbrand_bud in ('brand2','brand1')
and incentive_slab.fyear = '2019-20'
order by 3) p1
set incentive_summary.incentive_pcent1 = p1.app_pcent
where incentive_summary.divisionid = p1.divisionid
and incentive_summary.profileid = p1.profileid
and incentive_summary.territory_type = p1.territory_type
and incentive_summary.ach_val_fr = p1.ach_val_fr
and incentive_summary.ach_val_to = p1.ach_val_to
and incentive_summary.fyear = '2019-20'";

 "update incentive_summary, (
select incentive_slab.divisionid, incentive_slab.profileid, incentive_slab.territory_type, incentive_slab.incentive_type, incentive_slab.fyear,
incentive_slab.ach_val_fr, incentive_slab.ach_val_to,incentive_slab.app_pcent,incentive_slab.app_amount
from incentive_slab
where incentive_slab.divisionid = 7
and incentive_slab.profileid = 5
and incentive_slab.fyear = '2019-20'
and incentive_slab.territory_type = 'metro/non-metro'
and incentive_slab.incentive_type = 'yearly'
and incentive_slab.txn_no = 1
order by ach_val_fr,ach_val_to) p1
set incentive_summary.annual_incentive = p1.app_pcent
where incentive_summary.divisionid = p1.divisionid
and incentive_summary.profileid = p1.profileid
and incentive_summary.territory_type = p1.territory_type
and incentive_summary.ach_val_fr = p1.ach_val_fr
and incentive_summary.ach_val_to = p1.ach_val_to
and incentive_summary.fyear = '2019-20'";

"update glen_budget_summary, (
select glen_budget_summary.divisionid,glen_budget_summary.zone_code,glen_budget_summary.region_code,
glen_budget_summary.area_code,glen_budget_summary.sap_territory_code,glen_budget_summary.profileid,
glen_budget_summary.fyear,glen_budget_summary.territory_type,glen_budget_summary.pmpt_value,
incentive_summary.ach_val_fr, incentive_summary.ach_val_to,
if(glen_budget_summary.pmpt_value > incentive_summary.ach_val_fr and glen_budget_summary.pmpt_value <= incentive_summary.ach_val_to ,1,0) as ind1
from glen_budget_summary ,incentive_summary
where glen_budget_summary.divisionid = 7
and glen_budget_summary.territory_type = 'metro/non-metro'
and glen_budget_summary.profileid = 5
and glen_budget_summary.fyear = '2019-20'
and glen_budget_summary.divisionid = incentive_summary.divisionid
and glen_budget_summary.territory_type = incentive_summary.territory_type
and glen_budget_summary.profileid = incentive_summary.profileid 
and glen_budget_summary.fyear = incentive_summary.fyear
having ind1 = 1 ) p1
set glen_budget_summary.ach_val_fr = p1.ach_val_fr,  glen_budget_summary.ach_val_to = p1.ach_val_to 
where glen_budget_summary.divisionid = 7
and glen_budget_summary.territory_type = 'metro/non-metro'
and glen_budget_summary.profileid = 5
and glen_budget_summary.fyear = '2019-20'
and glen_budget_summary.divisionid = p1.divisionid
and glen_budget_summary.territory_type = p1.territory_type
and glen_budget_summary.profileid = p1.profileid 
and glen_budget_summary.fyear = p1.fyear
and glen_budget_summary.sap_territory_code = p1.sap_territory_code";

"update incentive_summary, (
select glen_budget_summary.divisionid,glen_budget_summary.territory_type,glen_budget_summary.profileid,glen_budget_summary.fyear, 
glen_budget_summary.ach_val_fr,glen_budget_summary.ach_val_to,
sum(pool_strength) as pool_strength, sum(product_pmpt_value) as product_pmpt_value
from glen_budget_summary
where divisionid = 7
and territory_type = 'metro/non-metro'
and profileid = 5
and glen_budget_summary.fyear = '2019-20'
group by ach_val_fr,ach_val_to) p1
set incentive_summary.wt_avg = round(p1.product_pmpt_value/p1.pool_strength,2), incentive_summary.tot_psr = p1.pool_strength
where incentive_summary.ach_val_fr = p1.ach_val_fr
and incentive_summary.ach_val_to = p1.ach_val_to
and incentive_summary.divisionid = p1.divisionid
and incentive_summary.territory_type = p1.territory_type
and incentive_summary.profileid = p1.profileid
and incentive_summary.fyear = p1.fyear
and incentive_summary.fyear = '2019-20'";

"update incentive_slab set pearn_pcent = 40.00 where fyear = '2019-20' and incentive_type = 'quarterly' and divisionid = 7";

"update incentive_summary,(
select incentive_slab.divisionid, incentive_slab.profileid, incentive_slab.territory_type, incentive_slab.incentive_type, incentive_slab.fyear,
incentive_slab.ach_val_fr, incentive_slab.ach_val_to,incentive_slab.pearn_pcent,incentive_slab.pearn_factor
from incentive_slab
where incentive_slab.divisionid = 7
and incentive_slab.profileid = 5
and incentive_slab.territory_type = 'metro/non-metro'
and incentive_slab.incentive_type = 'quarterly'
and incentive_slab.fyear = '2019-20'
and incentive_slab.group_code = 1
and incentive_slab.txn_no = 1
and noofbrand_bud = 'brand1'
order by ach_val_fr,ach_val_to) p1
set incentive_summary.prospective_earn = round(incentive_summary.tot_psr * p1.pearn_pcent/ 100,0) + p1.pearn_factor, 
incentive_summary.pearn_pcent = p1.pearn_pcent
where incentive_summary.divisionid = p1.divisionid
and incentive_summary.profileid = p1.profileid
and incentive_summary.territory_type = p1.territory_type
and incentive_summary.ach_val_fr = p1.ach_val_fr
and incentive_summary.ach_val_to = p1.ach_val_to
and incentive_summary.fyear = '2019-20'";

"update incentive_summary set brand1_pcent = 100
where incentive_summary.divisionid = 7
and incentive_summary.profileid = 5
and incentive_summary.territory_type = 'metro/non-metro'
and incentive_summary.fyear = '2019-20'";

"update incentive_summary set tot_qtr_sale = wt_avg * 3,qtr_incentive1 = round(tot_qtr_sale*incentive_pcent1 *100000/100,0),
qtr_incentive2 = round(tot_qtr_sale*incentive_pcent2 *100000/100,0),qtr_incentive3 = round(tot_qtr_sale*incentive_pcent3 *100000/100,0),
qtr_incentive_total = round(qtr_incentive1 * brand1_pcent/100 + qtr_incentive2 * brand2_pcent/100 ,0) * 4,
total_incentive = qtr_incentive_total + (4 * tot_qtr_sale)*annual_incentive, yearly_sale = 4 * tot_qtr_sale, tot_incentive_pcent = round(total_incentive/1000/yearly_sale,2),
ratio_qtr = round(qtr_incentive_total / total_incentive * 100,0),ratio_yrl = 100 - ratio_qtr,
qtr_incentive_total1 = round((((qtr_incentive1 *20/100) + (qtr_incentive2 *50/100) + (qtr_incentive3 *30/100))/100000)*4 * prospective_earn,2),
annual_incentive1 = round((prospective_earn * annual_incentive)/100000,2), total_incentive1 = qtr_incentive_total1 + annual_incentive1,
non_qualifier = tot_psr - prospective_earn, sales_nqualify = yearly_sale * non_qualifier * 0.9,sales_qualify = yearly_sale * prospective_earn
where divisionid = 7
and profileid = 5
and fyear = '2019-20'";
?>