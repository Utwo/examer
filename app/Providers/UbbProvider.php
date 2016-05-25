<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;

class UbbProvider extends AbstractProvider implements ProviderInterface
{

    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(config('services.ubb.ubb_url') . '/oauth/authorize', $state);
    }

    protected function getTokenUrl()
    {
        return config('services.ubb.ubb_api') . '/oauth/access_token';
    }

    public function getAccessToken($code)
    {
        $response = $this->getHttpClient()->post($this->getTokenUrl(), [
            'form_params' => $this->getTokenFields($code),
        ]);
        return $this->parseAccessToken($response->getBody());
    }

    protected function getTokenFields($code)
    {
        return array_add(
            parent::getTokenFields($code), 'grant_type', 'authorization_code'
        );
    }

    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get(config('services.ubb.ubb_api') . config('services.ubb.ubb_api_version') . '/me?with=Role', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token['access_token'],
            ],
        ]);
        return json_decode($response->getBody(), true);
    }

    protected function formatScopes(array $scopes, $scopeSeparator)
    {
        return implode(',', $scopes);
    }

    protected function mapUserToObject(array $user)
    {
        return (new User)->setRaw($user)->map([
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email']
        ]);
    }
}
