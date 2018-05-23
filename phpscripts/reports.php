<?
//$time_interval = "interval 30 day ";
$date_analyzed_time_filter = " date_analyzed > \"" . date('Y-m-d H:i:s', $start_date) . "\" and date_analyzed < \"" . date('Y-m-d H:i:s', $end_date + 3600*24 - 1) . "\" ";
$date_submitted_time_filter = " submission_date > \"" . date('Y-m-d H:i:s', $start_date) . "\" and submission_date <  \"" . date('Y-m-d H:i:s', $end_date + 3600*24 - 1) . "\" ";

$samplesSubmittedPerDay_sql = "select a.selected_date, count(b.id) as count_ from (select * from 
(select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
where selected_date between \"" . date('Y-m-d', $start_date) . "\" and \"" . date('Y-m-d', $end_date) . "\") a
left join 
(select s.id, ss.submission_date from sampleSets ss, samples s
where ss.id=s.sampleset_id) b
on
date(b.submission_date) = a.selected_date
group by a.selected_date";

$samplesAnalyzedPerDay_sql = "select a.selected_date, count(b.id) as count_ from (select * from 
(select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
where selected_date between \"" . date('Y-m-d', $start_date) . "\" and \"" . date('Y-m-d', $end_date) . "\") a
left join 
(select s.id, ss.date_analyzed from sampleSets ss, samples s
where ss.id=s.sampleset_id) b
on
date(b.date_analyzed) = a.selected_date
group by a.selected_date";
//echo $samplesAnalyzedPerDay_sql . "<BR>";

$samplesPerGroupSQL = "select ml.id, ml.name, ".
	"(select count(*) from sampleSets ss, samples s, staff_list sl where ml.id=sl.mailing_list_id and sl.id=ss.submitted_to and s.sampleset_id = ss.id  and " . $date_submitted_time_filter . ") as submission_count, " .
	"(select count(*) from sampleSets ss, samples s, staff_list sl where ml.id=sl.mailing_list_id and sl.id=ss.submitted_to and s.sampleset_id = ss.id and " . $date_analyzed_time_filter . ") as analyzed_count, " .
	" group_concat(distinct a.name order by a.name asc separator ', ') as assays_done " .
	"from assays a, samples s, sampleSets ss, staff_list sl, mailing_lists ml " .
	"where sl.mailing_list_id=ml.id and sl.id=ss.submitted_to and s.sampleset_id=ss.id and s.assay_performed=a.id " .
	" and ((" . $date_analyzed_time_filter . ") or (" . $date_submitted_time_filter . "))" .
	" group by ml.name";
//echo $samplesPerGroupSQL . "<BR>";

$samplesPerSubmittorSQL = "select sl.id, sl.first_name, ".
	"count(*) as submission_count, " .
	" group_concat(distinct sc.name order by sc.name asc separator ', ') as characterizations_requested " .
	"from staff_list sl, samples s, sampleSets ss, sample_characterizations sc " .
	"where sl.id=ss.submitted_by and s.sampleset_id=ss.id and sc.id=s.characterization_requested and " .
	$date_submitted_time_filter .
	" group by sl.id order by submission_count desc";
//echo $samplesPerSubmittorSQL . "<BR>";

$samplesPerAnalystSQL = "select sl.id, sl.first_name, ".
	"count(*) as analyzed_count, " .
	" group_concat(distinct a.name order by a.name asc separator ', ') as assays_done " .
	"from staff_list sl, samples s, sampleSets ss, assays a " .
	"where sl.id=ss.submitted_to and s.sampleset_id=ss.id and a.id=s.assay_performed and " .
	$date_analyzed_time_filter .
	" group by sl.id order by analyzed_count desc";
//echo $samplesPerSubmittorSQL . "<BR>";

$analyses_count_sql = "select a.name, count(*) as count_ from sampleSets ss, samples s, assays a " . 
					  "where s.sampleset_id=ss.id and a.id=s.assay_performed and " . $date_analyzed_time_filter .
					  "group by a.name";
//echo $analyses_count_sql;
?>