<?php
#requirments:
#1. filters: SubFamily = Mirinae(id:8150),Orthotylinae(id:6294),Phylinae(id:6295),Deraeocorinae(id:8163)
#2. geographic range: North America Country.UID = Canada(id:2),Mexico(id:8),USA(id:11)
#3.	- secondary geographic filters: StateProv.StateProvUID = Arizona(id:4),Nevada(id:45),California(id:10),Baja California(id:6),Baja California Norte(id:7),Baja California Sur(id:8),Sonora(id:79)
#4. Four or more unique localities per species
#5. insect determined to species
#6. collecting event = locality, date, plant
#great basin + big four subfamilies = 1049 species
#this script is a subset of the endemism.php script


	require_once("MDB2.php");

	// === change this to run from your database credentials ===
	require_once("../../../UniversalConnector.php");
	// === Main database connection and error handling ===
	$DB =& MDB2::connect($dsn);
	if (PEAR::isError($DB)) { handleError($DB->getMessage()); }
	
	$dp = fopen('stateCheck.txt', 'w');
	
	$value = insects();	
		$countingNumber = 0;
		$matrixOutputValue = '';
		while ($row =& $value->fetchRow()){
			$Genus = $row[1];
			$Species = $row[2];
			$species_id = $row[3];
			$event_score = $row[0];
			

				If ($event_score >= 2){
					echo $Genus ."\t" . $Species . "\t" . $event_score . "\n";
					$matrixOutputValue .= matrixOutput($species_id,$countingNumber,$Genus,$Species);
	
				}

		}
		

		
	fwrite($dp, $matrixOutputValue);


function matrixOutput($species_id,$countingNumber,$Genus,$Species){
				global $DB;
				$matrixOutputValue = $DB->query("Select distinct L1.DLat,L1.DLong,SP.StateProv FROM Specimen S1 left join MNL T1 ON S1.Genus = T1.MNLUID left join MNL T2  ON S1.Species = T2.MNLUID left join MNL T3 ON S1.Tribe=T3.MNLUID left join MNL T4 on S1.Subfamily=T4.MNLUID left join MNL T5 on T4.ParentID=T5.MNLUID left join Locality L1 on S1.Locality=L1.LocalityUID left join Flora_MNL F1 ON S1.HostG=F1.HostMNLUID left join Flora_MNL F2 ON S1.HostSp=F2.HostMNLUID left join Flora_MNL F3 ON S1.HostSSp=F3.HostMNLUID left join Flora_MNL F4 ON S1.HostF=F4.HostMNLUID left join SubDiv SD on L1.SubDivUID=SD.SubDivUID left join StateProv SP on SD.StateProvUID=SP.StateProvUID left join colevent CE on S1.ColEventUID=CE.ColEventUID left join Collector C1 on CE.Collector=C1.CollectorUID left join Country CN on SP.CountryUID=CN.UID where T2.TaxName not like '%#%' and T2.TaxName not like '%sp.%'and T2.TaxName != 'sp' and T2.TaxName not like '%nr.%' and T2.TaxName !='sp,' and T2.TaxName not like '%\_%' and T2.TaxName not like '%spp.%' and T2.TaxName not like '%undetermined%'and T2.TaxName != 'unknown' and DLat != '0.00000' and L1.LocalityStr !='unknown' and (CN.UID = '2' or CN.UID = '8' or CN.UID = '11') and (S1.Subfamily = '6295' or S1.Subfamily = '8150' or S1.Subfamily = '6294' or S1.Subfamily = '8163') and S1.species='$species_id'");
				#(CN.UID = '2' or CN.UID = '8' or CN.UID = '11')
				
					if (PEAR::isError($matrixOutputValue)) {
						error_log("DB Error - Invalid query for matrixOutput");
						exit;
					}
					
					$matrix = '';
					$Dmatrix = '';
					
						while ($matrixRow =& $matrixOutputValue->fetchRow()){
							$DLat = $matrixRow[0];
							$DLong = $matrixRow[1];
							$state = $matrixRow[2];
							echo $Genus . " " . $Species . "\n";
							$Dmatrix .= $Genus . "_" . $Species . "\t" . $state . "\t" . $DLong . "\t" . $DLat . "\n";

						}
						$matrix .= $Dmatrix;
						return $matrix;
				}
	
function insects(){
	global $DB;
	#(CN.UID = '2' or CN.UID = '8' or CN.UID = '11') 
	$resultsGetName = $DB->query("Select count(distinct L1.DLat,L1.DLong),T1.TaxName as Genus, T2.TaxName as Species, T2.MNLUID as species_id FROM Specimen S1 left join MNL T1 ON S1.Genus = T1.MNLUID
left join MNL T2  ON S1.Species = T2.MNLUID left join MNL T3 ON S1.Tribe=T3.MNLUID left join MNL T4 on S1.Subfamily=T4.MNLUID left join MNL T5 on T4.ParentID=T5.MNLUID left join Locality L1 on S1.Locality=L1.LocalityUID left join Flora_MNL F1 ON S1.HostG=F1.HostMNLUID left join Flora_MNL F2 ON S1.HostSp=F2.HostMNLUID left join Flora_MNL F3 ON S1.HostSSp=F3.HostMNLUID left join Flora_MNL F4 ON S1.HostF=F4.HostMNLUID left join SubDiv SD on L1.SubDivUID=SD.SubDivUID left join StateProv SP on SD.StateProvUID=SP.StateProvUID left join colevent CE on S1.ColEventUID=CE.ColEventUID left join Collector C1 on CE.Collector=C1.CollectorUID left join Country CN on SP.CountryUID=CN.UID where T2.TaxName not like '%#%' and T2.TaxName not like '%sp.%'and T2.TaxName != 'sp' and T2.TaxName !='sp,' and T2.TaxName not like '%\_%' and T2.TaxName not like '%spp.%' and T2.TaxName not like '%nr.%' and T2.TaxName not like '%undetermined%'and T2.TaxName != 'unknown' and DLat != '0.00000' and L1.LocalityStr !='unknown' and (CN.UID = '2' or CN.UID = '8' or CN.UID = '11') and (S1.Subfamily = '6295' or S1.Subfamily = '8150' or S1.Subfamily = '6294' or S1.Subfamily = '8163') group by T2.MNLUID");
		if (PEAR::isError($resultsGetName)) {
			error_log("DB Error - Invalid query for insects");
			exit;
		}
		
		return $resultsGetName;
	}

$DB->disconnect();
?>