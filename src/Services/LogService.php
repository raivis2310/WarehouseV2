<?php

namespace Warehouse\Services;

class LogService
{
    private $logs;

    public function __construct()
    {
        if (file_exists('logs.json')) {
            $this->logs = json_decode(file_get_contents('logs.json'), true);
        } else {
            $this->logs = [];
        }
    }

    public function save()
    {
        file_put_contents('logs.json', json_encode($this->logs, JSON_PRETTY_PRINT));
    }

    public function logChange($userId, $productId, $change)
    {
        $logEntry = [
            'timestamp' => date('Y-m-d H:i:s'),
            'userId' => $userId,
            'productId' => $productId,
            'change' => $change
        ];
        $this->logs[] = $logEntry;
        $this->save();
    }
}
