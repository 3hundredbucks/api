<?php

namespace Components\Geolocation;

interface GeoService {

    public function getCoordinates(string $address): string;

}