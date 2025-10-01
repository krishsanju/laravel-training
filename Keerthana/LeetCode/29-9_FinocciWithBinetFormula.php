<?php 
$position = (int)readline("Enter the position you want to know in Fibnocci starting from 0: ");
$sqrtOf5 = sqrt(5);

$g = pow((1+$sqrtOf5)/2,$position);
$e = pow((1-$sqrtOf5)/2,exponent: $position);

echo ((1/$sqrtOf5)*$g) - ((1/$sqrtOf5)*$e);

?>