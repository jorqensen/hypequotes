<?php

if (!empty($_GET['endpoint'])) {
    $endpoint = $_GET['endpoint'];
} else {
    exit('no endpoint specified');
}

$db = new FilesystemIterator(__DIR__.'/database', FilesystemIterator::SKIP_DOTS);
$quote_count = iterator_count($db);

switch ($endpoint) {
    case 'postquote':
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            exit;
        }
        $random_quote = rand(1, iterator_count($db));
        http_response_code(418);
        echo file_get_contents(__DIR__.'/database/quote'.$random_quote.'.mark');
        break;

    case 'getquote':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            exit;
        }
        if (empty($_POST['field']) || empty($_POST['field2'])) {
            http_response_code(200);
            exit('no form data supplied');
        }

        $author = $_POST['field'];
        $quote = $_POST['field2'];

        $body = "<blockquote>$quote</blockquote><figcaption>-$author</figcaption>";
        $next_quote_no = $quote_count + 1;

        file_put_contents(__DIR__.'/database/quote'.$next_quote_no.'.mark', $body);
        http_response_code(418);
        break;
    
    default:
        exit('no valid endpoint specified');
        break;
}