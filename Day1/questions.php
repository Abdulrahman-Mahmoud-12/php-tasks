<?php

// ! Q1 ! //
echo "Welcome to php<br><br>";

// ! Q2 ! //
$x = 5;
$y = 'Welcome ';
$z = True;

// ! Q3 ! //
echo "<strong>Types of Variables:</strong><br>";
echo "Type of \$x: " . gettype($x) . "<br>"; // integer
echo "Type of \$y: " . gettype($y) . "<br>"; // string
echo "Type of \$z: " . gettype($z) . "<br><br>"; // boolean

// ! Q4 ! //
echo "<strong>Numbers 0 to 15 (Method 1 - For Loop):</strong><br>";
for ($i = 0; $i <= 15; $i++) {
    echo $i . " ";
}
echo "<br><br>";

echo "<strong>Numbers 0 to 15 (Method 2 - While Loop):</strong><br>";
$j = 0;
while ($j <= 15) {
    echo $j . " ";
    $j++;
}
echo "<br><br>";

// ! Q5 ! //
define("INSTITUTE", "ITI");
echo "<strong>Constant Value:</strong> " . INSTITUTE . "<br><br>";

// ! Q6 ! //
echo "<strong>Isset Check:</strong><br>";
echo "isset(\$x): "; var_dump(isset($x)); echo "<br>";
echo "isset(\$y): "; var_dump(isset($y)); echo "<br>";
echo "isset(\$z): "; var_dump(isset($z)); echo "<br><br>";

// ! Q7 ! //
echo "<strong>Empty Check:</strong><br>";
echo "empty(\$x): "; var_dump(empty($x)); echo "<br>";
echo "empty(\$y): "; var_dump(empty($y)); echo "<br>";
echo "empty(\$z): "; var_dump(empty($z)); echo "<br><br>";

// ! Q8 ! //
echo "<strong>Condition Check:</strong><br>";
$m = 30;
$n = 25;
$result = $m + $n;
if ($result > 50) {
    echo "Accepted<br><br>";
} else {
    echo "Not accepted<br><br>";
}

// ! Q9 ! //
echo "<strong>Salary Table:</strong><br>";
echo "<table border='1' style='border-collapse: collapse; text-align: left; padding: 5px;'>";
echo "<tbody>";
echo "<tr><td style='color: blue; padding: 5px;'>Salary of Mr. A is</td><td style='padding: 5px;'>1000$</td></tr>";
echo "<tr><td style='color: blue; padding: 5px;'>Salary of Mr. B is</td><td style='padding: 5px;'>1200$</td></tr>";
echo "<tr><td style='color: blue; padding: 5px;'>Salary of Mr. C is</td><td style='padding: 5px;'>1400$</td></tr>";
echo "</tbody>";
echo "</table><br><br>";

// ! Q10 ! //
echo "<strong>numberToString Function:</strong><br>";
function numberToString($num) {
    return (string) $num; 
}
$str1 = numberToString(123);
$str2 = numberToString(999);
echo var_dump($str1) . " // returns '123'<br>";
echo var_dump($str2) . " // returns '999'<br>";

?>