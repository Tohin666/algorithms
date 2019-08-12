<?php
echo 'Получить число шагов для заданного алгоритма.<br/>
Вычислить сложность алгоритма.<br/>';

$prices = [
    [
        'price' => 21999,
        'shop_name' => 'Shop 1',
        'shop_link' => 'http://'
    ],
    [
        'price' => 21550,
        'shop_name' => 'Shop 2',
        'shop_link' => 'http://'
    ],
    [
        'price' => 21950,
        'shop_name' => 'Shop 2',
        'shop_link' => 'http://'
    ],
    [
        'price' => 21350,
        'shop_name' => 'Shop 2',
        'shop_link' => 'http://'
    ],
    [
        'price' => 21050,
        'shop_name' => 'Shop 2',
        'shop_link' => 'http://'
    ]
];

function ShellSort($elements) {
    $totalSteps = 0;

    $pass=0;
    $gap[0] = (int) (count($elements) / 2);
    while($gap[$pass] > 1) {
        $pass++;
        $gap[$pass]= (int)($gap[$pass-1] / 2);
    }

    for($i = 0; $i <= $pass; $i++){
        $step = $gap[$i];

        $totalSteps++;

        for($j = $step; $j < count($elements); $j++) {
            $temp = $elements[$j];
            $p = $j - $step;

            $totalSteps++;

            while($p >= 0 && $temp['price'] < $elements[$p]['price']) {
                $elements[$p + $step] = $elements[$p];
                $p = $p - $step;

                $totalSteps++;
            }

            $elements[$p + $step] = $temp;
        }
    }

    echo '<br/>Количество шагов: ' . $totalSteps;

    return $elements;
}

echo '<br/>Сложность алгоритма: O(n^2)';
var_dump(ShellSort($prices));
