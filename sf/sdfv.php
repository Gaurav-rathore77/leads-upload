<?php

$records = [
    [
        'id' => 1,
        'name' => 'Risdtika Bansal',
        'mobile' => '9891112345',
        'email' => 'ritika.bans1al1943@gmail.com',
        'city' => 'Nagpur',
        'program' => 'Commerce',
        'course' => 'B.Com'
    ],
    [
        'id' => 2,
        'name' => 'Faizaan Sheikh',
        'mobile' => '9837698745',
        'email' => 'fai23zan.sheikh8210@gmail.com',
        'city' => 'Bhopal',
        'program' => 'Engineering',
        'course' => 'B.Tech'
    ],
    [
        'id' => 3,
        'name' => 'Simranjeet Singh',
        'mobile' => '9876432198',
        'email' => 'simranjeet.singh3487@gmail.com',
        'city' => 'Chandigarh',
        'program' => 'Design',
        'course' => 'B.Des'
    ]
];

$successCount = 0;
$duplicateCount = 0;
$errorCount = 0;
$results = [];

foreach ($records as $row) {
    $data = [
        'name' => $row['name'],
        'phone' => $row['mobile'],
        'email' => $row['email'],
        'mx_City' => $row['city'],
        'Lead_Vendor_Source' => 'Amity',
        'SourceCampaign' => 'Hyderabad',
        'SourceContent' => 'MSG1',
        'SourceMedium' => 'Google',
        'EnquiredforProgram' => $row['program'],
        'EnquiredforCourse' => $row['course'],
        'LeadSource' => 'Vidya Vriddhi',
        'utm_adgroup' => 'Goo',
        'utm_term' => 'Goog',
        'mx_utm_gclid' => 'Googl',
        'utm_keyword' => 'Google'
    ];

    $jsonData = json_encode($data);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://business-agility-9703.my.salesforce-sites.com/services/apexrest/leadCreationAPI");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($jsonData)
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $responseDecoded = json_decode($response, true);

    $status = "Error";
    $message = "Unknown error";
    $lastMessage = $response;

    if (
        $httpCode === 200 &&
        isset($responseDecoded['success']) &&
        $responseDecoded['success'] === true
    ) {
        if (empty($responseDecoded['errors'])) {
            $successCount++;
            $status = "Submitted";
            $message = "Lead ID: " . $responseDecoded['id'];
        } elseif (in_array("Lead already exists.", $responseDecoded['errors'])) {
            $duplicateCount++;
            $status = "Duplicate";
            $message = "Lead already exists";
        } else {
            $errorCount++;
            $message = implode(", ", $responseDecoded['errors']);
        }
    } else {
        $errorCount++;
    }

    $results[] = [
        'id' => $row['id'],
        'name' => $row['name'],
        'email' => $row['email'],
        'mobile' => $row['mobile'],
        'status' => $status,
        'message' => $message,
        'last_message' => $lastMessage
    ];
}

// Display Output
echo "<h3>✅ Successful: $successCount | 🔁 Duplicates: $duplicateCount | ❌ Errors: $errorCount</h3>";
echo "<table border='1' cellpadding='8' cellspacing='0'>
        <tr>
            <th>ID</th><th>Name</th><th>Email</th><th>Mobile</th><th>Status</th><th>Message</th><th>Last API Response</th>
        </tr>";

foreach ($results as $res) {
    echo "<tr>
            <td>{$res['id']}</td>
            <td>{$res['name']}</td>
            <td>{$res['email']}</td>
            <td>{$res['mobile']}</td>
            <td><strong>{$res['status']}</strong></td>
            <td>{$res['message']}</td>
            <td><pre>{$res['last_message']}</pre></td>
        </tr>";
}

echo "</table>";
?>