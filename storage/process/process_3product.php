<?php
"update incentive_summaryP, (
select incentive_slab.divisionid, incentive_slab.profileid, incentive_slab.territory_type, incentive_slab.incentive_type, incentive_slab.fyear,
incentive_slab.noofbrand_bud, incentive_slab.ach_val_fr, incentive_slab.ach_val_to,incentive_slab.app_pcent
from incentive_slab
where incentive_slab.divisionid = 3 
and incentive_slab.profileid = 5
and incentive_slab.incentive_type = 'quarterly'
and incentive_slab.group_code in (5)
and incentive_slab.txn_no = 1
and incentive_slab.fyear = '2019-20'
order by 3) p1
set incentive_summaryP.incentive_pcent1 = p1.app_pcent
where incentive_summaryP.divisionid = p1.divisionid
and incentive_summaryP.profileid = p1.profileid
and incentive_summaryP.territory_type = p1.territory_type
and incentive_summaryP.ach_val_fr = p1.ach_val_fr
and incentive_summaryP.ach_val_to = p1.ach_val_to
and incentive_summaryP.noofbrand_bud = p1.noofbrand_bud
and incentive_summaryP.fyear = '2019-20'";

"update glen_budget_summaryP, (
select glen_budget_summaryP.divisionid,glen_budget_summaryP.zone_code,glen_budget_summaryP.region_code,
glen_budget_summaryP.area_code,glen_budget_summaryP.sap_territory_code,glen_budget_summaryP.incentive_group,
glen_budget_summaryP.profileid,
glen_budget_summaryP.fyear,glen_budget_summaryP.territory_type,glen_budget_summaryP.pmpt_units,
incentive_summaryP.ach_val_fr, incentive_summaryP.ach_val_to,
if(glen_budget_summaryP.pmpt_units > incentive_summaryP.ach_val_fr and glen_budget_summaryP.pmpt_units <= incentive_summaryP.ach_val_to ,1,0) as ind1
from glen_budget_summaryP ,incentive_summaryP
where glen_budget_summaryP.divisionid = 3 
and glen_budget_summaryP.territory_type = 'metro/non-metro' 
and glen_budget_summaryP.profileid = 5
and glen_budget_summaryP.fyear = '2019-20'
and glen_budget_summaryP.divisionid = incentive_summaryP.divisionid
and glen_budget_summaryP.territory_type = incentive_summaryP.territory_type
and glen_budget_summaryP.profileid = incentive_summaryP.profileid 
and glen_budget_summaryP.fyear = incentive_summaryP.fyear
and glen_budget_summaryP.incentive_group = incentive_summaryP.noofbrand_bud
having ind1 = 1 ) p1
set glen_budget_summaryP.ach_val_fr = p1.ach_val_fr,  glen_budget_summaryP.ach_val_to = p1.ach_val_to 
where glen_budget_summaryP.divisionid = 3 
and glen_budget_summaryP.territory_type = 'metro/non-metro' 
and glen_budget_summaryP.profileid = 5
and glen_budget_summaryP.fyear = '2019-20'
and glen_budget_summaryP.divisionid = p1.divisionid
and glen_budget_summaryP.territory_type = p1.territory_type
and glen_budget_summaryP.profileid = p1.profileid 
and glen_budget_summaryP.incentive_group = p1.incentive_group
and glen_budget_summaryP.fyear = p1.fyear
and glen_budget_summaryP.sap_territory_code = p1.sap_territory_code";

"update incentive_summaryP, (
select glen_budget_summaryP.divisionid,glen_budget_summaryP.territory_type,glen_budget_summaryP.profileid,glen_budget_summaryP.fyear, 
glen_budget_summaryP.incentive_group,glen_budget_summaryP.ach_val_fr,glen_budget_summaryP.ach_val_to,
sum(glen_budget_summaryP.pool_strength) as pool_strength, sum(glen_budget_summaryP.product_pmpt_value) as product_pmpt_value
from glen_budget_summaryP
where glen_budget_summaryP.divisionid = 3
and glen_budget_summaryP.territory_type = 'metro/non-metro'
and glen_budget_summaryP.profileid = 5
and glen_budget_summaryP.fyear = '2019-20'
group by incentive_group,ach_val_fr,ach_val_to) p1
set incentive_summaryP.wt_avg = round(p1.product_pmpt_value/p1.pool_strength,2),incentive_summaryP.tot_psr = p1.pool_strength
where incentive_summaryP.ach_val_fr = p1.ach_val_fr
and incentive_summaryP.ach_val_to = p1.ach_val_to
and incentive_summaryP.divisionid = p1.divisionid
and incentive_summaryP.territory_type = p1.territory_type
and incentive_summaryP.profileid = p1.profileid
and incentive_summaryP.fyear = p1.fyear
and incentive_summaryP.noofbrand_bud = p1.incentive_group
and incentive_summaryP.fyear = '2019-20'";

"update incentive_slab set pearn_pcent = 65.00, exp_pcent = 4050 where fyear = '2019-20' and incentive_type = 'quarterly' and group_code = 5";

"update incentive_slab set esv_pcent = 92.98 where fyear = '2019-20' and incentive_type = 'quarterly' and group_code = 5";

"update incentive_summaryP,(
select incentive_slab.divisionid, incentive_slab.profileid, incentive_slab.territory_type, incentive_slab.incentive_type, incentive_slab.fyear,
incentive_slab.noofbrand_bud,incentive_slab.ach_val_fr, incentive_slab.ach_val_to,incentive_slab.pearn_pcent,incentive_slab.pearn_factor,
incentive_slab.exp_pcent,incentive_slab.esv_pcent
from incentive_slab
where incentive_slab.divisionid = 3 
and incentive_slab.profileid = 5
and incentive_slab.incentive_type = 'quarterly'
and incentive_slab.fyear = '2019-20'
and incentive_slab.group_code = 5
and incentive_slab.txn_no = 1
order by ach_val_fr,ach_val_to) p1
set incentive_summaryP.prospective_earn = round(incentive_summaryP.tot_psr * p1.pearn_pcent/ 100,0) + p1.pearn_factor,
incentive_summaryP.exp_qualifier = round(incentive_summaryP.tot_psr * p1.exp_pcent/ 100,0),
incentive_summaryP.pearn_pcent = p1.pearn_pcent,incentive_summaryP.exp_pcent = p1.exp_pcent, incentive_summaryP.esv_pcent = p1.esv_pcent
where incentive_summaryP.divisionid = p1.divisionid
and incentive_summaryP.profileid = p1.profileid
and incentive_summaryP.territory_type = p1.territory_type
and incentive_summaryP.ach_val_fr = p1.ach_val_fr
and incentive_summaryP.ach_val_to = p1.ach_val_to
and incentive_summaryP.noofbrand_bud = p1.noofbrand_bud
and incentive_summaryP.fyear = '2019-20'";

"update incentive_summaryP set tot_qtr_sale = wt_avg * 3 * esv_pcent, qtr_incentive_total = incentive_pcent1 * wt_avg * 3,
tot_incentive_pcent = qtr_incentive_total/tot_qtr_sale * 100,total_incentive = qtr_incentive_total * exp_qualifier,
sales_qualify = exp_qualifier * tot_qtr_sale, non_qualifier = tot_psr - exp_qualifier,
sales_nqualify = non_qualifier * tot_qtr_sale * 0.9
where incentive_summaryP.fyear = '2019-20'
and incentive_summaryP.divisionid = 3";
?>