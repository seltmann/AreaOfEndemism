<?php
#requirments:
#2. geographic range: North America Country.UID = Canada(id:2),Mexico(id:8),USA(id:11)
#3.	- secondary geographic filters: StateProv.StateProvUID = Arizona(id:4),Nevada(id:45),California(id:10),Baja California(id:6),Baja California Norte(id:7),Baja California Sur(id:8),Sonora(id:79)
#4. Four or more unique localities per species
#5. plants determined to species and associated with insects
#6. collecting event = unique rounded lat/long (could improve this)
#TODO issues with reversed lat/long and botanical garden. Delete, map by species?


	require_once("MDB2.php");

	// === change this to run from your database credentials ===
	#require_once("../../UniversalConnector.php");
	require_once("../../../../UniversalConnector.php");
	// === Main database connection and error handling ===
	$DB =& MDB2::connect($dsn);
	#if (PEAR::isError($DB)) { handleError($DB->getMessage()); }
	
	$dp = fopen('forMatrixPlantRounded.txt', 'w');
	
	$value = plants();	
		$countingNumber = 0;
		$matrixOutputValue = '';
		while ($row =& $value->fetchRow()){
			$Genus = $row[1];
			$Species = $row[2];
			$scientificName = ucfirst($row[3]);
			$event_score = $row[0];
			

				If ($event_score >= 5){
					echo $Genus ."\t" . $Species . "\t" . $event_score . "\n";
					$matrixOutputValue .= matrixOutput($scientificName,$countingNumber,$Genus,$Species);
					$countingNumber = $countingNumber + 1;
	
				}

		}
		

		
	fwrite($dp, $matrixOutputValue);


function matrixOutput($scientificName,$countingNumber,$Genus,$Species){
				global $DB;
				$matrixOutputValue = $DB->query("Select distinct round(decimalLatitude,3),round(decimalLongitude,3) FROM planthosts where genus='$Genus' and specificEpithet='$Species'");

				
					if (PEAR::isError($matrixOutputValue)) {
						error_log("DB Error - Invalid query for matrixOutput");
						exit;
					}
					
					$matrix = '';
					$Dmatrix = '';
					
						while ($matrixRow =& $matrixOutputValue->fetchRow()){
							$DLat = $matrixRow[0];
							$DLong = $matrixRow[1];
							echo "[" . $countingNumber . "]" . $scientificName . "\n";
							$Dmatrix .= "$DLong" . "\t" . "$DLat" . "\n";

						}
						$matrix .= "sp " . $countingNumber . " ";
						$matrix .= "[" . $scientificName . "]" . "\n" . $Dmatrix .  "\n";
						return $matrix;
				}
	
function plants(){
	global $DB;

	$resultsGetName = $DB->query("Select count(distinct round(decimalLatitude,3),round(decimalLongitude,3)),genus as Genus, specificEpithet as Species, concat(genus,' ',specificEpithet) as scientificName FROM planthosts group by concat(genus,specificEpithet)");
		if (PEAR::isError($resultsGetName)) {
			error_log("DB Error - Invalid query for plants");
			exit;
		}
		
		return $resultsGetName;
	}

$DB->disconnect();
?>
