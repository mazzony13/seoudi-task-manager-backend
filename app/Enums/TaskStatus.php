<?php


namespace App\Enums;


enum TaskStatus: int
{
    case PENDING = 1;
    case IN_PROGRESS = 2;
    case COMPLETED = 3;



    public function text(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::IN_PROGRESS => 'In Progress',
            self::COMPLETED => 'Completed',

        };
    }

    public function class(): string
    {
        return match ($this) {
            self::PENDING => 'info',
            self::IN_PROGRESS => 'info',
            self::COMPLETED => 'success',
        };
    }


    public function color(): string
    {
        return match ($this) {
            self::PENDING => '#34244B',
            self::IN_PROGRESS => '#50c1b7',
            self::COMPLETED => '#d90404',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}
