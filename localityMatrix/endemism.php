<?php
#requirments:
#1. filters: SubFamily = Mirinae(id:8150),Orthotylinae(id:6294),Phylinae(id:6295),Deraeocorinae(id:8163)
#2. geographic range: North America Country.UID = Canada(id:2),Mexico(id:8),USA(id:11)
#3.	- secondary geographic filters: StateProv.StateProvUID = Arizona(id:4),Nevada(id:45),California(id:10),Baja California(id:6),Baja California Norte(id:7),Baja California Sur(id:8),Sonora(id:79)
#4. Four or more unique localities per species
#5. insect determined to species
#6. collecting event = locality, date, plant
#great basin + big four subfamilies = 1049 species

#print: subfamily,tribe,genus,species,species_id,host_family,host_genus,host_species, host_species_id,Country,State,SubDiv,Lat,Long,date,specimen_count


	require_once("MDB2.php");
	
	#connect to database=======
	require_once("../../UniversalConnector.php");

	// === Main database connection and error handling ===
	$DB =& MDB2::connect($dsn);
	if (PEAR::isError($DB)) { handleError($DB->getMessage()); }
	
	$fp = fopen('dataAllEventsWState2.tsv', 'w');
	// $dp = fopen('forMatrixBasin4.txt', 'w');
	
	$value = insects();	
		$countingNumber = 0;
		$data_written = '';
		$species[] = '';
		
		while ($row =& $value->fetchRow()){
			$Subfamily = $row[0];
			$Tribe = $row[1];
			$Genus = $row[2];
			$Species = $row[3];
			$species_id = $row[4];
			$hostFamily = $row[5];
			$hostGenus = $row[6];
			$hostSpecies = $row[7];
			$host_species_id = $row[8];
			$country = $row[9];
			$StateProv = $row[10];
			$SubDiv = $row[11];
			$DLat = $row[12];
			$DLong = $row[13];
			$DateStart = $row[14];
			$collectingUID = $row[15];
			$LocalityStr = $row[16];
			$LocalityUID = $row[17];
			$LocAccuracy = $row[18];
			$collecting_score = collecting_counts($host_species_id,$species_id);
			$event_score = locality_counts($species_id);
			

				If ($event_score >= 2){
						$data_written .= $Subfamily . "\t" . $Tribe ."\t" . $Genus ."\t" . $Species . "\t" . $species_id . "\t" . $hostFamily ."\t" . $hostGenus ."\t" . $hostSpecies ."\t" . $host_species_id  . "\t" . $country ."\t" . $StateProv ."\t" . $SubDiv . "\t" . $DLong  . "\t" . $DLat . "\t" . $DateStart . "\t" . $collectingUID . "\t" . $LocalityStr ."\t" . $LocalityUID ."\t" . $LocAccuracy . "\t" . $event_score . "\t" . $collecting_score  . "\t" . all_distinct_counts($species_id) ."\n"; 
						
				echo $Genus ."\t" . $Species ."\n";
						
				}
			$data = "subfamily" . "\t" . "tribe" . "\t" . "genus" . "\t" . "species" . "\t" . "species_id" . "\t" . "hostFamily" . "\t" . "hostGenus" . "\t" . "hostSpecies" . "\t" . "hostSpeciesId" . "\t" . "country" . "\t" . "state"  . "\t" . "subdiv" . "\t" . "long" . "\t" . "lat" . "\t" . "date" . "\t" . "collectingEventID" . "\t" . "localityStr" . "\t" . "LocalityUID" . "\t" . "LocAccuracy" . "\t" . "localityCounts" . "\t" . "collectingCounts" . "\t" . "specimenCount" . "\n" . $data_written;
		
		}
		
	
	fwrite($fp, $data);
	
