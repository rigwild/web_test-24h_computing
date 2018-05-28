CREATE TABLE account (
  id_user serial PRIMARY KEY,
  username varchar(200) NOT NULL,
  password varchar(200) NOT NULL,
  timestamp_creation timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  active boolean DEFAULT 't',
  banned boolean DEFAULT 'f'
);

CREATE TABLE event (
  id_event varchar(200) NOT NULL PRIMARY KEY,
  title varchar(200) NOT NULL,
  description varchar(500) NOT NULL,
  timestamp_creation timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  event_date timestamp NOT NULL,
  place_gmapid varchar(200) NOT NULL,
  id_author int NOT NULL REFERENCES account(id_user),
  is_public boolean DEFAULT 't',
  id_event_before varchar(200) REFERENCES event(id_event),
  id_event_after varchar(200) REFERENCES event(id_event)
);

CREATE TABLE event_part (
  id_event_part serial PRIMARY KEY,
  id_event varchar(200) REFERENCES event(id_event),
  id_author int NOT NULL REFERENCES account(id_user),
  msg_inscription varchar(300) DEFAULT '',
  validated boolean DEFAULT 't'
);