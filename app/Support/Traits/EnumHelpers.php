<?php

namespace App\Support\Traits;

trait EnumHelpers
{
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function array(): array
    {
        return array_combine(self::values(), self::names());
    }

    public static function isValid(string $value): bool
    {
        return null !== self::tryFrom($value);
    }

    public static function options(): array
    {
        return \Arr::map(self::cases(), static fn ($case) => ['label' => $case->label(), 'value' => $case->value]);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->value,
            'label' => $this->label(),
        ];
    }

    public static function random(): self
    {
        return fake()->randomElement(self::cases());
    }

    public static function randomValue(int $count = 1): mixed
    {
        if ($count > 1) {
            return fake()->randomElements(self::values(), $count);
        }

        return self::random()->value;
    }
}
