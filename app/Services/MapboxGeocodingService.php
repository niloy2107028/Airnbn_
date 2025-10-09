<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Mapbox Geocoding Service
 * Port of Node.js @mapbox/mapbox-sdk/services/geocoding
 * Provides forward geocoding to convert location + country to coordinates
 */
class MapboxGeocodingService
{
    protected $client;
    protected $accessToken;
    protected $baseUrl = 'https://api.mapbox.com/geocoding/v5/mapbox.places/';

    public function __construct()
    {
        $this->client = new Client();
        $this->accessToken = config('services.mapbox.access_token');
    }

    /**
     * Forward geocoding
     * Equivalent to Node.js geocodingClient.forwardGeocode({ query, limit }).send()
     *
     * @param string $query The location query (e.g., "Malibu, United States")
     * @param int $limit Number of results to return (default: 1)
     * @return array Geometry data with type and coordinates
     * @throws \Exception
     */
    public function forwardGeocode(string $query, int $limit = 1): array
    {
        try {
            $encodedQuery = urlencode($query);
            $url = "{$this->baseUrl}{$encodedQuery}.json";

            $response = $this->client->get($url, [
                'query' => [
                    'access_token' => $this->accessToken,
                    'limit' => $limit,
                    'types' => 'place,locality,address,poi', // Prioritize places and localities over water bodies
                    'language' => 'en',
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            // Node.js: response.body.features[0].geometry
            if (isset($data['features'][0]['geometry'])) {
                $feature = $data['features'][0];
                
                // Log the matched location for debugging
                logger()->info('Mapbox Geocoding Result', [
                    'query' => $query,
                    'place_name' => $feature['place_name'] ?? 'Unknown',
                    'coordinates' => $feature['geometry']['coordinates'] ?? null,
                ]);
                
                return $feature['geometry'];
            }

            // Fallback if no results found (same as Node.js init/index.js)
            logger()->warning('No geocoding results found for: ' . $query);
            return [
                'type' => 'Point',
                'coordinates' => [0, 0],
            ];

        } catch (GuzzleException $e) {
            // Log error and return fallback
            logger()->error('Mapbox Geocoding Error: ' . $e->getMessage());
            
            return [
                'type' => 'Point',
                'coordinates' => [0, 0],
            ];
        }
    }
}
