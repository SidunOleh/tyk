<?php

namespace App\Traits;

use App\Contracts\ILogUser;

trait History
{
    public function log(
        string $action, 
        ?ILogUser $user = null, 
        array $data = []
    )
    {
        $history = [];
        $history['date'] = now();
        $history['user'] = $user?->logName() ?? 'невідомий';
        $history['action'] = $action;
        $history['data'] = $data;

        $this->history = [$history, ...$this->history ?? []];
        $this->saveQuietly();
    }

    public function getUpdates(): array
    {
        $data = [];
        foreach ($this->loggable as $field) {
            if ($this->wasChanged($field)) {
                if ($field == 'password') {
                    $data[__('validation.attributes.password')] = 'змінено';
                } else {
                    $data[__('validation.attributes.'.$field)] = 
                        'з ' . ($this->formatValue($this->getOriginal($field)) ?? '_') . ' на ' . ($this->formatValue($this->{$field}) ?? '_');
                }
            }
        }

        return $data;
    }

    protected function formatValue(mixed $value): mixed
    {
        if (is_array($value)) {
            return implode(', ', $value);
        }

        if (is_bool($value)) {
            return $value ? 'так' : 'ні';
        }

        return $value;
    }
}