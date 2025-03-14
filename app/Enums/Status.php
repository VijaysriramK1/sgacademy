<?php

namespace App\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum Status: int implements HasLabel, HasColor //, HasIcon
{
    case TRASH = 0;
    case ACTIVE = 1;
    case INACTIVE = 2;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::TRASH => 'Trash',
            self::ACTIVE => 'Active',
            self::INACTIVE => 'Inactive',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::TRASH => 'danger',
            self::ACTIVE => 'success',
            self::INACTIVE => 'warning',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::TRASH => 'heroicon-m-pencil',
            self::ACTIVE => 'heroicon-m-pencil',
            self::INACTIVE => 'heroicon-m-pencil',
        };
    }

    public static function getOptions(): array
    {
        return array_map(
            fn ($case) => [
                'label' => $case->getLabel(),
                'value' => $case->value,
                'icon' => $case->getIcon(),
                'color' => $case->getColor()
            ],
            self::cases()
        );
    }

    public static function isValid(string $type): bool
    {
        foreach (self::cases() as $case) {
            if ($case->value === $type) {
                return true;
            }
        }

        return false;
    }
}
