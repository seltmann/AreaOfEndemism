<?php
//coll_number_same_h = number of collecting events with host genus id, insect species id (1 = low)
//i_j_same_col = number of juveniles found with host-associate combination (>2 = medium)
//h_voucher = if specimen is a vouchered field host (>1 = medium)
//coll_percent = percent of total collecting events collected on that host genus (weigh this?)(>50% high)
//coll_total_i = number of total collecting events for that species, where a host was recorded
//h_n_specimens = count of max number of specimens found on a single collecting event with host/insect combination (>10 = high)
//insert confidence values into rel_confidence field: HIGH, MEDIUM, LOW

require_once("MDB2.php");
 
// === change this to run from your database credentials ===
##add conector
require_once("../../../UniversalConnector.php");
 
// === Main database connection and error handling ===
$DB =& MDB2::connect($dsn);
if (PEAR::isError($DB)) { handleError($DB->getMessage()); }
	require_once("../../../UniversalConnector.php"); 

$unique_associations = find_stuff_out();
	while ($row =& $unique_associations->fetchRow()) {
		$id = $row[0];
		$coll_number_same_h = $row[15];
		$coll_percent = $row[16];
		$rel_confidence = $row[24];
		
		is_high_medium_low($coll_percent,$id,$coll_number_same_h,$rel_confidence);		
	}
	
	$higher_resolution = find_stuff_out_higher();
		while ($row =& $higher_resolution->fetchRow()) {
			$count_medium = $row[0];
			$insect = $row[1];
			$i_species_id = $row[2];
			
			echo $count_medium . " " . $insect . " " . $i_species_id . "\n";
			if ($count_medium > 2) relative_medium($i_species_id, $count_medium);
			
		//	add_one_family($coll_percent,$h_voucher,$h_n_specimens,$id,$coll_number_same_h,$rel_confidence);
		//	add_one_juvy($coll_percent,$h_voucher,$h_n_specimens,$id,$coll_number_same_h,$rel_confidence);
		//	add_one_specimens($coll_percent,$h_voucher,$h_n_specimens,$id,$coll_number_same_h,$rel_confidence);
			
			}	

// if a insect has occurances with medium or high on multiple host genera than sub-divide those for finer granulations.

// if those are in the same family give higher weight to that family +1
// if 2 and different families, possible that insect misidentification from lower collecting number (+1 for higher)
// juvy involved? +1
// number of specimens collected > number collecting events? +1
# id $row[0]
# h_genus $row[1]
# h_species $row[2]
# h_family $row[3]
# i_species $row[4]
# i_genus $row[5]
# i_tribe $row[6]
# i_family $row[7]
# i_family_id $row[8]
# i_tribe_id $row[9]
# i_genus_id $row[10]
# i_species_id $row[11]
# h_family_id $row[12]
# h_genus_id $row[13]
# h_species_id $row[14]
# coll_number_same_h $row[15]
# coll_percent $row[16]
# h_n_specimens $row[17]
# i_h_same_g $row[18]
# i_h_same_f $row[19]
# i_j_h_col_event $row[20]
# i_j_same_col $row[21]
# h_voucher $row[22]
# coll_total_i $row[23]
# rel_confidence $row[24]


function relative_medium($i_species_id, $count_medium){
		global $DB;
	$sql = "Select * from host_network_species where i_species_id='$i_species_id'";
	$results = $DB->query($sql);
	if (PEAR::isError($results)) { die("DB Error - Invalid query for relative_medium" . $results->getMessage()); }
	while ($row =& $results->fetchRow()) {
		$id = $row[0];
		$coll_number_same_h = $row[15];
		$coll_percent = $row[16];
		$rel_confidence = $row[24];
		$h_family_id = $row[12];
		$h_n_specimens = $row[17];
		$h_voucher = $row[22];
		$i_j_same_col = $row[21];
		
		$update_value = $rel_confidence;
		if ($h_n_specimens > 25 && $rel_confidence != 'HIGH') $update_value = 'MEDIUM_HIGH';
		if ($h_voucher > 2 && $rel_confidence != 'HIGH') $update_value = 'MEDIUM_HIGH';
		if ($i_j_same_col > 1 && $rel_confidence != 'HIGH') $update_value = 'MEDIUM_HIGH';
	//	if ($count_medium = 2 && $rel_confidence = 'HIGH') $update_value = compare_taxa($i_species_id);
		insert_confidence($update_value,$id);
	}

}

function compare_taxa($i_species_id){
	return 'MEDIUM_YES';
}

//gets the information about the unique associations found in the host_network_genus table
function find_stuff_out_higher(){
		global $DB;
	$sql = "Select count('id'), concat(i_genus, \" \", i_species), i_species_id, rel_confidence from host_network_species where rel_confidence = 'MEDIUM' OR rel_confidence = 'HIGH' GROUP BY i_species_id";
	$results = $DB->query($sql);
	if (PEAR::isError($results)) { die("DB Error - Invalid query for find_stuff_out" . $results->getMessage()); }
		     return $results;
}

//returns all the values from the host network table
function find_stuff_out(){
		global $DB;
	$sql = "Select * from host_network_species";
	$results = $DB->query($sql);
	if (PEAR::isError($results)) { die("DB Error - Invalid query for find_stuff_out" . $results->getMessage()); }
		     return $results;
		}		

//first pass at defining a confidence limit. Bins into high, medium and low
function is_high_medium_low($coll_percent,$id,$coll_number_same_h,$rel_confidence){
	$update_value = $rel_confidence;
	if ($coll_number_same_h > '3' && $coll_percent > '2.00') $update_value='MEDIUM';
	if ($coll_number_same_h > '2' && $coll_percent > '15.00') $update_value='MEDIUM';
	if ($coll_number_same_h > '5' && $coll_percent > '15.00') $update_value='HIGH';


//originals 	
//	if ($coll_number_same_h > '3' && $coll_percent > '2.00') $update_value='MEDIUM';
//	if ($coll_number_same_h > '5' && $coll_percent > '15.00') $update_value='HIGH';
	
	insert_confidence($update_value,$id);
}

function insert_confidence($update_value,$id){
	 global $DB;
	$sql_update = "UPDATE `pbi_locality`.`host_network_species` SET `rel_confidence` = '$update_value' where `id`='$id'";
	$DB->query($sql_update);
 }


// === disconnects from database ===  
$DB->disconnect();
?>
