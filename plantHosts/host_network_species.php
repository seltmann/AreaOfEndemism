<?php

#decision tree code for host/associate confidence at host species level (will need to modify for host genus level)
#trial 1, October 2, 2013

//====coll_total_i - total number of times the insect was collected at any collecting event, indifferent of host collected on
//====coll_number_same_h - number of times collected at different collecting events, of host (at species level) + insect (at species level) - returns numberic value
//====coll_percent - percent of total colevents host (at species level) + insect (at species level)

//====h_n_specimens - greatest number of specimens found at single collecting event (at species level) (total)
//====i_j_same_col - number of total juveniles are found on host (at species level) - returns numberic value
//====h_voucher - occurrence is verified by vouchered host specimen - number of specimens that were vouchered

require_once("MDB2.php");
 
// === change this to run from your database credentials ===
##add connector for database
	require_once("../../../UniversalConnector.php");  

// === Main database connection and error handling ===
$DB =& MDB2::connect($dsn);
if (PEAR::isError($DB)) { handleError($DB->getMessage()); }

// === finds unique collecting events ===
						    $rsG = i_h();
						        while ($row =& $rsG->fetchRow()) {
						$h_family = $row[0];	//F4.HostTaxName - 0 - h_family
						$h_genus = $row[1];		//F1.HostTaxName - 1 - h_genus
						$h_species = $row[2];	//F2.HostTaxName - 2 - h_species
						$i_family = $row[3];	//T5.TaxName - 3 - i_family
						$i_tribe = $row[4];		//T3.TaxName - 4 - i_tribe
						$i_genus = $row[5];		//T1.TaxName - 5 - i_genus
						$i_species = $row[6];	//T2.TaxName - 6 - i_species
						$h_family_id = $row[7];	//F4.HostMNLUID - 7 - h_family_id
						$h_genus_id = $row[8];	//F1.HostMNLUID - 8 - h_genus_id
						$h_species_id = $row[9];//F2.HostMNLUID - 9 - h_species_id
						$i_family_id = $row[10];//T5.MNLUID - 10 - i_family_id
						$i_tribe_id = $row[11];	//T3.MNLUID - 11 - i_tribe_id
						$i_genus_id = $row[12];	//T1.MNLUID - 12 - i_genus_id
						$i_species_id = $row[13];//T2.MNLUID - 13 - i_species_id
						
						echo $row[0] . "$" . $row[1] ."$" . $row[2] ."$" . $row[3] ."$" . $row[4] ."$" . $row[5] ."$" . $row[6] . $row[7] ."$" . $row[8] ."$" . $row[9] ."$" . $row[10] ."$" . $row[11]. "$" . $row[12] ."$" . $row[13]. "\n"; 
								i_h_insert($h_family,$h_genus,$h_species,$i_family,$i_tribe,$i_genus,$i_species,$h_family_id,$h_genus_id,$h_species_id,$i_family_id,$i_tribe_id,$i_genus_id,$i_species_id);
							}

$unique_associations = find_stuff_out();
	while ($row =& $unique_associations->fetchRow()) {
		$id = $row[0];
		$h_species = $row[1];
		$h_genus = $row[2];
		$h_family = $row[3];
		$i_species = $row[4];
		$i_genus = $row[5];
		$i_tribe = $row[6];
		$i_family = $row[7];
		$i_family_id = $row[8];
		$i_tribe_id = $row[9];
		$i_genus_id = $row[10];
		$i_species_id = $row[11];
		$h_family_id = $row[12];
		$h_genus_id = $row[13];
		$h_species_id = $row[14];
		
	$is_vouchered = h_voucher($h_species_id,$i_species_id);
	$number_juveniles = i_j_same_col($h_species_id,$i_species_id);
	$greatest_number_specimens = h_n_specimens($h_species_id,$i_species_id);
	$coll_total_i = coll_total_i($i_species_id);
	$coll_number_same_h = coll_number_same_h($h_species_id,$i_species_id);
	//$other_hosts_same_insect = other_hosts_same_insect($h_species_id,$i_species_id);
	$coll_percent = coll_percent($coll_total_i,$coll_number_same_h,$h_species_id,$i_species_id);
	
	
	echo $h_family . " " . $h_genus . " " . $h_species . " " . $i_genus . " " . $i_species . " " . $id . " " . $is_vouchered . " " . $number_juveniles . " " . $greatest_number_specimens . " " . $coll_total_i. " ". $coll_number_same_h . " " . $coll_number_same_h . " " . $coll_percent . "\n";
	

	}




/////---functions below ////////


