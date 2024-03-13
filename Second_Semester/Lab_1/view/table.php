<?php

function MakeTableByData(array $results, array $need_fields_with_types, array $headers): string
{
    $table = '
    <table class="table table-striped table-hover">
    <thead>
        <tr>
    ';
    for ($index = 0; $index < count($need_fields_with_types); $index++) {
        $table = $table . '<th scope = "col">';
        $table = $table . htmlspecialchars($headers[$need_fields_with_types[$index]["name"]]);
        $table = $table . "</th>";
    }
    $table = $table . "</tr>";
    $table = $table . "</thead>";
    $table = $table . "<tbody>";

    for ($resultIndex = 0; $resultIndex < count($results); $resultIndex++) {
        $row = "<tr>";
        $nowResult = $results[$resultIndex];
        for ($fieldsIndex = 0; $fieldsIndex < count($need_fields_with_types); $fieldsIndex++) {
            $field = $need_fields_with_types[$fieldsIndex];
            if ($field["type"] == "link") {
                $text = $nowResult[$field["name"]]["text"];
                $link = $nowResult[$field["name"]]["link"];
                $nowResult[$field["name"]] = '<a class="btn btn-info" role="button" href ="' . htmlspecialchars($link) . '"> ' . htmlspecialchars($text) . "</a>";
            } else if ($field["type"] == "picture") {
                $link = "http://localhost/InternetLab/Second_Semester/common_resourses/picture/" . htmlspecialchars($nowResult[$field["name"]]) . ".png";
                $nowResult[$field["name"]] = "<img src='{$link}'/>";
            } else if ($field["type"] == "form_button") {
                $id = htmlspecialchars($nowResult[$field["name"]]["id"]);
                $text_on_button = htmlspecialchars($nowResult[$field["name"]]["text"]);
                $form_name = htmlspecialchars($nowResult[$field["name"]]["form_name"]);
                $hidden_text = "<input type='hidden' value={$id} name='id'> <input type='hidden' value={$form_name} name='type'>";
                $button = "<button class='btn btn-info' type='submit'>{$text_on_button}</button>";
                $nowResult[$field["name"]] = "<form method='post' action='http://localhost/InternetLab/Second_Semester/Lab_1/crud/'>" . $hidden_text . $button . "</form>";
            }
            $row = $row . "<td>" . ($field["type"] == "picture" || $field["type"] == "form_button" || $field["type"] == "link" ? $nowResult[$field["name"]] : htmlspecialchars($nowResult[$field["name"]])) . "</td>";
        }
        $row = $row . "</tr>";
        $table = $table . $row;
    }
    $table = $table . "</tbody>";
    $table = $table . "</table>";
    return $table;
}

?>