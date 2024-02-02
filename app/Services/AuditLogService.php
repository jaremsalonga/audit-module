<?php

namespace App\Services;

use App\Models\AuditLogModel;

class AuditLogService {

    public function __construct(public $auditLogModel = AuditLogModel::class)
    {}

    public function logAction(string $action, $data) {
        $this->auditLogModel->create($action, $data);
    }

}