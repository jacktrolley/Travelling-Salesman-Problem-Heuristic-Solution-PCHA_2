<?php
session_start();
ini_set('memory_limit', '1024M');     
ini_set('max_execution_time', 10800);  
?>


<html>
<body>
<pre>


<?php

$no_of_vertices = $_SESSION['num_of_vertices'];
$array_of_vertices = $_SESSION['array_of_vertices'];



for($i=0;$i<$no_of_vertices;$i++)
{
for($j=0;$j<$no_of_vertices;$j++)
{
if($j!=$i)
{
$tmp = 'weight_'.$array_of_vertices[$i]."_".$array_of_vertices[$j];
$edge_name = $array_of_vertices[$i].",".$array_of_vertices[$j];
$edge_weight[$edge_name] = trim($_POST[$tmp]);


$input_pattern='/^[1-9]{1}[0-9]*$/';
$input_count = preg_match_all($input_pattern,trim($_POST[$tmp]));
if($input_count == 0)
{
echo"<br/>STOPPING SCRIPT DUE TO ERROR OF SOME MISSING WEIGHT VALUES NOT BEING TYPED IN THE PREVIOUS PAGE FORM. ALSO PLEASE NOTE TO TYPE IN ONLY POSITIVE INTEGER NUMBERS FOR WEIGHT VALUES. ALSO NO WEIGHTS SHOULD HAVE A VALUE OF 0<br/>";
echo"<br/>PLEASE GO BACK TO THE PREVIOUS PAGE AND TYPE IN THE CORRECT VALUES.<br/>";
exit();
}


}
}
}



$edge_weight_chunk = array_chunk($edge_weight,($no_of_vertices-1),true);


for($i=0;$i<$no_of_vertices;$i++)
{
asort($edge_weight_chunk[$i]);
$vertex_nm_edge_nm_weights[$array_of_vertices[$i]] = $edge_weight_chunk[$i];
}


$first_splitted_circuit_array = array();
$second_splitted_circuit_array = array();


foreach($array_of_vertices as $key=>$value)
{

foreach($vertex_nm_edge_nm_weights[$value] as $key_1=>$value_1)
{
$vertex_name[$value][$key_1] = $value_1;	
}

	
}


unset($tmp_circuit_array);
$tmp_circuit_array = array();


