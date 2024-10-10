<?php

namespace app\src\Dto;

class DtoFactory
{
    public static function create(string $dtoClass, array $data)
    {
        if (!class_exists($dtoClass)) {
            throw new \InvalidArgumentException("Класс DTO '$dtoClass' не найден.");
        }

        return new $dtoClass($data);
    }
}