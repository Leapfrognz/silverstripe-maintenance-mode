<?php

declare(strict_types=1);

namespace WeDevelop\MaintenanceMode;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Security\Permission;
use SilverStripe\Security\PermissionProvider;

class ErrorPageExtension extends DataExtension implements PermissionProvider
{
    /**
     * @param array<int, array{ErrorCode: int, Title: string, Content: string}> $data
     */
    public function getDefaultRecords(array &$data): void
    {
        $data[] = [
            'ErrorCode' => 503,
            'Title' => _t(static::class . '.DEFAULTMAINTENANCEPAGETITLE', 'Maintenance mode'),
            'Content' => _t(
                static::class . '.DEFAULTMAINTENANCEPAGECONTENT',
                '<p>We are currently performing some maintenance.</p>'
            ),
        ];
    }

    /**
     * @return array<string, array{name: string, category: string, help: string}>
     */
    public function providePermissions(): array
    {
        return [
            'ACCESS_SITE_IN_MAINTENANCE_MODE' => [
                'name' => _t(static::class . '.ACCESS_SITE_IN_MAINTENANCE_MODE', 'Access site while in maintenance mode'),
                'category' => _t(Permission::class . '.AdminGroup', 'Administrator'),
                'help' => _t(static::class . '.ACCESS_SITE_IN_MAINTENANCE_MODE_HELP', 'Allows access to the website while maintenance mode is enabled.'),
            ],
        ];
    }
}