if($no_of_vertices%2 == 0)     
{
	
$count = 0;

foreach( $array_of_vertices as $key=>$value )  
{


unset($first_splitted_circuit_array);
unset($second_splitted_circuit_array);


$first_splitted_circuit_array[] = $value;  
$second_splitted_circuit_array[] = $value; 


$j=0;
foreach($vertex_name[$value] as $key_1=>$value_1)   
{

if($j==2)
{
break;	
}

unset($tmp_array);    
$tmp_array = array();

$tmp_array =  explode(",",$key_1);

if($j==0)
{	
$first_splitted_circuit_array[] = $tmp_array[1];
}

if($j==1)
{
$second_splitted_circuit_array[] = $tmp_array[1];
}

++$j;
	
}


$last_index_of_array = floor($no_of_vertices/2);   


for( $i=1 ; $i<=($last_index_of_array-1) ; $i++ )  
{
	
if($i == ($last_index_of_array - 1)	)  
{
unset($tmp_combined_array);
$tmp_combined_array = array();

foreach($first_splitted_circuit_array as $key_8=>$value_8)
{
$tmp_combined_array[] = $value_8;	
}

foreach($second_splitted_circuit_array as $key_9=>$value_9)
{
$tmp_combined_array[] = $value_9;	
}


unset($tmp_combined_array_1);
$tmp_combined_array_1 = array();

$tmp_combined_array_1 = array_unique($tmp_combined_array);

unset($missing_vertex);

$missing_vertex = array_diff($array_of_vertices,$tmp_combined_array_1);

if(count($missing_vertex) == 1)
{

foreach($missing_vertex as $key_10=>$value_10)
{
$first_splitted_circuit_array[] = $value_10;
}

	
}
else
{
}

break;	
}
	

unset($combined_array);
$combined_array = array();

$tmp_vertex_1 = $first_splitted_circuit_array[$i];	
$tmp_vertex_2 = $second_splitted_circuit_array[$i];


foreach($vertex_name[$tmp_vertex_1] as $key_2=>$value_2)
{
$combined_array[$key_2]	= $value_2;
}

foreach($vertex_name[$tmp_vertex_2] as $key_3=>$value_3)
{
$combined_array[$key_3]	= $value_3;
}


asort($combined_array);


$m=0; 
$first_circuit_added = 0;
$second_circuit_added = 0;

foreach($combined_array as $key_4=>$value_4)
{

if($m==2)
{
break;	
}

unset($tmp_array);
$tmp_array = explode(",",$key_4);

if( in_array($tmp_array[1],$first_splitted_circuit_array) || in_array($tmp_array[1],$second_splitted_circuit_array) )
{
continue;	
}
else
{

if( in_array($tmp_array[0],$first_splitted_circuit_array) and ($first_circuit_added == 0) )  
{
$first_splitted_circuit_array[] = $tmp_array[1];
$first_circuit_added = 1;
++$m;	
}

if( in_array($tmp_array[0],$second_splitted_circuit_array) and  ($second_circuit_added == 0) )
{
$second_splitted_circuit_array[] = $tmp_array[1];
$second_circuit_added = 1;
++$m;	
}
	
}

	
}


	
}


unset($tmp_array_1);
unset($tmp_array_2);


$tmp_array_1 = array_reverse($second_splitted_circuit_array);

foreach($first_splitted_circuit_array as $key_5=>$value_5)
{
$tmp_array_2[] = $value_5;	
}

foreach($tmp_array_1 as $key_7=>$value_7)
{
$tmp_array_2[] = $value_7;	
}


$tmp_string_3 = implode(",",$tmp_array_2);



$tmp_circuit_string[] = $tmp_string_3;    

 
++$count;
	
} 


foreach($tmp_circuit_string as $key=>$value)
{
$total_weight_of_circuit = 0;
unset($tmp_circuit_array);

$tmp_circuit_string = $value;
$tmp_circuit_array = explode(",",$tmp_circuit_string);

for($i=0;$i<$no_of_vertices;$i++)
{
$j=$i+1;
$tmp_edge = $tmp_circuit_array[$i].",".$tmp_circuit_array[$j];
$total_weight_of_circuit = $total_weight_of_circuit + $edge_weight[$tmp_edge];
}

$final_circuit_name_weight[$value] = $total_weight_of_circuit;   

}

asort($final_circuit_name_weight);

$i=0;
foreach($final_circuit_name_weight as $key=>$value)
{
if($i == 1)
{
break;
}
echo "<br><br>";

unset($tmp_key);

$tmp_key = explode(",",$key);
$tmp_count = count($tmp_key);

echo "THE HAMILTON CIRCUIT WHICH PROBABLY MIGHT HAVE MINIMUM WEIGHT IS : <br/><br/>";

for($m=0;$m<$tmp_count;$m++)   
{
if($m == ($tmp_count - 1))
{
echo "&nbsp&nbsp".$tmp_key[$m]."&nbsp&nbsp";
break;
}
echo "&nbsp&nbsp".$tmp_key[$m]."&nbsp&nbsp".",";
}

echo "<br/><br/>THE ABOVE HAMILTON CIRCUIT HAS A TOTAL WEIGHT OF ".$value.".";

echo "<br><br>";
++$i;
}





	
} 



