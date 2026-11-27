<?php
/**
 * Plesk notifications (the bell at the top of Plesk): what Stingy Scanner can show there. They appear in
 * Tools & Settings → Notifications → Panel, where the administrator can switch each one on or off; which kinds
 * Stingy Scanner sends is chosen in its own Settings (see VtPanelNotify). Sent by VtPanelNotify.
 */
require_once dirname(__DIR__) . '/library/VtPanelNotify.php';

class Modules_Stingyscan_Notifications extends pm_Hook_Notifications
{
    public function getNotifications()
    {
        $out = [];
        foreach (VtPanelNotify::KINDS as $kind => $k) {
            $out[VtPanelNotify::CODE_PREFIX . $kind] = new Modules_Stingyscan_PanelNotification($kind);
        }
        return $out;
    }
}

/** One kind of Stingy Scanner notification; the text of each one comes with send() (subject, message, link) */
class Modules_Stingyscan_PanelNotification extends pm_Notifications_PanelNotification
{
    private string $kind;

    public function __construct(string $kind) { $this->kind = $kind; }

    private function k(): array { return VtPanelNotify::KINDS[$this->kind] ?? VtPanelNotify::KINDS['test']; }

    public function getTitle() { return 'Stingy Scanner: ' . $this->k()['title']; }      // the name in Tools & Settings → Notifications
    public function getSubject() { return '{{ subject }}'; }
    public function getMessage() { return '{{ message }}'; }
    public function getActionText() { return 'Open Stingy Scanner'; }
    public function getActionUrl() { return '{{ link }}'; }
    public function openActionInNewTab() { return false; }
    public function getCategory() { return $this->k()['category']; }
    public function getArea() { return $this->k()['area']; }
    public function getContext() { return 'Stingy Reputation Scanner'; }
    public function getContextIcon() { return pm_Context::getBaseUrl() . 'images/icon.png'; }   // the Stingy Scanner logo
    public function isPromotion(): bool { return false; }

    /** send() parameters → template values: plain text in, escaped for the panel */
    public function prepareRenderParams(array $params)
    {
        return [
            'subject' => (string)($params['subject'] ?? $this->k()['title']),
            'message' => (string)($params['message'] ?? ''),
            'link'    => (string)($params['link'] ?? pm_Context::getActionUrl('index')),
        ];
    }
}
