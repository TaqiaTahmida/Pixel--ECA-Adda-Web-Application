<?php

namespace App\Services;

use Google_Client;
use Google_Service_Calendar;

class GoogleCalendarService
{
    public function getClient()
    {
        $client = new Google_Client();
        
        $authConfig = env('GOOGLE_SERVICE_ACCOUNT_JSON');
        
        if ($authConfig) {
            $client->setAuthConfig(json_decode($authConfig, true));
        } else {
            $client->setAuthConfig(storage_path('app/room-464006-67a87aa68d1b.json'));
        }

        $client->addScope(Google_Service_Calendar::CALENDAR_READONLY);
        return $client;
    }

    public function getCalendarEvents(string $calendarId, int $maxResults = 10)
    {
        $client = $this->getClient();
        $service = new Google_Service_Calendar($client);

        $events = $service->events->listEvents($calendarId, [
            'maxResults'   => $maxResults,
            'orderBy'      => 'startTime',
            'singleEvents' => true,
            'timeMin'      => now()->toRfc3339String(),
        ]);

        return $events->getItems();
    }
}
?>