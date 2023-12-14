<?php
// URL of the JSON data
$json_url = 'https://raw.githubusercontent.com/migrapreneurs/migra24/main/_data/meta.json';

// Fetch the JSON data using cURL
$ch = curl_init($json_url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$json_data = curl_exec($ch);

if ($json_data === false) {
    // Handle cURL error, e.g., echo an error message
    echo "Error fetching JSON data with cURL: " . curl_error($ch);
}

curl_close($ch);

// Function to generate meta tags
function generateMetaTags($metaArray) {
    $metaTags = '';

    foreach ($metaArray as $meta) {
        $tag = '<meta ';

        foreach ($meta as $key => $value) {
            $tag .= $key . '="' . htmlspecialchars($value) . '" ';
        }

        $tag .= "/>\n";
        $metaTags .= $tag;
    }

    return $metaTags;
}

// Generate the HTML meta tags
$htmlMetaTags = generateMetaTags($metadata['metadata'][0]['meta']);


var_dump($htmlMetaTags);


?>
