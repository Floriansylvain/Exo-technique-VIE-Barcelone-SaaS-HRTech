<?php
class DataManager
{
    private static function readJsonFile(string $filename): array
    {
        $path = __DIR__ . '/../data/' . $filename;
        if (!file_exists($path)) {
            return [];
        }
        $content = file_get_contents($path);
        $data = json_decode($content, true);
        return is_array($data) ? $data : [];
    }

    public static function getCars(string $clientId): array
    {
        $cars = self::readJsonFile('cars.json');
        return array_values(array_filter($cars, fn($c) => isset($c['customer']) && $c['customer'] === $clientId));
    }

    public static function getGarages(string $clientId): array
    {
        $garages = self::readJsonFile('garages.json');
        return array_values(array_filter($garages, fn($g) => isset($g['customer']) && $g['customer'] === $clientId));
    }

    public static function getGarageById($id): ?array
    {
        $garages = self::readJsonFile('garages.json');
        foreach ($garages as $g) {
            if (isset($g['id']) && $g['id'] == $id) {
                return $g;
            }
        }
        return null;
    }
}
