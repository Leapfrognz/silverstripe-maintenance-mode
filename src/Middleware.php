<?php

declare(strict_types=1);

namespace WeDevelop\MaintenanceMode;

use SilverStripe\Control\Middleware\HTTPMiddleware;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\HTTPResponse;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Security\Permission;
use SilverStripe\Control\Director;
use SilverStripe\Security\Security;
use SilverStripe\ErrorPage\ErrorPage;
use SilverStripe\ErrorPage\ErrorPageController;

final class MaintenanceModeMiddleware implements HTTPMiddleware
{
    public function process(HTTPRequest $request, callable $delegate): ?HTTPResponse
    {
        if (!$this->displayMaintenancePage($request)) {
            return $delegate($request);
        }

        $controller = new ErrorPageController();
        $controller->setRequest($request);
        $controller->pushCurrent();

        $response = ErrorPage::response_for(503);

        $retryAfter = 600;
        $maintenanceModeUntil = SiteConfig::current_site_config()->MaintenanceModeUntil ?? '';
        if (!empty($maintenanceModeUntil)) {
            // Format the date according to the spec https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Date
            $retryAfter = gmdate('D, d M Y H:i:s', strtotime($maintenanceModeUntil)) . ' GMT';
        }
        $response->addHeader('Retry-After', $retryAfter);
        return $response;
    }

    protected function displayMaintenancePage(HTTPRequest $request): bool
    {
        if (Director::is_cli()) {
            return false;
        }

        $maintenanceModeEnabled = (bool)SiteConfig::current_site_config()->MaintenanceModeEnabled ?? false;
        if (!$maintenanceModeEnabled) {
            return false;
        }

        if (Permission::check('ACCESS_SITE_IN_MAINTENANCE_MODE') || Permission::check('ADMIN')) {
            return false;
        }

        if ($request->getURL() === Security::config()->get('login_url')) {
            return false;
        }

        return true;
    }
}
