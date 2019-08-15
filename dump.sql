CREATE TABLE "services"
(
  id serial NOT NULL,
  user_id integer NOT NULL,
  tarif_id integer NOT NULL,
  payday date NOT NULL,
  CONSTRAINT services_pkey PRIMARY KEY (id)
);

CREATE TABLE "tarifs"
(
  id serial NOT NULL,
  title varchar NOT NULL,
  price numeric NOT NULL,
  link varchar NOT NULL,
  speed integer NOT NULL,
  pay_period integer NOT NULL,
  tarif_group_id integer NOT NULL,
  CONSTRAINT tarifs_pkey PRIMARY KEY (id)
);

CREATE TABLE "users"
(
  id serial NOT NULL,
  login varchar NOT NULL,
  name_last varchar NOT NULL,
  name_first varchar NOT NULL,
  CONSTRAINT users_pkey PRIMARY KEY (id)
);


INSERT INTO services (ID, user_id, tarif_id, payday) VALUES
(1, 1, 1, '2018-12-06'),
(2, 2, 3, '2018-12-06');


INSERT INTO tarifs (ID, title, price, link, speed, pay_period, tarif_group_id) VALUES
(1, 'Земля', '500.0000', 'http://www.sknt.ru/tarifi_internet/in/1.htm', 50, 1, 1),
(2, 'Земля (3 мес)', 1350, 'http://www.sknt.ru/tarifi_internet/in/1.htm', 50, 3, 1),
(3, 'Земля (12 мес)', 4200, 'http://www.sknt.ru/tarifi_internet/in/1.htm', 50, 12, 1),
(4, 'Вода', 600, 'http://www.sknt.ru/tarifi_internet/in/2.htm', 100, 1, 3),
(5, 'Вода (3 мес)', 1650, 'http://www.sknt.ru/tarifi_internet/in/2.htm', 100, 3, 3),
(6, 'Вода (12 мес)', 5400, 'http://www.sknt.ru/tarifi_internet/in/2.htm', 100, 12, 3);


INSERT INTO users (ID, login, name_last, name_first) VALUES
(1, 'test1', 'Петров', 'Василий'),
(2, 'test2', 'Васнецов', 'Пётр');