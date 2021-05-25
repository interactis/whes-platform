/* SQLEditor (Postgres)*/


CREATE TABLE article
(
id SERIAL,
content_id INTEGER,
created_at INTEGER,
updated_at INTEGER,
CONSTRAINT article_pkey PRIMARY KEY (id)
);

CREATE TABLE exhibit
(
id SERIAL,
type SMALLINT,
content_id INTEGER,
active BOOLEAN DEFAULT true,
created_at INTEGER,
updated_at INTEGER,
CONSTRAINT exhibit_pkey PRIMARY KEY (id)
);

CREATE TABLE exhibition_code
(
id SERIAL,
exhibition_code_series_id INTEGER,
code VARCHAR(6) NOT NULL UNIQUE ,
CONSTRAINT exhibition_code_pkey PRIMARY KEY (id)
);

CREATE TABLE heritage
(
id SERIAL,
geom GEOMETRY,
priority SMALLINT,
published BOOLEAN DEFAULT false,
hidden BOOLEAN DEFAULT false,
created_at INTEGER,
updated_at INTEGER,
CONSTRAINT heritage_pkey PRIMARY KEY (id)
);

CREATE TABLE admin
(
id SERIAL,
heritage_id INTEGER,
role SMALLINT,
email VARCHAR(255) UNIQUE ,
auth_key VARCHAR(32),
password_hash VARCHAR(255),
password_reset_token VARCHAR(255) UNIQUE ,
status SMALLINT DEFAULT 10,
created_at INTEGER,
updated_at INTEGER,
CONSTRAINT admin_pkey PRIMARY KEY (id)
);

CREATE TABLE exhibition_code_series
(
id SERIAL,
heritage_id INTEGER,
code_count INTEGER,
created_at INTEGER,
updated_at INTEGER,
CONSTRAINT exhibition_code_series_pkey PRIMARY KEY (id)
);

CREATE TABLE language
(
id SERIAL,
code VARCHAR(4),
name VARCHAR(150),
CONSTRAINT language_pkey PRIMARY KEY (id)
);

CREATE TABLE article_translation
(
id SERIAL,
article_id INTEGER,
language_id INTEGER,
slug VARCHAR(255),
title VARCHAR(255),
excerpt TEXT,
description TEXT,
youtube_id VARCHAR(255),
created_at INTEGER,
updated_at INTEGER,
CONSTRAINT article_translation_pkey PRIMARY KEY (id)
);

CREATE TABLE flag_translation
(
id SERIAL,
flag_id INTEGER,
language_id INTEGER,
title TEXT,
disclaimer TEXT,
created_at INTEGER,
updated_at INTEGER,
CONSTRAINT flag_translation_pkey PRIMARY KEY (id)
);

CREATE TABLE heritage_translation
(
id SERIAL,
heritage_id INTEGER,
language_id INTEGER,
slug VARCHAR(255),
name VARCHAR(255),
short_name VARCHAR(255),
description TEXT,
link_url VARCHAR(255),
link_text VARCHAR(255),
created_at INTEGER,
updated_at INTEGER,
CONSTRAINT heritage_translation_pkey PRIMARY KEY (id)
);

CREATE TABLE media_translation
(
id SERIAL,
media_id INTEGER,
language_id INTEGER,
title VARCHAR(150),
description VARCHAR(255),
author VARCHAR(150),
copyright VARCHAR(150),
created_at INTEGER,
updated_at INTEGER,
CONSTRAINT media_translation_pkey PRIMARY KEY (id)
);

CREATE TABLE media
(
id SERIAL,
heritage_id INTEGER,
content_id INTEGER,
page_id INTEGER,
filename VARCHAR(255),
exif TEXT,
"order" SMALLINT,
created_at INTEGER,
updated_at INTEGER,
CONSTRAINT media_pkey PRIMARY KEY (id)
);

CREATE TABLE poi
(
id SERIAL,
content_id INTEGER,
arrival_station VARCHAR(255),
arrival_url VARCHAR(255),
geom GEOMETRY,
created_at INTEGER,
updated_at INTEGER,
CONSTRAINT poi_pkey PRIMARY KEY (id)
);

CREATE TABLE poi_translation
(
id SERIAL,
poi_id INTEGER,
language_id INTEGER,
slug VARCHAR(255),
title VARCHAR(255),
description TEXT,
youtube_id VARCHAR(255),
directions TEXT,
remarks TEXT,
created_at INTEGER,
updated_at INTEGER,
CONSTRAINT poi_translation_pkey PRIMARY KEY (id)
);

