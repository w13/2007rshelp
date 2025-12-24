<?php
mysql_connect("localhost", "rsc", "heyplants44") or die(mysql_error());
mysql_select_db("rsc_site") or die(mysql_error());


//Update function
function updateEXP($rs,$skill)
{
$curl = curl_init('http://services.runescape.com/m=hiscore/index_lite.ws?player='.$rs);
curl_setopt($curl, CURLOPT_FAILONERROR, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);  
$result = curl_exec($curl);

//Set the Skill
		$skills = array('Overall', 'Attack', 'Defence', 'Strength', 'Hitpoints', 'Ranged', 'Prayer', 'Magic', 'Cooking', 'Woodcutting', 'Fletching', 'Fishing', 'Firemaking', 'Crafting', 'Smithing', 'Mining', 'Herblore', 'Agility', 'Thieving', 'Slayer', 'Farming', 'Runecraft', 'Hunter', 'Construction', 'Summoning', 'Dugeoneering', 'Divination');

$stats = explode("\n",$result); //set each skill as a new line
        // Loop through the skills                              
        for($i = 0; $i<count($skills);$i++) {                                      
                                        // Explode each skill into 3 values - rank, level, exp                                          
                                        $stat = explode(',', $stats[$i]);
                                        $out[$skills[$i]] = Array();
                                        $out[$skills[$i]]['rank'] = $stat[0];
                                        $out[$skills[$i]]['level'] = $stat[1];
                                        $out[$skills[$i]]['xp'] = $stat[2];
}

$expp = $out[$skill]['xp'];
return $expp;
}

  //Start Skill 1 update
$result1 = mysql_query("SELECT * FROM bonusexp") or die(mysql_error());    
while($row = mysql_fetch_array( $result1 )) {

$testtt = updateEXP($row['rsname'],"Construction");
$namme = $row['rsname'];

//mysql_query("UPDATE bonusexp SET startexp=$testtt WHERE rsname='$namme'"); 
mysql_query("UPDATE magicexp SET conexp=$testtt WHERE rsname='$namme'"); 
  echo "Updated ". $row['rsname'] . "-" . $testtt ."<br />";
  }
  //Start Skill 1 update
$result1 = mysql_query("SELECT * FROM bonusexp") or die(mysql_error());    
while($row = mysql_fetch_array( $result1 )) {

$testtt = updateEXP($row['rsname'],"Summoning");
$namme = $row['rsname'];

//mysql_query("UPDATE bonusexp SET startexp=$testtt WHERE rsname='$namme'"); 
mysql_query("UPDATE bonusexp SET summonexp=$testtt WHERE rsname='$namme'"); 
  echo "Updated ". $row['rsname'] . "-" . $testtt ."<br />";
  }
 
  
   //Start Skill 1 update
$result1 = mysql_query("SELECT * FROM bonusexp") or die(mysql_error());    
while($row = mysql_fetch_array( $result1 )) {

$testtt = updateEXP($row['rsname'],"Dungeoneering");
$namme = $row['rsname'];

//mysql_query("UPDATE bonusexp SET startexp=$testtt WHERE rsname='$namme'"); 
mysql_query("UPDATE bonusexp SET dungexp=$testtt WHERE rsname='$namme'"); 
  echo "Updated ". $row['rsname'] . "-" . $testtt ."<br />";
  }
  
  
    //Start Skill 1 update
$result1 = mysql_query("SELECT * FROM bonusexp") or die(mysql_error());    
while($row = mysql_fetch_array( $result1 )) {

$testtt = updateEXP($row['rsname'],"Divination");
$namme = $row['rsname'];

//mysql_query("UPDATE bonusexp SET startexp=$testtt WHERE rsname='$namme'"); 
mysql_query("UPDATE bonusexp SET diveexp=$testtt WHERE rsname='$namme'"); 
  echo "Updated ". $row['rsname'] . "-" . $testtt ."<br />";
  }