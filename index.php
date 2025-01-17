<?php
require 'vendor/autoload.php';
require_once 'functions.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

//Проверка установлена ли библиотека
if (!class_exists('PhpOffice\PhpSpreadsheet\Spreadsheet')) {
    echo 'Ошибка: Библиотека PhpSpreadsheet не установлена. Установите библиотеку, используя composer.';
    exit();
}

// Создание папки для хранения файла
$directory = 'excel_files';
if (!is_dir($directory)) {
    mkdir($directory, 0777, true);
}

//Проверка существования такого файла
$filePath = "$directory/random_numbers.xlsx";
if (file_exists($filePath)) {
    echo "Файл $directory/random_numbers.xlsx уже создан";
    exit();
}

// Создание новой таблицы
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Создаём массив данных (10 строк, каждая с 10 случайными числами)
$data = array_map(fn() => generateRow(), range(1, 10));

// Записываем сразу весь массив в лист (начиная с A1)
$sheet->fromArray($data, null, 'A1');

// Применение стилей ко всей таблице
$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['rgb' => '000'],
        ],
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
];

$sheet->getStyle('A1:J10')->applyFromArray($styleArray);

// Автоматическая ширина колонок
for ($col = 'A'; $col <= 'J'; $col++) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Сохранение файла
$writer = new Xlsx($spreadsheet);
$writer->save($filePath);
echo "Файл успешно создан: $filePath";



