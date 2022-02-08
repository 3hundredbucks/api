<?php

use Components\Geolocation\AddressService;

class Store implements AddressService {

    public function getAddress(): string {
        return 'get.address.from.store';
    }

}