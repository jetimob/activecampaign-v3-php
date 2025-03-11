<?php

namespace Jetimob\ActiveCampaign\Http;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\RequestOptions;
use GuzzleRetry\GuzzleRetryMiddleware;

class Client
{
    public const HEADER_AUTH_KEY = 'Api-Token';
    public const LIB_USER_AGENT = 'activecampaign-v3-php/1.0';
    public const API_VERSION_URL = '/api/3';
    public const EVENT_TRACKING_URL = 'https://trackcmp.net/event';

    public function __construct(
        protected GuzzleClient $client,
        protected ?GuzzleClient $event_tracking_client = null,
    ) {
    }

    /**
     * @param string $api_url       ActiveCampaign API URL.  Format is https://YOUR_ACCOUNT_NAME.api-us1.com
     * @param string $api_token     ActiveCampaign API token.  Get yours from developer settings.
     * @return GuzzleClient
     */
    public static function buildGuzzleClient(string $api_url, string $api_token): GuzzleClient
    {
        return new GuzzleClient([
            'base_uri'              => $api_url,
            'handler'  => self::getMiddlewareStack(),
            RequestOptions::HEADERS => [
                'User-Agent'          => self::LIB_USER_AGENT,
                self::HEADER_AUTH_KEY => $api_token,
                'Accept'              => 'application/json'
            ]
        ]);
    }

    /**
     * @param string $event_tracking_actid  Event Tracking ACTID.  Get yours from Settings > Tracking > Event Tracking > Event Tracking API
     * @param string $event_tracking_key    Event Tracking Key.  Get yours from Settings > Tracking > Event Tracking > Event Key
     * @return GuzzleClient
     */
    public static function buildTrackingGuzzleClient(string $event_tracking_actid, string $event_tracking_key): GuzzleClient
    {
        return new GuzzleClient([
            'base_uri'                  => self::EVENT_TRACKING_URL,
            'handler'  => self::getMiddlewareStack(),
            RequestOptions::HEADERS     => [
                'User-Agent' => self::LIB_USER_AGENT,
                'Accept'     => 'application/json'
            ],

            RequestOptions::FORM_PARAMS => [
                'actid' => $event_tracking_actid,
                'key'   => $event_tracking_key
            ]
        ]);
    }

    public function getClient(): GuzzleClient
    {
        return $this->client;
    }

    public function getEventTrackingClient(): ?GuzzleClient
    {
        return $this->event_tracking_client;
    }

    private static function getMiddlewareStack(): HandlerStack
	{
		$stack  = HandlerStack::create();
		$retryMiddleware = GuzzleRetryMiddleware::factory([
			'retry_enabled'            => true,
			'max_retry_attempts'       => 3,
			'retry_on_status'          => [429, 500, 502, 503, 504],
			'default_retry_multiplier' => 1,
			'expose_retry_header'      => true,
		]);
		$stack->push($retryMiddleware, 'retry');
		return $stack;
	}
}
