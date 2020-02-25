DROP SCHEMA IF EXISTS flyschema CASCADE;

CREATE SCHEMA flyschema;

CREATE TABLE flyschema.flight (
  id                    SERIAL,
  created_at            TIMESTAMP WITHOUT TIME ZONE   NOT NULL DEFAULT now(),
  updated_at            TIMESTAMP WITHOUT TIME ZONE   NULL,
  takeoff_time          TIMESTAMP                     NOT NULL,
  landing_time          TIMESTAMP                     NULL,
  flight_duration       TSRANGE                       NULL,
  depart_city           INTEGER                       NOT NULL,
  arrival_city          INTEGER                       NOT NULL,
  free_seats            INTEGER                       NOT NULL,
  seat_price            NUMERIC                       NULL,
  pilot                 INTEGER                       NOT NULL,
  was_done              BOOLEAN                       NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (depart_city) REFERENCES flyschema.airport(id) ON DELETE CASCADE,
  FOREIGN KEY (arrival_city) REFERENCES flyschema.airport(id) ON DELETE CASCADE,
  FOREIGN KEY (pilot) REFERENCES flyschema.user(id) ON DELETE CASCADE
);

CREATE TABLE flyschema.airport (
  id             SERIAL,
  name           VARCHAR(255)                  NOT NULL,
  icao           VARCHAR(4)                    NOT NULL,
  coordinates    POINT                         NULL,
  address        VARCHAR(255)                  NULL,
  city           VARCHAR(255)                  NULL,
  country        VARCHAR(255)                  NULL,
  PRIMARY KEY (id)
);

CREATE TABLE flyschema.user (
  id                    SERIAL,
  created_at            TIMESTAMP WITHOUT TIME ZONE   NOT NULL DEFAULT now(),
  updated_at            TIMESTAMP WITHOUT TIME ZONE   NULL,
  username              VARCHAR(255)                  NOT NULL,
  lastname              VARCHAR(255)                  NOT NULL,
  firstname             VARCHAR(255)                  NOT NULL,
  password              VARCHAR(255)                  NOT NULL,
  email                 VARCHAR(255)                  NOT NULL UNIQUE,
  role                  VARCHAR(16)                   NOT NULL,
  is_certified_pilot    BOOLEAN                       NULL,
  PRIMARY KEY (id)
);

CREATE TABLE flyschema.reservation (
  id                    SERIAL,
  created_at            TIMESTAMP WITHOUT TIME ZONE   NOT NULL DEFAULT now(),
  updated_at            TIMESTAMP WITHOUT TIME ZONE   NULL,
  flight                INTEGER                       NOT NULL,
  passenger             INTEGER                       NOT NULL,
  reserved_seats        INTEGER                       NOT NULL,
  is_paid               BOOLEAN                       NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (flight) REFERENCES flyschema.flight(id) ON DELETE CASCADE,
  FOREIGN KEY (passenger) REFERENCES flyschema.user(id) ON DELETE CASCADE
);

CREATE TABLE flyschema.review (
  id                    SERIAL,
  created_at            TIMESTAMP WITHOUT TIME ZONE   NOT NULL DEFAULT now(),
  updated_at            TIMESTAMP WITHOUT TIME ZONE   NULL,
  flight                INTEGER                       NOT NULL,
  reviewed_pilot        INTEGER                       NOT NULL,
  comment               TEXT                          NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (flight) REFERENCES flyschema.flight(id) ON DELETE CASCADE,
  FOREIGN KEY (reviewed_pilot) REFERENCES flyschema.user(id) ON DELETE CASCADE
);
