<?php

namespace App\Mail\Transports;

use Illuminate\Support\Facades\Http;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\MessageConverter;

class BrevoTransport extends AbstractTransport
{
    protected string $key;

    public function __construct(string $key)
    {
        parent::__construct();
        $this->key = $key;
    }

    protected function doSend(SentMessage $message): void
    {
        $email = MessageConverter::toEmail($message->getOriginalMessage());

        $payload = [
            'sender' => $this->getAddressPayload($email->getFrom()[0]),
            'to' => $this->getAddressListPayload($email->getTo()),
            'subject' => $email->getSubject(),
            'htmlContent' => $email->getHtmlBody(),
        ];

        if ($email->getTextBody()) {
            $payload['textContent'] = $email->getTextBody();
        }

        $response = Http::withHeaders([
            'api-key' => $this->key,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post('https://api.brevo.com/v3/smtp/email', $payload);

        if ($response->failed()) {
            throw new \Exception('Brevo API Error: ' . $response->body());
        }
    }

    protected function getAddressPayload(Address $address): array
    {
        return [
            'email' => $address->getAddress(),
            'name' => $address->getName() ?: explode('@', $address->getAddress())[0],
        ];
    }

    protected function getAddressListPayload(array $addresses): array
    {
        return array_map(fn (Address $address) => $this->getAddressPayload($address), $addresses);
    }

    public function __toString(): string
    {
        return 'brevo';
    }
}