CREATE TABLE route
(
id SERIAL,
content_id INTEGER,
difficulty SMALLINT,
distance_in_km SMALLINT,
duration_in_min SMALLINT,
min_altitude SMALLINT,
max_altitude SMALLINT,
start_altitude SMALLINT,
end_altitude SMALLINT,
ascent SMALLINT,
descent SMALLINT,
profile TEXT,
arrival_station VARCHAR(255),
arrival_url VARCHAR(255),
departure_station VARCHAR(255),
departure_url VARCHAR(255),
geom GEOMETRY,
print_available BOOLEAN DEFAULT false,
created_at INTEGER,
updated_at INTEGER,
CONSTRAINT route_pkey PRIMARY KEY (id)
);

CREATE TABLE route_translation
(
id SERIAL,
route_id INTEGER,
language_id INTEGER,
slug VARCHAR(255),
title VARCHAR(255),
description TEXT,
youtube_id VARCHAR(255),
catering TEXT,
options TEXT,
directions TEXT,
remarks TEXT,
created_at INTEGER,
updated_at INTEGER,
CONSTRAINT route_translation_pkey PRIMARY KEY (id)
);

CREATE TABLE rucksack
(
id SERIAL,
code VARCHAR(6),
wnf_access_at INTEGER,
web_access_at INTEGER,
created_at INTEGER,
updated_at INTEGER,
CONSTRAINT rucksack_pkey PRIMARY KEY (id)
);

CREATE TABLE tag
(
id SERIAL,
active BOOLEAN DEFAULT true,
created_at INTEGER,
updated_at INTEGER,
CONSTRAINT tag_pkey PRIMARY KEY (id)
);

CREATE TABLE content_tag
(
id SERIAL,
content_id INTEGER,
tag_id INTEGER,
created_at INTEGER,
updated_at INTEGER,
CONSTRAINT content_tag_pkey PRIMARY KEY (id)
);

CREATE TABLE tag_translation
(
id SERIAL,
tag_id INTEGER,
language_id INTEGER,
title VARCHAR(255),
description TEXT,
created_at INTEGER,
updated_at INTEGER,
CONSTRAINT tag_translation_pkey PRIMARY KEY (id)
);

CREATE TABLE valid_time
(
id SERIAL,
title VARCHAR(255),
start_time TIME,
start_day SMALLINT,
start_month SMALLINT,
start_year SMALLINT,
end_time TIME,
end_day SMALLINT,
end_month SMALLINT,
end_year SMALLINT,
reuse SMALLINT,
CONSTRAINT valid_time_pkey PRIMARY KEY (id)
);

CREATE TABLE content_valid_time
(
id SERIAL,
valid_time_id INTEGER,
content_id INTEGER,
created_at INTEGER,
updated_at INTEGER,
CONSTRAINT content_valid_time_pkey PRIMARY KEY (id)
);

CREATE TABLE content_flag
(
id SERIAL,
content_id INTEGER,
flag_id INTEGER,
created_at INTEGER,
updated_at INTEGER,
CONSTRAINT content_flag_pkey PRIMARY KEY (id)
);

CREATE TABLE flag_group
(
id SERIAL,
"order" SMALLINT,
hidden BOOLEAN DEFAULT false,
created_at INTEGER,
updated_at INTEGER,
CONSTRAINT flag_group_pkey PRIMARY KEY (id)
);

CREATE TABLE content
(
id SERIAL,
heritage_id INTEGER,
type SMALLINT,
priority SMALLINT,
published BOOLEAN DEFAULT false,
featured BOOLEAN DEFAULT false,
hidden BOOLEAN DEFAULT false,
created_at INTEGER,
updated_at INTEGER,
CONSTRAINT content_pkey PRIMARY KEY (id)
);

CREATE TABLE flag_group_translation
(
id SERIAL,
flag_group_id INTEGER,
language_id INTEGER,
title TEXT,
created_at INTEGER,
updated_at INTEGER,
CONSTRAINT flag_group_translation_pkey PRIMARY KEY (id)
);

CREATE TABLE page
(
id SERIAL,
name VARCHAR(255),
created_at INTEGER,
updated_at INTEGER,
CONSTRAINT page_pkey PRIMARY KEY (id)
);

CREATE TABLE page_translation
(
id SERIAL,
page_id INTEGER,
language_id INTEGER,
slug VARCHAR(255),
title VARCHAR(255),
description TEXT,
created_at INTEGER,
updated_at INTEGER,
CONSTRAINT page_translation_pkey PRIMARY KEY (id)
);

