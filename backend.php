<?php



if (!empty($_GET['endpoint'])) {
    $endpoint = $_GET['endpoint'];
} else {
    http_response_code(400);
    exit('no endpoint specified');
}


unhash_and_validate_apiKey($_GET['apikey']);


$bank = new FilesystemIterator(__DIR__.'/bank', FilesystemIterator::SKIP_DOTS);
$quote_count = iterator_count($bank);

switch ($endpoint) {
    case 'postquote':
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            exit;
        }
        $random_quote = rand(1, iterator_count($bank));
        http_response_code(200);
        echo file_get_contents(__DIR__.'/bank/quote'.$random_quote.'.mark');
        break;

    case 'getquote':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            exit;
        }
        if (empty($_POST['field']) || empty($_POST['field2'])) {
            http_response_code(200);
            exit('no form data supplied');
        }

        $author = trim($_POST['field']);
        $quote = trim($_POST['field2']);
        $url = trim(filter_var($_POST['field3'], FILTER_SANITIZE_URL));

        $body = "<blockquote>$quote</blockquote><figcaption><a href=\"$url\" target=\"_blank\">-$author</a></figcaption>";
        $next_quote_no = $quote_count + 1;

        file_put_contents(__DIR__.'/bank/quote'.$next_quote_no.'.mark', $body);
        http_response_code(201);
        break;
    
    default:
        http_response_code(404);
        exit('no valid endpoint specified');
        break;
}

function unhash_and_validate_apiKey($key) {
    $secureApiKey = 7 * 7 * 7 + (8 + 17) . 64;


    if (@$_GET['apikey'] / 2 !== (int) $secureApiKey) {
        exit('invalid api key');
    }
}
