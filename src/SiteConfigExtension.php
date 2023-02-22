<?php

declare(strict_types=1);

namespace WeDevelop\MaintenanceMode;

use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\DatetimeField;

/**
 * @property bool $MaintenanceModeEnabled
 * @property string $MaintenanceModeUntil
 */
class SiteConfigExtension extends DataExtension
{
    /**
     * @var array<string, string>
     * @config
     */
    private static array $db = [
        'MaintenanceModeEnabled' => 'Boolean',
        'MaintenanceModeUntil' => 'Datetime',
    ];

    /**
     * @var array<string, mixed>
     * @config
     */
    private static array $defaults = [
        'MaintenanceModeEnabled' => false,
    ];

    public function updateCMSFields(FieldList $fields): void
    {
        $fields->addFieldsToTab('Root.MaintenanceMode', [
            CheckboxField::create('MaintenanceModeEnabled', _t(static::class . '.MAINTENANCE_MODE_ENABLE', 'Enable maintenance mode')),
            DatetimeField::create('MaintenanceModeUntil', _t(static::class . '.MAINTENANCE_MODE_UNTIL', 'Expected end time of maintenance')),
        ]);
    }
}