if($no_of_vertices%2 != 0)    
{
	
$count = 0;

foreach( $array_of_vertices as $key=>$value )  // first part
{


unset($first_splitted_circuit_array);
unset($second_splitted_circuit_array);


$first_splitted_circuit_array[] = $value;  
$second_splitted_circuit_array[] = $value; 



$j=0;
foreach($vertex_name[$value] as $key_1=>$value_1)   
{

if($j==2)
{
break;	
}

unset($tmp_array);   
$tmp_array = array();

$tmp_array =  explode(",",$key_1);


if($j==0)
{	
$first_splitted_circuit_array[] = $tmp_array[1];
}

if($j==1)
{
$second_splitted_circuit_array[] = $tmp_array[1];	
}

++$j;

}


$last_index_of_array = floor($no_of_vertices/2);   


for( $i=1 ; $i<=$last_index_of_array ; $i++ )  
{

unset($combined_array);
$combined_array = array();

$tmp_vertex_1 = $first_splitted_circuit_array[$i];	
$tmp_vertex_2 = $second_splitted_circuit_array[$i];


foreach($vertex_name[$tmp_vertex_1] as $key_2=>$value_2)
{
$combined_array[$key_2]	= $value_2;
}

foreach($vertex_name[$tmp_vertex_2] as $key_3=>$value_3)
{
$combined_array[$key_3]	= $value_3;
}


asort($combined_array);


$m=0;  
$first_circuit_added = 0;
$second_circuit_added = 0;

foreach($combined_array as $key_4=>$value_4)
{

if($m==2)
{
break;	
}

unset($tmp_array);
$tmp_array = explode(",",$key_4);

if( in_array($tmp_array[1],$first_splitted_circuit_array) || in_array($tmp_array[1],$second_splitted_circuit_array) )
{
continue;	
}
else
{

if( in_array($tmp_array[0],$first_splitted_circuit_array) and ($first_circuit_added == 0) )  
{
$first_splitted_circuit_array[] = $tmp_array[1];
$first_circuit_added = 1;
++$m;	
}

if( in_array($tmp_array[0],$second_splitted_circuit_array) and ($second_circuit_added == 0) )
{
$second_splitted_circuit_array[] = $tmp_array[1];
$second_circuit_added = 1;
++$m;	
}
	
}

	
}


	
}

unset($tmp_array_1);
unset($tmp_array_2);

$tmp_array_1 = array_reverse($second_splitted_circuit_array);

foreach($first_splitted_circuit_array as $key_5=>$value_5)
{
$tmp_array_2[] = $value_5;	
}

foreach($tmp_array_1 as $key_7=>$value_7)
{
$tmp_array_2[] = $value_7;	
}


$tmp_string_3 = implode(",",$tmp_array_2);



$tmp_circuit_string[] = $tmp_string_3;  

 
++$count;
	
}


foreach($tmp_circuit_string as $key=>$value)
{
$total_weight_of_circuit = 0;
unset($tmp_circuit_array);

$tmp_circuit_string = $value;
$tmp_circuit_array = explode(",",$tmp_circuit_string);

for($i=0;$i<$no_of_vertices;$i++)
{
$j=$i+1;
$tmp_edge = $tmp_circuit_array[$i].",".$tmp_circuit_array[$j];
$total_weight_of_circuit = $total_weight_of_circuit + $edge_weight[$tmp_edge];
}

$final_circuit_name_weight[$value] = $total_weight_of_circuit;   

}

asort($final_circuit_name_weight);


$i=0;
foreach($final_circuit_name_weight as $key=>$value)
{
if($i == 1)
{
break;
}
echo "<br><br>";

unset($tmp_key);

$tmp_key = explode(",",$key);
$tmp_count = count($tmp_key);

echo "THE HAMILTON CIRCUIT WHICH PROBABLY MIGHT HAVE MINIMUM WEIGHT IS : <br/><br/>";

for($m=0;$m<$tmp_count;$m++)   
{
if($m == ($tmp_count - 1))
{
echo "&nbsp&nbsp".$tmp_key[$m]."&nbsp&nbsp";
break;
}
echo "&nbsp&nbsp".$tmp_key[$m]."&nbsp&nbsp".",";
}

echo "<br/><br/>THE ABOVE HAMILTON CIRCUIT HAS A TOTAL WEIGHT OF ".$value.".";

echo "<br><br>";
++$i;
}


	
}

	

?>

</pre>
</body>
</html>




