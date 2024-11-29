<?php

include_once('pages/functions.php');
include_once('pages/dbConnection.php');

$conn = connectDb();

$createCountries = "CREATE TABLE IF NOT EXISTS public.countries
(
    id serial,
    country character varying(64) NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT country_unique UNIQUE (country)
);";

$createCities = "CREATE TABLE IF NOT EXISTS public.cities
(
    id serial,
    city character varying(64) NOT NULL,
    country_id integer NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT city_unique UNIQUE (city, country_id),
    CONSTRAINT country_fk FOREIGN KEY (country_id)
        REFERENCES public.countries (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE CASCADE
        NOT VALID
);";

$createHotels = "CREATE TABLE IF NOT EXISTS public.hotels
(
    id serial,
    hotel character varying(64) NOT NULL,
    country_id integer NOT NULL,
    city_id integer NOT NULL,
    stars integer NOT NULL,
    cost integer NOT NULL,
    info character varying(1024),
    PRIMARY KEY (id),
    CONSTRAINT country_fk FOREIGN KEY (country_id)
        REFERENCES public.countries (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID,
    CONSTRAINT city_fk FOREIGN KEY (city_id)
        REFERENCES public.cities (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID
);";

$createImages = "CREATE TABLE IF NOT EXISTS public.images
(
    id serial,
    image_path character varying(255) NOT NULL,
    hotel_id integer NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT hotel_fk FOREIGN KEY (hotel_id)
        REFERENCES public.hotels (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID
);";

$createRoles = "CREATE TABLE IF NOT EXISTS public.roles
(
    id serial,
    role character varying(64) NOT NULL,
    PRIMARY KEY (id)
);";

$createUsers = "CREATE TABLE IF NOT EXISTS public.users
(
    id serial,
    login character varying(32) NOT NULL,
    password character varying(128) NOT NULL,
    email character varying(128) NOT NULL,
    discount integer,
    role_id integer NOT NULL,
    profile_picture character varying,
    PRIMARY KEY (id),
    CONSTRAINT role_fk FOREIGN KEY (role_id)
        REFERENCES public.roles (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID
);";

$tables = [$createCountries, $createCities, $createHotels, $createImages, $createRoles, $createUsers];
foreach ($tables as $table) {
    $conn->exec($table);
}

echo 'All tables have been created';
$conn = null;

