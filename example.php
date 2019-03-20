<?php

function dump($array)
{
    echo "<pre>"; print_r($array); echo "</pre>";
}

interface ICity
{
    const PARAM1 = 'param2';
    const PARAM2 = 'param3';
    function compareTo(ICity $other): bool;
}

class City implements ICity
{
    public $params;
    public function __construct($params)
    {
        $this->params = $params;
    }

    public function compareTo(ICity $other): bool
    {
        $arA = $this->toCompare();
        $arB = $other->toCompare();
        $arDiff = array_diff($arA, $arB);

        return (count($arDiff) == 0);
    }

    static function getConstants()
    {
        $oClass = new ReflectionClass(__CLASS__);
        return $oClass->getConstants();
    }

    public function toCompare()
    {
        $arResults = [];
        $arConstants = self::getConstants();

        foreach($this->params as $key => $arParams) {
            $arResult = [];
            foreach($arConstants as $value) {
                $arResult[] =  $arParams[$value];
            }
            $arResults[$key] = implode("_", $arResult);
        }

        return $arResults;
    }

    function __toString()
    {
        return serialize($this->params);
    }
}

$arCity = [
    "nnovgorog" => [
        [
            "city" => "nnovgorog",
            "param1" => 1,
            "param2" => 2,
            "param3" => 3,
            "param4" => 4
        ],
        [
            "city" => "nnovgorog",
            "param1" => 11,
            "param2" => 22,
            "param3" => 33,
            "param4" => 44
        ],
        [
            "city" => "nnovgorog",
            "param1" => 111,
            "param2" => 222,
            "param3" => 333,
            "param4" => 444
        ]
    ],
    "kstovo" => [
        [
            "city" => "kstovo",
            "param1" => 1,
            "param2" => 2,
            "param3" => 3,
            "param4" => 4
        ],
        [
            "city" => "kstovo",
            "param1" => 11,
            "param2" => 22,
            "param3" => 33,
            "param4" => 44
        ],
        [
            "city" => "kstovo",
            "param1" => 111,
            "param2" => 222,
            "param3" => 333,
            "param4" => 444
        ]
    ],
    "Sarov" => [
        [
            "city" => "Sarov",
            "param1" => 1,
            "param2" => 2,
            "param3" => 3,
            "param4" => 4
        ],
        [
            "city" => "Sarov",
            "param1" => 11,
            "param2" => 22,
            "param3" => 33,
            "param4" => 44
        ],
        [
            "city" => "Sarov",
            "param1" => 111,
            "param2" => 222,
            "param3" => 333,
            "param4" => 444
        ]
    ]
];

$arCityObject = array();
foreach($arCity as $key => $cityItem) {
    $arCityObject[] = new City($cityItem);
}

$arResult = [];
while(count($arCityObject) > 0) {
    $key = count($arResult);
    $cityObject = array_shift($arCityObject);
    $arResult[$key][] = $cityObject;

    foreach($arCityObject as $iKey => $iCityObject) {
        if($cityObject->compareTo($iCityObject)) {
            $arResult[$key][] = $iCityObject;
            unset($arCityObject[$iKey]);
        }
    }
}

dump($arResult);
