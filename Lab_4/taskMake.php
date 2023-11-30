<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Работа с текстом</title>
</head>
<body>

<form method="post">
    <input type="hidden" name="preset" value="<?php echo isset($_GET['preset']) ? $_GET['preset'] : ''; ?>">
    <textarea name="textLink"><?php 
     $inputText = isset($_POST['textLink']) ? $_POST['textLink'] : '';
     echo htmlspecialchars($inputText);
    ?>
    <textarea name="textLink"><?php 
        if (isset($_GET['preset'])) {
            if ($_GET['preset'] === '1') {
                echo htmlspecialchars(file_get_contents('https://ru.wikipedia.org/wiki/%D0%9A%D0%B8%D0%BD%D0%BE%D1%80%D0%B8%D0%BD%D1%85%D0%B8'));
            } elseif ($_GET['preset'] === '2') {
                echo htmlspecialchars(file_get_contents('https://www.gazeta.ru/culture/2021/12/16/a_14322589.shtml'));
            } elseif ($_GET['preset'] === '3') {
                echo htmlspecialchars(file_get_contents('https://mishka-knizhka.ru/skazki-dlay-detey/zarubezhnye-skazochniki/skazki-alana-milna/vinni-puh-i-vse-vse-vse/#glava-pervaya-v-kotoroj-my-znakomimsya-s-vinni-puhom-i-neskolkimi-pchy'));
            }
        } else {
            echo isset($_POST['textLink']) ? htmlspecialchars($_POST['textLink']) : '';
        }
    ?></textarea><br>
    
    <input type="submit" value="Продолжить">
    
</form>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $textWithoutScript = preg_replace('/<script\b[^>]*>.*?<\/script>/is', '', $_POST['textLink']);
        $textWithoutStyle = preg_replace('/<style\b[^>]*>.*?<\/style>/is', '', $textWithoutScript);
        $text = strip_tags($textWithoutStyle);    
        echo "<div>Текст без HTML кода:<br>$text</div>";
        $headers = [];
        $regex = '/<(h1|h2)[^>]*>.*?<\/\1>/is';
        preg_match_all($regex, $textWithoutStyle, $headers);
        
        
        if (!empty($headers[0])) {
            echo '<ul>';
            $htmlText = "";
            $headerArray = array();
            $indexH1 = 0;
            $indexH2 = 0;

            $headerTags = [];
            $regex = '/<(h1|h2)[^>]*>.*?<\/\1>/is';
            preg_match_all($regex, $textWithoutStyle, $headerTags);
            $isFisrst = true;
            foreach ($headers[0] as $i => $textInnerHTML) {
                $tag = $headerTags[1][$i]; 
                if($tag === 'h1'){
                    $indexH1 += 1;
                    $headerArray[$indexH1] = array();
                    $headerArray[$indexH1]["text"] = "";
                    if(!$isFisrst){
                        $headerArray[$indexH1]["text"] .= "<\li>";
                    }
                    $headerArray[$indexH1]["text"] .= "<li><ul>"."<h1>".($indexH1).".".strip_tags($textInnerHTML)."</h1>";
                    $headerArray[$indexH1]["quanity"] = 0;
                    $indexH2 = 0;
                }
                elseif($tag === 'h2'){
                    $indexH2 += 1;
                    $headerArray[$indexH1][$indexH2] = "<li><h2>".($indexH1).".".($indexH2).".".strip_tags($textInnerHTML)."</h2></li>";
                    $headerArray[$indexH1]["quanity"]++;
                }
            }
            for($index = 1; $index < count($headers); $index++){
                echo $headerArray[$index]["text"];
                for($j = 1; $j < $headerArray[$index]["quanity"] + 1; $j++){
                    echo $headerArray[$index][$j];
                }
            }


            echo $htmlText.""."</ul>";
            $htmlText = "";
        }
        echo "</ul>";
        
        echo '<ul>';
        $wordList = preg_split('/((^\p{P}+)|(\p{P}*\s+\p{P}*)|(\p{P}+$))/', $text);
        $prevWord = '';
        $repeatCount = 0;
        foreach ($wordList as $word) {
            if ($word === $prevWord) {
                $repeatCount++;
                if ($repeatCount == 2) {
                    $text = str_replace($word, "<span style='background-color:yellow;'>$word</span>", $text);
                } 
                else if($repeatCount >= 2) {
                    $text = str_replace($word, "<span style='background-color:yellow;'>$word</span>", $text);
                } 
            } else {
                $repeatCount = 1;
            }
            $prevWord = $word;
        }
        $text = preg_replace('/итп/', 'и.т.п', $text);
        $text = preg_replace('/итд/', 'и.т.д', $text);

        echo "<div><h2>Текст с подсветками и расстановкой точек в сокращениях</h2><p>$text</p></div>";
        echo "</ul>";

}
?>

</body>
</html>
