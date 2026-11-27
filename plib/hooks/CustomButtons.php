<?php
/**
 * "Stingy Scanner" in Plesk's left navigation: for the administrator, resellers,
 * customers, and the Power User view (which shows the customer-style menu).
 */
class Modules_Stingyscan_CustomButtons extends pm_Hook_CustomButtons
{
    public function getButtons()
    {
        // ADMIN/RESELLER_NAVIGATION: their left menu. HOSTING_PANEL_NAVIGATION: the admin's menu in
        // the Power User view. HOSTING_PANEL_TABS: the customer's left menu (and a tab on the subscription page).
        // Resellers and customers only when the administrator allows it (Settings → Access)
        require_once dirname(__DIR__) . '/library/VtSettings.php';
        $places = [self::PLACE_ADMIN_NAVIGATION];
        if (VtSettings::roleAllowed('reseller')) $places[] = self::PLACE_RESELLER_NAVIGATION;
        if (defined(self::class . '::PLACE_HOSTING_PANEL_NAVIGATION')) $places[] = self::PLACE_HOSTING_PANEL_NAVIGATION; // the admin's Power User view
        if (VtSettings::roleAllowed('client') && defined(self::class . '::PLACE_HOSTING_PANEL_TABS')) $places[] = self::PLACE_HOSTING_PANEL_TABS;
        return [[
            'place'       => $places,
            'title'       => 'Stingy Scanner',
            'description' => 'Reputation scanner for your websites, and help to recover after an attack',
            'icon'        => pm_Context::getBaseUrl() . 'images/icon.png',
            'link'        => pm_Context::getActionUrl('index'),
        ]];
    }
}
