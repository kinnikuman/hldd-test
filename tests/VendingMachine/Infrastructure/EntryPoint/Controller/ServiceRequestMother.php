<?php

declare(strict_types=1);


namespace App\Tests\VendingMachine\Infrastructure\EntryPoint\Controller;


use Symfony\Component\HttpFoundation\Request;

class ServiceRequestMother
{
    public static function withValiData($data): Request
    {

        return self::createRequest($data);
    }

    public static function withoutItems(): Request
    {
        $data = [
            'money' => [['coinCents' => 100, 'numberOfCoins' => 1]]
        ];

        return self::createRequest($data);
    }

    public static function withoutMoney(): Request
    {
        $data = [
            'items' => [['name' => 'WATER', 'count' => 100, 'price' => 1]],
        ];

        return self::createRequest($data);
    }

    public static function withoutItemName(): Request
    {
        $data = [
            'items' => [['count' => 100, 'price' => 1]],
            'money' => [['coinCents' => 100, 'numberOfCoins' => 1]]
        ];

        return self::createRequest($data);
    }

    public static function withoutItemCount(): Request
    {
        $data = [
            'items' => [['name' => 'WATER', 'price' => 1]],
            'money' => [['coinCents' => 100, 'numberOfCoins' => 1]]
        ];

        return self::createRequest($data);
    }

    public static function withoutItemPrice(): Request
    {
        $data = [
            'items' => [['name' => 'WATER', 'count' => 100]],
            'money' => [['coinCents' => 100, 'numberOfCoins' => 1]]
        ];

        return self::createRequest($data);
    }

    public static function withoutMoneyCoinCents(): Request
    {
        $data = [
            'items' => [['name' => 'WATER', 'count' => 100, 'price' => 1]],
            'money' => [[ 'numberOfCoins' => 1]]
        ];

        return self::createRequest($data);
    }

    public static function withoutMoneyNumberOfCoins(): Request
    {
        $data = [
            'items' => [['name' => 'WATER', 'count' => 100, 'price' => 1]],
            'money' => [[ 'coinCents' => 100]]
        ];

        return self::createRequest($data);
    }

    public static function withWrongTypeItemName(): Request
    {
        $data = [
            'items' => [['name' => 9, 'count' => 100, 'price' => 1]],
            'money' => [[ 'coinCents' => 100, 'numberOfCoins' => 1]]
        ];

        return self::createRequest($data);
    }
    public static function withWrongTypeItemCount(): Request
    {
        $data = [
            'items' => [['name' => 'WATER', 'count' => 'a', 'price' => 1]],
            'money' => [[ 'coinCents' => 100, 'numberOfCoins' => 1]]
        ];

        return self::createRequest($data);
    }
    public static function withWrongTypePriceCount(): Request
    {
        $data = [
            'items' => [['name' => 'WATER', 'count' => 1, 'price' => 'a']],
            'money' => [[ 'coinCents' => 100, 'numberOfCoins' => 1]]
        ];

        return self::createRequest($data);
    }

    public static function withWrongTypeMoneyCoinCents(): Request
    {
        $data = [
            'items' => [['name' => 'WATER', 'count' => 1, 'price' => 'a']],
            'money' => [[ 'coinCents' => 8.8, 'numberOfCoins' => 1]]
        ];

        return self::createRequest($data);
    }

    public static function withWrongTypeMoneyCoinNumberOfCoins(): Request
    {
        $data = [
            'items' => [['name' => 'WATER', 'count' => 1, 'price' => 'a']],
            'money' => [[ 'coinCents' => 100, 'numberOfCoins' => 1.2]]
        ];

        return self::createRequest($data);
    }


    private static function createRequest(array $data): Request
    {
        $request = new Request(content: json_encode($data));
        $request->setMethod(Request::METHOD_PUT);
        return $request;
    }
}