CREATE TABLE ambassador_translation
(
id SERIAL,
heritage_id INTEGER,
poi_id INTEGER,
type INTEGER,
image_name VARCHAR(38),
firstname VARCHAR(255),
lastname VARCHAR(255),
zip VARCHAR(10),
city VARCHAR(150),
favorite_place VARCHAR(150),
quote TEXT,
created_at INTEGER,
updated_at INTEGER,
CONSTRAINT ambassador_translation_pkey PRIMARY KEY (id)
);

CREATE TABLE exhibit_rucksack
(
id SERIAL,
"rucksackId" INTEGER,
exhibit_id INTEGER,
content_id INTEGER,
created_at INTEGER,
updated_at INTEGER,
CONSTRAINT exhibit_rucksack_pkey PRIMARY KEY (id)
);

CREATE TABLE supplier
(
id SERIAL,
content_id INTEGER,
street VARCHAR(255),
street_number VARCHAR(10),
address_addition VARCHAR(255),
zip VARCHAR(10),
city VARCHAR(150),
url VARCHAR(255),
email VARCHAR(255),
phone VARCHAR(50),
geom GEOMETRY,
created_at INTEGER,
updated_at INTEGER,
CONSTRAINT supplier_pkey PRIMARY KEY (id)
);

CREATE TABLE supplier_translation
(
id SERIAL,
supplier_id INTEGER,
language_id INTEGER,
name VARCHAR(150),
name_affix VARCHAR(150),
remarks TEXT,
created_at INTEGER,
updated_at INTEGER,
CONSTRAINT supplier_translation_pkey PRIMARY KEY (id)
);

CREATE TABLE flag
(
id SERIAL,
flag_group_id INTEGER,
label BOOLEAN DEFAULT false,
hidden BOOLEAN DEFAULT false,
"order" SMALLINT,
created_at INTEGER,
updated_at INTEGER,
CONSTRAINT flag_pkey PRIMARY KEY (id)
);

CREATE TABLE related_tag
(
id SERIAL,
tag_id INTEGER,
related_tag_id INTEGER,
created_at INTEGER,
updated_at INTEGER,
CONSTRAINT related_tag_pkey PRIMARY KEY (id)
);

ALTER TABLE article ADD FOREIGN KEY (content_id) REFERENCES content (id) ON DELETE CASCADE;

ALTER TABLE exhibit ADD FOREIGN KEY (content_id) REFERENCES content (id) ON DELETE CASCADE;

ALTER TABLE exhibition_code ADD FOREIGN KEY (exhibition_code_series_id) REFERENCES exhibition_code_series (id) ON DELETE CASCADE;

ALTER TABLE admin ADD FOREIGN KEY (heritage_id) REFERENCES heritage (id) ON DELETE CASCADE;

ALTER TABLE exhibition_code_series ADD FOREIGN KEY (heritage_id) REFERENCES heritage (id) ON DELETE CASCADE;

ALTER TABLE article_translation ADD FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE;

ALTER TABLE article_translation ADD FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE;

CREATE INDEX article_translation_slug_idx ON article_translation(slug);

ALTER TABLE flag_translation ADD FOREIGN KEY (flag_id) REFERENCES flag (id) ON DELETE CASCADE;

ALTER TABLE flag_translation ADD FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE;

ALTER TABLE heritage_translation ADD FOREIGN KEY (heritage_id) REFERENCES heritage (id) ON DELETE CASCADE;

ALTER TABLE heritage_translation ADD FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE;

CREATE INDEX heritage_translation_slug_idx ON heritage_translation(slug);

ALTER TABLE media_translation ADD FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE;

ALTER TABLE media_translation ADD FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE;

ALTER TABLE media ADD FOREIGN KEY (heritage_id) REFERENCES heritage (id) ON DELETE CASCADE;

ALTER TABLE media ADD FOREIGN KEY (content_id) REFERENCES content (id) ON DELETE CASCADE;

ALTER TABLE media ADD FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE;

ALTER TABLE poi ADD FOREIGN KEY (content_id) REFERENCES content (id) ON DELETE CASCADE;

ALTER TABLE poi_translation ADD FOREIGN KEY (poi_id) REFERENCES poi (id) ON DELETE CASCADE;

ALTER TABLE poi_translation ADD FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE;

CREATE INDEX poi_translation_slug_idx ON poi_translation(slug);

ALTER TABLE route ADD FOREIGN KEY (content_id) REFERENCES content (id) ON DELETE CASCADE;

ALTER TABLE route_translation ADD FOREIGN KEY (route_id) REFERENCES route (id) ON DELETE CASCADE;

