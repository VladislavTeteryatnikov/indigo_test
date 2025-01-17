<?php

// Функция для генерации строки случайных чисел
function generateRow() {
    return array_map(fn() => rand(1, 100), range(1, 10));
}
