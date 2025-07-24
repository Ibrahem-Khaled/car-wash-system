<?php

namespace App\Models\Traits;

/**
 * Trait لإدارة أدوار المستخدمين والتحقق منها.
 */
trait HasRoles
{
    // تعريف الأدوار كثوابت لسهولة الاستخدام وتوحيدها في مكان واحد
    const ROLE_ADMIN = 'admin';
    const ROLE_EMPLOYEE = 'factor';
    const ROLE_CUSTOMER = 'customer';

    /**
     * التحقق مما إذا كان المستخدم عميلًا.
     *
     * @return bool
     */
    public function isCustomer(): bool
    {
        return $this->role === self::ROLE_CUSTOMER;
    }

    /**
     * التحقق مما إذا كان المستخدم مديرًا.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * التحقق مما إذا كان المستخدم موظفًا.
     *
     * @return bool
     */
    public function isEmployee(): bool
    {
        return $this->role === self::ROLE_EMPLOYEE;
    }
}