//total number of collecting events the insect was collected
function coll_total_i($i_species_id){
		global $DB;
	$sql = "Select count(distinct ColEventUID) from Specimen where Specimen.species='$i_species_id' AND Specimen.species !='0'";
	$results = $DB->query($sql);
    if (PEAR::isError($results)) { die("DB Error - Invalid query for coll_total_i" . $results->getMessage()); }

while ($row =& $results->fetchRow()){
	$counts = $row[0];
	$sql_update = "UPDATE `pbi_locality`.`host_network_species` SET `coll_total_i` = '$counts' where `i_species_id`='$i_species_id'";
	$DB->query($sql_update);
	}
	return $counts;	
	
}

//percent of all collecting events is this association representing?
function coll_percent($coll_total_i,$coll_number_same_h,$h_species_id,$i_species_id){
		global $DB;
	$insert_percent = ($coll_number_same_h / $coll_total_i) * 100;
	$rounded_percent = round($insert_percent,2);
	$sql_update = "UPDATE `pbi_locality`.`host_network_species` SET `coll_percent` = '$rounded_percent' where `i_species_id`='$i_species_id' AND `h_species_id`='$h_species_id'";
	$results = $DB->query($sql_update);
    if (PEAR::isError($results)) { die("DB Error - Invalid query for coll_percent" . $results->getMessage()); }
	return $rounded_percent;
}


//number of colecting events with this combination
function coll_number_same_h($h_species_id,$i_species_id){
	global $DB;
	$sql = "Select count(distinct ColEventUID) from Specimen where Specimen.HostSp='$h_species_id' AND Specimen.species='$i_species_id'";
	$results = $DB->query($sql);
    if (PEAR::isError($results)) { die("DB Error - Invalid query for coll_number_same_h" . $results->getMessage()); }

while ($row =& $results->fetchRow()){
	$counts = $row[0];
	$sql_update = "UPDATE `pbi_locality`.`host_network_species` SET `coll_number_same_h` = '$counts' where `i_species_id`='$i_species_id' AND `h_species_id`='$h_species_id'";
	$DB->query($sql_update);
	}
	return $counts;	
}

//number of specimens found at a collecting event that is same species on same host. Cannot tell if that is the same plant or not.
//some information about number of specimens of things on same pin is in the notes. Could TRUE/FALSE if has like '%on pin%' as indication of more than one specimen. This again does not assume same plant, just collected together.

function h_n_specimens($h_species_id,$i_species_id){
	global $DB;
	$sql = "Select count(SpecimenUID), ColEventUID from Specimen where Specimen.HostSp='$h_species_id' AND Specimen.species='$i_species_id' GROUP BY ColEventUID order by count(SpecimenUID) desc limit 1";
	$results = $DB->query($sql);
    if (PEAR::isError($results)) { die("DB Error - Invalid query for h_n_specimens" . $results->getMessage()); }

while ($row =& $results->fetchRow()){
	$counts = $row[0];
	$sql_update = "UPDATE `pbi_locality`.`host_network_species` SET `h_n_specimens` = '$counts' where `i_species_id`='$i_species_id' AND `h_species_id`='$h_species_id'";
	$DB->query($sql_update);
	}
	return $counts;	
}

//checks to see if juvys or eggs are found with the host-associate combination
function i_j_same_col($h_species_id,$i_species_id){
	global $DB;
	$sql = "Select count(SpecimenUID) from Specimen where Specimen.HostSp='$h_species_id' AND Specimen.species='$i_species_id' AND (Specimen.Sex like '%Juvenile%' OR Specimen.Sex like '%Subadult%' OR Specimen.Sex like '%Egg%')";
	$results = $DB->query($sql);
    if (PEAR::isError($results)) { die("DB Error - Invalid query for i_j_same_col" . $results->getMessage()); }

while ($row =& $results->fetchRow()){
	$counts = $row[0];
	$sql_update = "UPDATE `pbi_locality`.`host_network_species` SET `i_j_same_col` = '$counts' where `i_species_id`='$i_species_id' AND `h_species_id`='$h_species_id'";
	$DB->query($sql_update);
	}
	return $counts;	
}

//gets the information about the unique associations found in the host_network table
function find_stuff_out(){
	 global $DB;
	$sql = "Select * from host_network_species";
	$results = $DB->query($sql);
    if (PEAR::isError($results)) { die("DB Error - Invalid query for find_stuff_out" . $results->getMessage()); }
            return $results;
		}
		
//checks to see if vouchers are found with the host-associate combination		
function h_voucher($h_species_id,$i_species_id){
	 global $DB;
	$sql = "Select count(distinct FieldHost.HerbID) from FieldHost left join Specimen on Specimen.FieldHostUID=FieldHost.FieldHostUID where Specimen.HostSp='$h_species_id' AND Specimen.species='$i_species_id' AND FieldHost.HerbID !=''";
	$results = $DB->query($sql);
    if (PEAR::isError($results)) { die("DB Error - Invalid query for h_voucher" . $results->getMessage()); }

while ($row =& $results->fetchRow()){
	$counts = $row[0];
	$sql_update = "UPDATE `pbi_locality`.`host_network_species` SET `h_voucher` = '$counts' where `i_species_id`='$i_species_id' AND `h_species_id`='$h_species_id'";
	$DB->query($sql_update);
	}
	return $counts;	
            
}		
		
