<?php

namespace App\Listeners;

use App\Events\AuditLogEvent;
use App\Models\AuditLogModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class StoreAuditLog {

    public $auditLogModel;

    public function __construct(AuditLogModel $auditLogModel)
    {
        $this->auditLogModel = $auditLogModel;
    }

    public function handle(AuditLogEvent $auditLogEvent) {

        $userInfo = $auditLogEvent->user;

        if($auditLogEvent->user instanceof Response) {
            $userInfo= json_decode($auditLogEvent->user->getContent(), true);
        }

        if($auditLogEvent->response instanceof JsonResponse) {
            $auditLogEvent->response = json_encode($auditLogEvent->response);
        }

        return $this->auditLogModel->create([
            'url'    => request()->route()->uri(),
            'name'   => $userInfo['name'],
            'email'  => $userInfo['email'],
            'response' => $auditLogEvent->response
        ]);

    }
}