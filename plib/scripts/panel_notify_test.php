<?php
/**
 * Sends one test notification to Plesk's notifications (the bell), in the extension's context:
 *   plesk bin extension --exec stingyscan panel_notify_test.php
 */
pm_Context::init('stingyscan');
require_once dirname(__DIR__) . '/library/VtPanelNotify.php';
echo VtPanelNotify::test() ? "sent\n" : "not sent (see the PHP error log)\n";