// get the unique combination of host + taxon names
//data already cleaned in many ways before being inserted into the table as unique combinations of taxon and host. This is done by exclusion. The only way to have these included in later analysis is clean up the data in the database and rerun the script.

//removes all nr. and cf. of host determinations because all ready assuming poor determination
//removes all Unknowns from genus or species host determinations
//removes all unknown, undetermined, unidentified from host determinations from family
//presently only includes those that are identified to species for both host and taxon (need to have seperate for genus level for host); those not identified to species are removed.
function  i_h(){
            global $DB;
//modified to match endimism script
           $sql = "SELECT distinct F4.HostTaxName,F1.HostTaxName,F2.HostTaxName,T5.TaxName,T3.TaxName,T1.TaxName,T2.TaxName,F4.HostMNLUID,F1.HostMNLUID,F2.HostMNLUID,T5.MNLUID,T3.MNLUID,T1.MNLUID,T2.MNLUID FROM Specimen S1 left join MNL T1 ON S1.Genus=T1.MNLUID left join MNL T2 ON S1.Species=T2.MNLUID left join MNL T3 ON S1.Tribe=T3.MNLUID left join MNL T4 on S1.Subfamily=T4.MNLUID left join MNL T5 on T4.ParentID=T5.MNLUID left join Locality L1 on S1.Locality=L1.LocalityUID left join Flora_MNL F1 ON S1.HostG=F1.HostMNLUID left join Flora_MNL F2 ON S1.HostSp=F2.HostMNLUID left join Flora_MNL F3 ON S1.HostSSp=F3.HostMNLUID left join Flora_MNL F4 ON S1.HostF=F4.HostMNLUID left join SubDiv SD on L1.SubDivUID=SD.SubDivUID left join StateProv SP on SD.StateProvUID=SP.StateProvUID left join colevent CE on S1.ColEventUID=CE.ColEventUID left join Collector C1 on CE.Collector=C1.CollectorUID left join Country CN on SP.CountryUID=CN.UID left join HostCommonName HC on S1.HostCName=HC.CommonUID  WHERE T2.TaxName not like '%#%' and T2.TaxName not like '%sp.%' and T2.TaxName != 'sp' and T2.TaxName not like '%\_%' and T2.TaxName not like '%spp.%' and T2.TaxName not like '%nr.%' and T2.TaxName != 'unknown' and L1.LocalityStr !='unknown' and (CN.UID = '2' or CN.UID = '8' or CN.UID = '11') and (S1.Subfamily = '6295' or S1.Subfamily = '8150' or S1.Subfamily = '6294' or S1.Subfamily = '8163') AND F4.HostMNLUID !='0' AND F4.HostMNLUID !='7622' AND F4.HostMNLUID !='8356' AND F4.HostMNLUID !='1491' AND F4.HostMNLUID !='1490' AND F1.HostTaxName !='0' AND F2.HostTaxName !='' AND F2.HostTaxName !='0' AND F2.HostTaxName !='sp.' AND F1.HostTaxName !='' AND F1.HostTaxName !='spp.' AND F1.HostTaxName not like '%cf.%' AND F1.HostTaxName not like '%nr.%' AND F2.HostTaxName !='spp.' AND F2.HostTaxName not like '%cf.%' AND F2.HostTaxName not like '%nr.%' AND F2.HostTaxName !='unknown' AND F1.HostTaxName !='Unknown'";
            $results = $DB->query($sql);
            if (PEAR::isError($results)) { die("DB Error - Invalid query for i_h" . $results->getMessage()); }
            return $results;
        }   


	//performs insert of host/family unique combinations
function i_h_insert($h_family,$h_genus,$h_species,$i_family,$i_tribe,$i_genus,$i_species,$h_family_id,$h_genus_id,$h_species_id,$i_family_id,$i_tribe_id,$i_genus_id,$i_species_id){
	 global $DB;

	           $sql = "INSERT INTO `pbi_locality`.`host_network_species` (`id`, `h_family`, `h_genus`, `h_species`, `i_family`, `i_tribe`, `i_genus`, `i_species`, `h_family_id`, `h_genus_id`, `h_species_id`, `i_family_id`, `i_tribe_id`, `i_genus_id`, `i_species_id`) VALUES (NULL, '$h_family', '$h_genus', '$h_species', '$i_family', '$i_tribe', '$i_genus', '$i_species', '$h_family_id', '$h_genus_id', '$h_species_id', '$i_family_id', '$i_tribe_id', '$i_genus_id', '$i_species_id')";
            $results = $DB->query($sql);
            if (PEAR::isError($results)) { die("DB Error - Invalid query for i_h" . $results->getMessage()); }
}



// === disconnects from database ===  
$DB->disconnect();
 
?>
