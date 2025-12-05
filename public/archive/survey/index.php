<?php
// Security: Sanitize all GET parameters to prevent XSS
function sanitize($input) {
    return htmlspecialchars($input ?? '', ENT_QUOTES, 'UTF-8');
}

$question_answer = sanitize($_GET["question_answer"] ?? '');
$relation_voornaam = sanitize($_GET["relation_voornaam"] ?? '');
$relation_achternaam = sanitize($_GET["relation_achternaam"] ?? '');
$relation_email = sanitize($_GET["relation_email"] ?? '');
$project_image_url = htmlspecialchars($_GET["project_image_url"] ?? '', ENT_QUOTES, 'UTF-8');
$project_street = sanitize($_GET["project_street"] ?? '');
$project_number = sanitize($_GET["project_number"] ?? '');
$project_suffix = sanitize($_GET["project_suffix"] ?? '');
$project_city = sanitize($_GET["project_city"] ?? '');
$project_price = sanitize($_GET["project_price"] ?? '');
$company_name = sanitize($_GET["company_name"] ?? '');
$employee_voornaam = sanitize($_GET["employee_voornaam"] ?? '');
$employee_achternaam = sanitize($_GET["employee_achternaam"] ?? '');
$employee_email = sanitize($_GET["employee_email"] ?? '');
?>
<h1>Antwoord is: <?=$question_answer;?></h1>
<h2>Gegeven door:</h2>
<?=$relation_voornaam;?> <?=$relation_achternaam;?><br /><?=$relation_email;?><br />
<br />
<h2>Bezichtiging van:</h2>
<img width="100" height="75" border="0" src="<?=$project_image_url;?>" alt="" /><br />
<?=$project_street;?> <?=$project_number;?> <?=$project_suffix;?><br />
<?=$project_city;?><br />
<?=$project_price;?><br />
<br />
<h3><?=$company_name;?></h3>
<?=$employee_voornaam;?> <?=$employee_achternaam;?><br /><?=$employee_email;?><br />


<?php

?>