<?php

use Components\Geolocation\GeoService;
use Components\Geolocation\AddressService;

class StoreService {

    public function getStoreCoordinates(AddressService $store, GeoService $geoService): string {
        return $geoService->getCoordinates($store->getAddress());
    }

}
