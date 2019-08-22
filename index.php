<?php
echo '1. Реализовать вывод меню на основе Closure table.<br/>';

$closureTableCategories = [
    [
        'id_category' => 1,
        'category_name' => 'Каталог'
    ],
    [
        'id_category' => 2,
        'category_name' => 'Одежда'
    ],
    [
        'id_category' => 3,
        'category_name' => 'Продукты'
    ],
    [
        'id_category' => 4,
        'category_name' => 'Верхняя одежда'
    ],
    [
        'id_category' => 5,
        'category_name' => 'Молочные продукты'
    ],
];
$closureTableLinks = [
    [
        'parent_id' => 1,
        'child_id' => 1,
        'level' => 0
    ],
    [
        'parent_id' => 1,
        'child_id' => 2,
        'level' => 1
    ],
    [
        'parent_id' => 1,
        'child_id' => 3,
        'level' => 1
    ],
    [
        'parent_id' => 2,
        'child_id' => 4,
        'level' => 2
    ],
    [
        'parent_id' => 3,
        'child_id' => 5,
        'level' => 2
    ],
    [
        'parent_id' => 2,
        'child_id' => 2,
        'level' => 1
    ],
    [
        'parent_id' => 4,
        'child_id' => 4,
        'level' => 2
    ],
    [
        'parent_id' => 3,
        'child_id' => 3,
        'level' => 1
    ],
    [
        'parent_id' => 5,
        'child_id' => 5,
        'level' => 2
    ],
];

function buildTree($categories, $categoryLevel = 0)
{
    $html = "<ul>";
    foreach ($categories[$categoryLevel] as $item) {
        $html .= "<li>" . $item["name"];
        if (isset($categories[$item["id"]])) {
            $html .= "<ul>";
            $html .= buildTree($categories, $item["id"]);
            $html .= "</ul>";
        }
        $html .= "</li>";
    }
    $html .= "</ul>";
    return $html;
}

function joinClosureTable($closureTableCategories, $closureTableLinks)
{
    $joinedClosureTable = [];
    foreach ($closureTableLinks as $closureTableLink) {
        $categoryName = '';
        if ($closureTableLink['child_id'] == 1) {
            foreach ($closureTableCategories as $closureTableCategory) {
                if ($closureTableCategory['id_category'] == $closureTableLink['child_id']) {
                    $categoryName = $closureTableCategory['category_name'];
                    break;
                }
            }
            $joinedClosureTable[0][] = [
                'id' => $closureTableLink['child_id'],
                'name' => $categoryName,
                'pid' => 0,
            ];
        } else if ($closureTableLink['child_id'] != $closureTableLink['parent_id']) {
            if (!isset($closureTableLink['parent_id'])) {
                $joinedClosureTable[] = $closureTableLink['parent_id'];
            }
            foreach ($closureTableCategories as $closureTableCategory) {
                if ($closureTableCategory['id_category'] == $closureTableLink['child_id']) {
                    $categoryName = $closureTableCategory['category_name'];
                    break;
                }
            }
            $joinedClosureTable[$closureTableLink['parent_id']][] = [
                'id' => $closureTableLink['child_id'],
                'name' => $categoryName,
                'pid' => $closureTableLink['parent_id'],
            ];
        }
    }
    return buildTree($joinedClosureTable);
}

echo joinClosureTable($closureTableCategories, $closureTableLinks);


echo '2. Дано слово, состоящее только из строчных латинских букв. Проверить, является ли оно палиндромом. При решении этой задачи нельзя пользоваться циклами<br/>';