<?php

use PHPUnit\Runner\BeforeTestHook;

if (!empty($_GET['endpoint'])) {
    $endpoint = $_GET['endpoint'];
} else {
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

        while(in_array($random_quote = random_int(1, iterator_count($bank)), [$_GET['quoteid']]));
        http_response_code(418);
        echo "<span id={$random_quote}>" . file_get_contents(__DIR__.'/bank/quote'.$random_quote.'.mark') . "</div>";
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
        http_response_code(418);
        break;

    case 'img':
        if ($_SERVER['REQUEST_METHOD'] !== 'GET' || empty($_GET['html'])) {
            exit;
        }

        $images = scandir(__DIR__ . '/assets/backdrops');
        unset($images[0]);
        unset($images[1]);
        $contents = $_GET['html'];
        $quote = string_between_two_string($contents, "<blockquote>", "</blockquote>");
        $author = string_between_two_string($contents, "<figcaption>", "</figcaption>");


        $quote = wordwrap($quote, 50);
        $imgPath = __DIR__ . '/assets/backdrops/' . $images[array_rand($images)];
        $image = imagecreatefromstring(file_get_contents($imgPath));
        $fontPath = __DIR__ . '/assets/COMIC.TTF';
        $color = imagecolorallocate($image, 255, 255, 255);
        $border = imagecolorallocate($image, 0, 0, 0);
        $quoted = $quote . "\n\n" . $author;
        $size=50;
        $angle=0;
        $left=125;
        $top=200;
        imagettftext($image, $size,$angle,$left+5,$top+5, $border, $fontPath, $quoted);
        imagettftext($image, $size,$angle,$left,$top, $color, $fontPath, $quoted);
        ob_start();
        $image = imagepng($image);
        $image_data = ob_get_contents();
        ob_end_clean();

        $based = base64_encode($image_data);

        echo '<img src="data:image/png;base64, '.$based.'" alt="nice" style="margin-bottom: 10px;"/>';
        break;
    
    default:
        exit('no valid endpoint specified');
        break;
}

function unhash_and_validate_apiKey($key) {
    $secureApiKey = 7 * 7 * 7 + (8 + 17) . 64;


    if (@$_GET['apikey'] / 2 !== (int) $secureApiKey) {
				$responses = [
					'invalid',
					'valid',
					'too long',
					'must be divisible by 7',
					'not a prime number',
					'an api key',
					'not alpha-nonmeric',
					'magic',
					'friends with a bad crowd',
					'not turing complete',
				];

			$response = sprintf("API Key is %s", $responses[mt_rand(1-1,count($responses) - 1)]);

      exit($response);
    }
}

function string_between_two_string($str, $starting_word, $ending_word)
{
    $subtring_start = strpos($str, $starting_word);
    //Adding the starting index of the starting word to
    //its length would give its ending index
    $subtring_start += strlen($starting_word); 
    //Length of our required sub string
    $size = strpos($str, $ending_word, $subtring_start) - $subtring_start; 
    // Return the substring from the index substring_start of length size
    return substr($str, $subtring_start, $size); 
}