ALTER TABLE route_translation ADD FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE;

CREATE INDEX route_translation_slug_idx ON route_translation(slug);

CREATE INDEX rucksack_code_idx ON rucksack(code);

ALTER TABLE content_tag ADD FOREIGN KEY (content_id) REFERENCES content (id) ON DELETE CASCADE;

ALTER TABLE content_tag ADD FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE;

ALTER TABLE tag_translation ADD FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE;

ALTER TABLE tag_translation ADD FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE;

ALTER TABLE content_valid_time ADD FOREIGN KEY (valid_time_id) REFERENCES valid_time (id) ON DELETE CASCADE;

ALTER TABLE content_valid_time ADD FOREIGN KEY (content_id) REFERENCES content (id) ON DELETE CASCADE;

ALTER TABLE content_flag ADD FOREIGN KEY (content_id) REFERENCES content (id) ON DELETE CASCADE;

ALTER TABLE content_flag ADD FOREIGN KEY (flag_id) REFERENCES flag (id) ON DELETE CASCADE;

ALTER TABLE content ADD FOREIGN KEY (heritage_id) REFERENCES heritage (id) ON DELETE CASCADE;

ALTER TABLE flag_group_translation ADD FOREIGN KEY (flag_group_id) REFERENCES flag_group (id) ON DELETE CASCADE;

ALTER TABLE flag_group_translation ADD FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE;

ALTER TABLE page_translation ADD FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE;

ALTER TABLE page_translation ADD FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE;

CREATE INDEX page_translation_slug_idx ON page_translation(slug);

ALTER TABLE ambassador_translation ADD FOREIGN KEY (heritage_id) REFERENCES heritage (id) ON DELETE CASCADE;

ALTER TABLE ambassador_translation ADD FOREIGN KEY (poi_id) REFERENCES poi (id) ON DELETE CASCADE;

ALTER TABLE exhibit_rucksack ADD FOREIGN KEY ("rucksackId") REFERENCES rucksack (id) ON DELETE CASCADE;

ALTER TABLE exhibit_rucksack ADD FOREIGN KEY (exhibit_id) REFERENCES exhibit (id) ON DELETE CASCADE;

ALTER TABLE exhibit_rucksack ADD FOREIGN KEY (content_id) REFERENCES content (id) ON DELETE CASCADE;

ALTER TABLE supplier ADD FOREIGN KEY (content_id) REFERENCES content (id) ON DELETE CASCADE;

ALTER TABLE supplier_translation ADD FOREIGN KEY (supplier_id) REFERENCES supplier (id) ON DELETE CASCADE;

ALTER TABLE supplier_translation ADD FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE;

ALTER TABLE flag ADD FOREIGN KEY (flag_group_id) REFERENCES flag_group (id) ON DELETE CASCADE;

ALTER TABLE related_tag ADD FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE;

ALTER TABLE related_tag ADD FOREIGN KEY (related_tag_id) REFERENCES tag (id) ON DELETE CASCADE;






/* Insert data */

INSERT INTO language (code, name) VALUES ('de', 'Deutsch');
INSERT INTO language (code, name) VALUES ('en', 'English');
INSERT INTO language (code, name) VALUES ('fr', 'Français');
INSERT INTO language (code, name) VALUES ('it', 'Italiano');


INSERT INTO page (name, created_at, updated_at) VALUES ('Homepage', 1619796019, 1619796019);
INSERT INTO page (name) VALUES ('About');
INSERT INTO page (name) VALUES ('Legal Notice');

INSERT INTO page_translation (page_id, language_id) VALUES (1, 1);
INSERT INTO page_translation (page_id, language_id) VALUES (1, 2);
INSERT INTO page_translation (page_id, language_id) VALUES (1, 3);
INSERT INTO page_translation (page_id, language_id) VALUES (1, 4);

INSERT INTO page_translation (page_id, language_id, slug) VALUES (2, 1, 'about');
INSERT INTO page_translation (page_id, language_id, slug) VALUES (2, 2, 'about');
INSERT INTO page_translation (page_id, language_id, slug) VALUES (2, 3, 'about');
INSERT INTO page_translation (page_id, language_id, slug) VALUES (2, 4, 'about');

INSERT INTO page_translation (page_id, language_id, slug) VALUES (3, 1, 'terms');
INSERT INTO page_translation (page_id, language_id, slug) VALUES (3, 2, 'terms');
INSERT INTO page_translation (page_id, language_id, slug) VALUES (3, 3, 'terms');
INSERT INTO page_translation (page_id, language_id, slug) VALUES (3, 4, 'terms');
