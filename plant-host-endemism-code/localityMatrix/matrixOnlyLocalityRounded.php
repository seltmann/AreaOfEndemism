<?php

#December 2015. Katja C. Seltmann (enicospilus@gmail.com)

#requirments:
#1. filters: SubFamily = Mirinae(id:8150),Orthotylinae(id:6294),Phylinae(id:6295),Deraeocorinae(id:8163) from AEC database sql.
#2. geographic range: North America Country.UID = Canada(id:2),Mexico(id:8),USA(id:11)
#3. Four or more unique localities per species
#4. insect determined to species
#5. for AOE database ()

	require_once("MDB2.php");

	// === change this to run from your database credentials for connecting to AOE database ===
	require_once("../../../UniversalConnector.php");
	// === Main database connection and error handling ===
	$DB =& MDB2::connect($dsn);
	
	#create output file
	$dp = fopen('forMatrixNA5_Rounded.txt', 'w');
	
	$value = insects();	
		$countingNumber = 0;
		$matrixOutputValue = '';
		while ($row =& $value->fetchRow()){
			$Genus = $row[1];
			$Species = $row[2];
			$species_id = $row[3];
			$event_score = $row[0];
			
			#selects only species that have greater or equal to 5 localities (rounded to 4 decimal places)
				If ($event_score >= 5){
					echo $Genus ."\t" . $Species . "\t" . $event_score . "\n";
					$matrixOutputValue .= matrixOutput($species_id,$countingNumber,$Genus,$Species);
					$countingNumber = $countingNumber + 1;
				}
		}
		
	#writes output
	fwrite($dp, $matrixOutputValue);

#mysql code specifically to return unique localities of Nearctic Miridae based on the requirements at the beginning of this document.
function matrixOutput($species_id,$countingNumber,$Genus,$Species){
				global $DB;
				$matrixOutputValue = $DB->query("Select distinct round(L1.DLat,3),round(L1.DLong,3) FROM Specimen S1 left join MNL T1 ON S1.Genus = T1.MNLUID left join MNL T2  ON S1.Species = T2.MNLUID left join MNL T3 ON S1.Tribe=T3.MNLUID left join MNL T4 on S1.Subfamily=T4.MNLUID left join MNL T5 on T4.ParentID=T5.MNLUID left join Locality L1 on S1.Locality=L1.LocalityUID left join Flora_MNL F1 ON S1.HostG=F1.HostMNLUID left join Flora_MNL F2 ON S1.HostSp=F2.HostMNLUID left join Flora_MNL F3 ON S1.HostSSp=F3.HostMNLUID left join Flora_MNL F4 ON S1.HostF=F4.HostMNLUID left join SubDiv SD on L1.SubDivUID=SD.SubDivUID left join StateProv SP on SD.StateProvUID=SP.StateProvUID left join colevent CE on S1.ColEventUID=CE.ColEventUID left join Collector C1 on CE.Collector=C1.CollectorUID left join Country CN on SP.CountryUID=CN.UID where T2.TaxName not like '%#%' and T2.TaxName not like '%sp.%'and T2.TaxName != 'sp' and T2.TaxName not like '%nr.%' and T2.TaxName !='sp,' and T2.TaxName not like '%\_%' and T2.TaxName not like '%spp.%' and T2.TaxName not like '%undetermined%'and T2.TaxName != 'unknown' and DLat != '0.00000' and L1.LocalityStr !='unknown' and (CN.UID = '2' or CN.UID = '8' or CN.UID = '11') and  S1.Insect_ID='1' and S1.species='$species_id'");
				
					if (PEAR::isError($matrixOutputValue)) {
						error_log("DB Error - Invalid query for matrixOutput");
						exit;
					}
					
					$matrix = '';
					$Dmatrix = '';
					
						while ($matrixRow =& $matrixOutputValue->fetchRow()){
							$DLat = $matrixRow[0];
							$DLong = $matrixRow[1];
							echo "[" . $countingNumber . "]" . $Genus . " " . $Species . "\n";
							$Dmatrix .= "$DLong" . "\t" . "$DLat" . "\n";

						}
						$matrix .= "sp " . $countingNumber . " ";
						$matrix .= "[" . $Genus . " " . $Species . "]" . "\n" . $Dmatrix .  "\n";
						return $matrix;
				}
	
function insects(){
	global $DB;

	$resultsGetName = $DB->query("Select count(distinct round(L1.DLat,3),round(L1.DLong,3)),T1.TaxName as Genus, T2.TaxName as Species, T2.MNLUID as species_id FROM Specimen S1 left join MNL T1 ON S1.Genus = T1.MNLUID
left join MNL T2  ON S1.Species = T2.MNLUID left join MNL T3 ON S1.Tribe=T3.MNLUID left join MNL T4 on S1.Subfamily=T4.MNLUID left join MNL T5 on T4.ParentID=T5.MNLUID left join Locality L1 on S1.Locality=L1.LocalityUID left join Flora_MNL F1 ON S1.HostG=F1.HostMNLUID left join Flora_MNL F2 ON S1.HostSp=F2.HostMNLUID left join Flora_MNL F3 ON S1.HostSSp=F3.HostMNLUID left join Flora_MNL F4 ON S1.HostF=F4.HostMNLUID left join SubDiv SD on L1.SubDivUID=SD.SubDivUID left join StateProv SP on SD.StateProvUID=SP.StateProvUID left join colevent CE on S1.ColEventUID=CE.ColEventUID left join Collector C1 on CE.Collector=C1.CollectorUID left join Country CN on SP.CountryUID=CN.UID where T2.TaxName not like '%#%' and T2.TaxName not like '%sp.%'and T2.TaxName != 'sp' and T2.TaxName !='sp,' and T2.TaxName not like '%\_%' and T2.TaxName not like '%spp.%' and T2.TaxName not like '%nr.%' and T2.TaxName not like '%undetermined%'and T2.TaxName != 'unknown' and DLat != '0.00000' and L1.LocalityStr !='unknown' and (CN.UID = '2' or CN.UID = '8' or CN.UID = '11') and S1.Insect_ID='2' group by T2.MNLUID");
		if (PEAR::isError($resultsGetName)) {
			error_log("DB Error - Invalid query for insects");
			exit;
		}
		
		return $resultsGetName;
	}

$DB->disconnect();
?>
