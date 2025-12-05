<?php
function includeClass($class, $libPath = null) {
    static $classes = array();
    if (isset($classes[$class]))
        return;

    $class = ucfirst($class);
    if (is_null($libPath)) {
        $libPath = dirname(__FILE__) . '/mt940/';
    }
    $explodedClass = explode('_', $class);
    $fistClassPart = array_shift($explodedClass);
    $classFileName = $libPath . implode(DIRECTORY_SEPARATOR, array_reverse($explodedClass)) . DIRECTORY_SEPARATOR
        . lcfirst($fistClassPart) . '.php';
    $classes[$class] = is_readable($classFileName);
    if ($classes[$class]) {
        require $classFileName;
    } else {
        trigger_error('Class ' . $class . ' could not be imported into the scope when looking in ' . $classFileName, E_USER_ERROR);
    }
}

includeClass('statement_banking');
includeClass('transaction_banking');
includeClass('banking_parser');
includeClass('Mt940_banking_parser');
includeClass('Engine_mt940_banking_parser');

if (isset($_FILES['mt940'])) {
    header("Content-type: text/csv");
    header("Content-Disposition: attachment; filename=file.csv");
    header("Pragma: no-cache");
    header("Expires: 0");
    // instantiate the actual parser
    // and parse them from a given file, this could be any file or a posted string
    $parser = new Mt940_banking_parser();
    $tmpFile = $_FILES['mt940']['tmp_name'];
    $parsedStatements = $parser->parse(file_get_contents($tmpFile));
    //var_dump($parsedStatements);
    $output = fopen('php://output', 'w');
    fputcsv($output, array(
        'SBANK','SACCOUNT','TACCOUNT','TACCOUNTNAME','TPRICE','TDEBITCREDIT','TDESCRIPTION',
        'TVALUETIMESTAMP','TENTRYTIMESTAMP','SSTARTPRICE','SENDPRICE','STIMESTAMP','SNUMBER'
    ));
    foreach ($parsedStatements as $statement) {
        //var_dump($statement);
        $transactions = $statement->getTransactions();
        //var_dump($transactions);
        foreach ($transactions as $transaction) {
            fputcsv($output, array(
                $statement->bank,
                $statement->account,
                $transaction->account,
                $transaction->accountName,
                $transaction->price,
                $transaction->debitcredit,
                $transaction->description,
                $transaction->valueTimestamp,
                $transaction->entryTimestamp,
                $transaction->transactionCode,
                $statement->startPrice,
                $statement->endPrice,
                $statement->timestamp,
                $statement->number
            ));
        }
    }
}
if(!isset($_FILES['mt940'])):
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>MT940 Uploader</title>
    </head>

    <body>
        <div class="wrapper">
            <form method="POST" action="index.php" enctype="multipart/form-data">
                <label for="mt940">Select Mt940</label>
                <input type="file" name="mt940" id="mt940" />
                <input type="submit" value="Convert to CSV" />
            </form>
        </div>
    </body>
</html>
<?php endif; ?>