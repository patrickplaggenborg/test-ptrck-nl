<?php

$accessSecret = "97yf92yg472fj38a839h48fjdhakfa38";  // Change this to something unique
if (!isset($_GET['secret']) || $_GET['secret'] !== $accessSecret) {
    die("<h2>Access Denied</h2>");
}

// Secret token for verifying the form submission
$secret_token = "7jy48923yct78439hdya4j8xyt73jyz";

// Make.com webhook URL
$makeWebhookURL = "https://hook.eu1.make.com/5lau779x0qtlub60i5ad5e6tckbjphr4";

// Determine the current year and month
$currentYear = date("Y");
$currentMonth = date("n");

// Create an array for the last three years (including this year)
$years = [$currentYear, $currentYear - 1, $currentYear - 2];

// Define month names
$months = [
    1 => "January",
    2 => "February",
    3 => "March",
    4 => "April",
    5 => "May",
    6 => "June",
    7 => "July",
    8 => "August",
    9 => "September",
    10 => "October",
    11 => "November",
    12 => "December"
];

// We'll store the response content in a variable and display it in the same styled container.
$responseHTML = "";
// Updated to keep your custom text changes.
// For instance, if you changed the title or the submit button.
// Adjust below as needed.

$title = "Invoice VakantieDiscounter"; // e.g. user-changed text
$submitButtonText = "Create Invoice"; // If you want to rename the submit button

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $year = trim($_POST['year'] ?? '');
    $month = trim($_POST['month'] ?? '');
    $token = trim($_POST['token'] ?? '');

    // Validate token
    if ($token !== $secret_token) {
        $title = "Invalid token";
        $responseHTML = "<h2>Invalid token. Access denied.</h2>";
    } else {
        // Build data to send to Make.com
        $postData = http_build_query([
            'year' => $year,
            'month' => $month,
            'token' => $token
        ]);

        // cURL to Make.com webhook
        $ch = curl_init($makeWebhookURL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($statusCode >= 200 && $statusCode < 300) {
            $title = "Invoice request sent successfully!";
            $responseHTML .= "<pre>" . htmlspecialchars($response) . "</pre>\n";
        } else {
            $title = "Request Failed";
            $responseHTML = "<h3>Failed to send invoice request.</h3>\n";
            $responseHTML .= "<p>Status code: $statusCode</p>\n";
            $responseHTML .= "<pre>" . htmlspecialchars($response) . "</pre>\n";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 400px;
            margin: 30px auto;
            background-color: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            font-size: 1.5em;
            margin-bottom: 20px;
        }
        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            margin-right: 10px;
            white-space: nowrap;
        }
        select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
            margin-right: 10px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        pre {
            background: #f8f8f8;
            padding: 10px;
            border-radius: 4px;
            overflow: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($title); ?></h1>

        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>

            <!-- Show the response (success or error) -->
            <?php echo $responseHTML; ?>

        <?php else : ?>
            <!-- Show the form -->
            <!-- If your secret is in $_GET['secret'], pass it along in the form action. -->
<form method="POST" action="<?php 
  echo htmlspecialchars($_SERVER['PHP_SELF'] . '?secret=' . urlencode($_GET['secret'])); 
?>">
                <div class="form-group">
                    <label for="year">Period:</label>
                    <select name="year" id="year">
                        <?php foreach ($years as $yr): ?>
                            <option value="<?php echo $yr; ?>" <?php echo ($yr == $currentYear) ? 'selected' : ''; ?>>
                                <?php echo $yr; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <select name="month" id="month">
                        <?php foreach ($months as $num => $name): ?>
                            <option value="<?php echo str_pad($num, 2, '0', STR_PAD_LEFT); ?>" <?php echo ($num == $currentMonth) ? 'selected' : ''; ?>>
                                <?php echo $name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($secret_token); ?>">
                <input type="submit" value="<?php echo htmlspecialchars($submitButtonText); ?>">
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