function insects(){
	global $DB;
	$resultsGetName = $DB->query("Select distinct T4.TaxName as Subfamily, T3.TaxName as Tribe, T1.TaxName as Genus, T2.TaxName as Species, T2.MNLUID as species_id, F4.HostTaxName as HostFamily, F1.HostTaxName as HostGenus, F2.HostTaxName as HostSpecies, F2.HostMNLUID, CN.Country,SP.StateProv,SD.SubDivStr as SubDiv,L1.DLat,L1.DLong,CE.DateStart,CE.ColEventUID,L1.LocalityStr as localityStr,L1.LocalityUID as localityUID,L1.LocAccuracy as localityAccuracy FROM Specimen S1 left join MNL T1  ON S1.Genus = T1.MNLUID
left join MNL T2  ON S1.Species = T2.MNLUID left join MNL T3 ON S1.Tribe=T3.MNLUID left join MNL T4 on S1.Subfamily=T4.MNLUID left join MNL T5 on T4.ParentID=T5.MNLUID left join Locality L1 on S1.Locality=L1.LocalityUID left join Flora_MNL F1 ON S1.HostG=F1.HostMNLUID left join Flora_MNL F2 ON S1.HostSp=F2.HostMNLUID left join Flora_MNL F3 ON S1.HostSSp=F3.HostMNLUID left join Flora_MNL F4 ON S1.HostF=F4.HostMNLUID left join SubDiv SD on L1.SubDivUID=SD.SubDivUID left join StateProv SP on SD.StateProvUID=SP.StateProvUID left join colevent CE on S1.ColEventUID=CE.ColEventUID left join Collector C1 on CE.Collector=C1.CollectorUID left join Country CN on SP.CountryUID=CN.UID left join HostCommonName HC on S1.HostCName=HC.CommonUID where T2.TaxName not like '%#%' and T2.TaxName not like '%sp.%'and T2.TaxName != 'sp' and T2.TaxName !='sp,' and T2.TaxName not like '%\_%' and T2.TaxName not like '%spp.%' and T2.TaxName not like '%undetermined%'and T2.TaxName != 'unknown' and DLat != '0.00000' and L1.LocalityStr !='unknown' and (CN.UID = '2' or CN.UID = '8' or CN.UID = '11') and (S1.Subfamily = '6295' or S1.Subfamily = '8150' or S1.Subfamily = '6294' or S1.Subfamily = '8163')");
#(CN.UID = '2' or CN.UID = '8' or CN.UID = '11')

#(SP.StateProvUID = '4' or SP.StateProvUID = '45' or SP.StateProvUID = '10' or SP.StateProvUID = '6' or SP.StateProvUID = '7' or SP.StateProvUID = '8' or SP.StateProvUID = '79')
		if (PEAR::isError($resultsGetName)) {
			error_log("DB Error - Invalid query for insects");
			exit;
		}
		
		return $resultsGetName;
	}

//number of distinct localities
function locality_counts($species_id){
	global $DB;
	$resultsCount = $DB->query("Select count(distinct L1.DLat,L1.DLong) from Specimen S1 left join MNL T1  ON S1.Genus = T1.MNLUID left join MNL T2  ON S1.Species = T2.MNLUID left join MNL T3 ON S1.Tribe=T3.MNLUID left join MNL T4 on S1.Subfamily=T4.MNLUID left join MNL T5 on T4.ParentID=T5.MNLUID left join Locality L1 on S1.Locality=L1.LocalityUID left join Flora_MNL F1 ON S1.HostG=F1.HostMNLUID left join Flora_MNL F2 ON S1.HostSp=F2.HostMNLUID left join Flora_MNL F3 ON S1.HostSSp=F3.HostMNLUID left join Flora_MNL F4 ON S1.HostF=F4.HostMNLUID left join SubDiv SD on L1.SubDivUID=SD.SubDivUID left join StateProv SP on SD.StateProvUID=SP.StateProvUID left join colevent CE on S1.ColEventUID=CE.ColEventUID left join Collector C1 on CE.Collector=C1.CollectorUID left join Country CN on SP.CountryUID=CN.UID left join HostCommonName HC on S1.HostCName=HC.CommonUID where T2.TaxName not like '%#%' and T2.TaxName not like '%sp.%'and T2.TaxName != 'sp' and T2.TaxName !='sp,' and T2.TaxName not like '%\_%' and T2.TaxName not like '%spp.%' and T2.TaxName not like '%undetermined%'and T2.TaxName != 'unknown' and DLat != '0.00000' and L1.LocalityStr !='unknown' and (CN.UID = '2' or CN.UID = '8' or CN.UID = '11') and (S1.Subfamily = '6295' or S1.Subfamily = '8150' or S1.Subfamily = '6294' or S1.Subfamily = '8163') and S1.species='$species_id'");
		if (PEAR::isError($resultsCount)) {
			error_log("DB Error - Invalid query for locality_counts");
			exit;
		}
		while ($row =& $resultsCount->fetchRow()){
			$counts = $row[0];
		}
		return $counts;	
}
	//number of collecting events defined by host plant
function collecting_counts($host_species_id,$species_id)	{
		global $DB;
		$resultsCount = $DB->query("Select count(distinct S1.ColEventUID) from Specimen S1 left join MNL T1  ON S1.Genus = T1.MNLUID left join MNL T2  ON S1.Species = T2.MNLUID left join MNL T3 ON S1.Tribe=T3.MNLUID left join MNL T4 on S1.Subfamily=T4.MNLUID left join MNL T5 on T4.ParentID=T5.MNLUID left join Locality L1 on S1.Locality=L1.LocalityUID left join Flora_MNL F1 ON S1.HostG=F1.HostMNLUID left join Flora_MNL F2 ON S1.HostSp=F2.HostMNLUID left join Flora_MNL F3 ON S1.HostSSp=F3.HostMNLUID left join Flora_MNL F4 ON S1.HostF=F4.HostMNLUID left join SubDiv SD on L1.SubDivUID=SD.SubDivUID left join StateProv SP on SD.StateProvUID=SP.StateProvUID left join colevent CE on S1.ColEventUID=CE.ColEventUID left join Collector C1 on CE.Collector=C1.CollectorUID left join Country CN on SP.CountryUID=CN.UID left join HostCommonName HC on S1.HostCName=HC.CommonUID where T2.TaxName not like '%#%' and T2.TaxName not like '%sp.%'and T2.TaxName != 'sp' and T2.TaxName !='sp,' and T2.TaxName not like '%\_%' and T2.TaxName not like '%spp.%' and T2.TaxName not like '%undetermined%'and T2.TaxName != 'unknown' and DLat != '0.00000' and L1.LocalityStr !='unknown' and (CN.UID = '2' or CN.UID = '8' or CN.UID = '11') and (S1.Subfamily = '6295' or S1.Subfamily = '8150' or S1.Subfamily = '6294' or S1.Subfamily = '8163') and S1.species='$species_id' and S1.HostSp='$host_species_id'");
			if (PEAR::isError($resultsCount)) {
				error_log("DB Error - Invalid query for collecting_counts");
				exit;
			}
			while ($row =& $resultsCount->fetchRow()){
				$counts = $row[0];
			}
			return $counts;
		}
		
		//all specimens for a given species
function all_distinct_counts($species_id)	{
		global $DB;
		$resultsCount = $DB->query("Select count(distinct S1.SpecimenUID) from Specimen S1 left join MNL T1  ON S1.Genus = T1.MNLUID left join MNL T2  ON S1.Species = T2.MNLUID left join MNL T3 ON S1.Tribe=T3.MNLUID left join MNL T4 on S1.Subfamily=T4.MNLUID left join MNL T5 on T4.ParentID=T5.MNLUID left join Locality L1 on S1.Locality=L1.LocalityUID left join Flora_MNL F1 ON S1.HostG=F1.HostMNLUID left join Flora_MNL F2 ON S1.HostSp=F2.HostMNLUID left join Flora_MNL F3 ON S1.HostSSp=F3.HostMNLUID left join Flora_MNL F4 ON S1.HostF=F4.HostMNLUID left join SubDiv SD on L1.SubDivUID=SD.SubDivUID left join StateProv SP on SD.StateProvUID=SP.StateProvUID left join colevent CE on S1.ColEventUID=CE.ColEventUID left join Collector C1 on CE.Collector=C1.CollectorUID left join Country CN on SP.CountryUID=CN.UID left join HostCommonName HC on S1.HostCName=HC.CommonUID where T2.TaxName not like '%#%' and T2.TaxName not like '%sp.%'and T2.TaxName != 'sp' and T2.TaxName !='sp,' and T2.TaxName not like '%\_%' and T2.TaxName not like '%spp.%' and T2.TaxName not like '%undetermined%'and T2.TaxName != 'unknown' and DLat != '0.00000' and L1.LocalityStr !='unknown' and (CN.UID = '2' or CN.UID = '8' or CN.UID = '11') and (S1.Subfamily = '6295' or S1.Subfamily = '8150' or S1.Subfamily = '6294' or S1.Subfamily = '8163') and S1.species='$species_id'");
			if (PEAR::isError($resultsCount)) {
				error_log("DB Error - Invalid query for all_distinct_counts");
				exit;
			}
			while ($row =& $resultsCount->fetchRow()){
				$counts = $row[0];
			}
			return $counts;
		}

//all specimens for a collecting event		
function specimen_counts($collectingUID,$species_id)	{
		global $DB;
		$resultsCount = $DB->query("Select count(SpecimenUID) from Specimen where species='$species_id' AND ColEventUID='$collectingUID'");
			if (PEAR::isError($resultsCount)) {
				error_log("DB Error - Invalid query for specimen_counts");
				exit;
			}
			while ($row =& $resultsCount->fetchRow()){
				$counts = $row[0];
			}
			return $counts;
		}
		

$DB->disconnect();
?>