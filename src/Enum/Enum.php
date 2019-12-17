<?php

namespace Iamport\RestClient\Enum;

use Exception;

/**
 * Enum 클래스 기본 정의
 * Class Enum.
 */
class Enum
{
    /**
     * @var null
     */
    private static $constCacheArray = null;

    /**
     * @return mixed
     *
     * @throws Exception
     */
    private static function getConstants()
    {
        if (null === self::$constCacheArray) {
            self::$constCacheArray = [];
        }

        $calledClass = get_called_class();

        if (!array_key_exists($calledClass, self::$constCacheArray)) {
            $reflect                             = new \ReflectionClass($calledClass);
            self::$constCacheArray[$calledClass] = $reflect->getConstants();
        }

        return self::$constCacheArray[$calledClass];
    }

    /**
     * @return array
     */
    public static function getAll()
    {
        try {
            return self::getConstants();
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * @return array
     */
    public static function getValues()
    {
        try {
            return array_values(self::getConstants());
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * @param $value string
     *
     * @return string|null
     */
    public static function getKey($value)
    {
        try {
            return array_search($value, self::getConstants());
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * @param $key string
     *
     * @return int|null
     */
    public static function getValue($key)
    {
        try {
            $constants = self::getConstants();

            return $constants[$key];
        } catch (Exception $e) {
            return null;
        }
    }

    public static function getDescription(string $value): ?string
    {
        return self::getKey($value);
    }

    /**
     * @return string
     */
    public static function getRandomValue()
    {
        $values = self::getValues();

        return $values[array_rand($values, 1)];
    }

    /**
     * ENUM에 속한 값인지 체크합니다.
     *
     * @param $value
     *
     * @return bool
     */
    public static function validation($value)
    {
        $values = self::getValues();

        return in_array($value, $values);
    }
}
