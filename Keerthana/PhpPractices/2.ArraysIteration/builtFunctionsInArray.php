<?php
    $array1 = [12,45,78];
    $array2 = array(23,45,67,89,12);
    $mergeArray = array_merge($array1, $array2);
    $recursiveMerge = array_merge_recursive($array1, $array2);

    echo 'LENGTH OF ARR1: ' . count($array1) . "\n";
    echo 'LENGTH OF ARR2: ' . sizeof($array2) . "\n";
    echo 'MERGE ARRAYS: '; print_r($mergeArray);
    echo "ELEMENTS IN ARR1 NOT IN ARR2 " ;print_r(array_diff($array1, $array2)); //elements in array1 not in array2
    echo "ELEMENTS IN ARR2 NOT IN ARR1 " ;print_r(array_diff($array2, $array1));
    echo "COMMON ELEMENTS IN BOTH ARRAYS: "; print_r(array_intersect($array1, $array2));
    echo "SORTED ARRAY: "; sort($mergeArray); print_r($mergeArray); 
    echo "POP: "; array_pop($array1); print_r($array1);
    echo "PUSH: "; array_push($array1, 78,34); print_r($array1);
    echo "SHIFT:(returns the 1st ele) "; print_r(array_shift($array1). "\n"); print_r($array1);
    echo "UNSHIFT:(returns no. of elements in new array) "; print_r(array_unshift($array1, 12). "\n"); print_r($array1);
    echo "SLICE: "; print_r(array_slice($mergeArray, 5));
    echo "TEMPORARY REPLACE: "; print_r(array_replace( [1,2,3,4,5,6,7,8], $array1));
    // print_r($array1);
    echo "SEARCH (returns index): "; print_r(array_search('45', $array1));echo "\n"; 
    echo "SUM: "; echo (array_sum($array1)); echo "\n";
    echo "INTERSECTION: "; print_r(array_intersect($array1, $array2));
    echo "UNIQUE: "; print_r(array_unique([1,2,1,3,4,3,5]));
    echo "SPLIT ARRAY INTO n CHUNKS: "; print_r(array_chunk($mergeArray, 3)); 




// // Function                          | Sorts By        | Order                    
// // `sort()`                          | Value           | Ascending                  
// // `rsort()`                         | Value           | Descending                 
// // `asort()`                         | Value           | Ascending                  
// // `arsort()`                        | Value           | Descending                 
// // `ksort()`                         | Key             | Ascending                  
// // `krsort()`                        | Key             | Descending                 
// // `usort()`                         | +Value          | Custom                     
// // `uasort()`                        | Value           | Custom                     
// // `uksort()`                        | Key             | Custom                     
// // `natsort()`                       | Value           | Natural                    
// // `natcasesort()`                   | Value           | Natural (case-insensitive) 
// // `array_multisort()`               | Multiple arrays | Mixed                      
// // `locale_compare()` or `strcoll()` | Value           | Locale-aware               

    $stringArray = ['sri', 'kumar', 'reddy', 'neethu', 'teja', 'nani', 'vasu', 'chaitu'];
    echo 'UPPER CASE: '; print_r(array_map('strtoupper', $stringArray));
    echo 'LOWER CASE: '; print_r(array_map('strtolower', $stringArray));
    echo 'REVERSE: '; print_r(array_reverse($stringArray));
    echo 'COMNINE NUMBER ARRAY WITH STRING ARRAY AS KEY-VALUES: '; print_r(array_combine($stringArray, $mergeArray));

    $fillArray = array_fill(3,6,'blue');
    echo 'FILL ARRAY: '; print_r($fillArray);
    $keyArray = ['a','b','c','d','e','f'];
    echo 'FILL KEY ARRAY ';print_r(array_fill_keys($keyArray, 'black'));


    $age = array("Peter"=>"35","Ben"=>"37","Joe"=>"43");
    echo "GET KEYS: "; print_r(array_keys($age));
    echo "GET VALUES: "; print_r(array_values($age));
    echo 'LOWER KEY CASE: '; print_r(array_change_key_case($age, CASE_LOWER));
    echo 'UPPER KEY CASE: '; print_r(array_change_key_case($age, CASE_UPPER));


    $multiDimensionArray = array(
            array(
                'id' => 5698,
                'first_name' => 'Peter',
                'last_name' => 'Griffin',
            ),
            array(
                'id' => 4767,
                'first_name' => 'Ben',
                'last_name' => 'Smith',
            ),
            array(
                'id' => 3809,
                'first_name' => 'Joe',
                'last_name' => 'Doe',
            )
    );
    echo 'COLUMN IN MULTI-DIMENSIONAL ARRAY: '; print_r(array_column($multiDimensionArray, 'id'));
    echo 'COLUMN IN MULTI-DIMENSIONAL ARRAY WITH INDEX: '; print_r(array_column($multiDimensionArray, 'first_name', 'id'));
    
?>