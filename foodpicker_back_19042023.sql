--
-- PostgreSQL database dump
--

-- Dumped from database version 15.2 (Debian 15.2-1.pgdg110+1)
-- Dumped by pg_dump version 15.2 (Debian 15.2-1.pgdg110+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: coupons; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.coupons (
    id integer NOT NULL,
    restaurant_id integer,
    receive_date timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    expiration_date timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    amount integer NOT NULL,
    redeemed boolean DEFAULT false
);


ALTER TABLE public.coupons OWNER TO postgres;

--
-- Name: coupons_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.coupons_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.coupons_id_seq OWNER TO postgres;

--
-- Name: doctrine_migration_versions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.doctrine_migration_versions (
    version character varying(191) NOT NULL,
    executed_at timestamp(6) without time zone DEFAULT NULL::timestamp without time zone,
    execution_time integer
);


ALTER TABLE public.doctrine_migration_versions OWNER TO postgres;

--
-- Name: orders; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.orders (
    id integer NOT NULL,
    restaurant_id integer,
    commiter_id integer,
    order_time timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    delivery_time timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    total_price integer NOT NULL,
    total_items integer NOT NULL,
    faulty boolean NOT NULL,
    bonus boolean NOT NULL,
    driver_needed_help boolean NOT NULL,
    score integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.orders OWNER TO postgres;

--
-- Name: orders_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.orders_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.orders_id_seq OWNER TO postgres;

--
-- Name: restaurants; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.restaurants (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    categories json,
    shop_url character varying(255) NOT NULL,
    logo_file character varying(255) NOT NULL,
    logo_url character varying(255) NOT NULL,
    background_file character varying(255) DEFAULT NULL::character varying,
    background_url character varying(255) DEFAULT NULL::character varying
);


ALTER TABLE public.restaurants OWNER TO postgres;

--
-- Name: restaurants_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.restaurants_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.restaurants_id_seq OWNER TO postgres;

--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id integer NOT NULL,
    username character varying(180) NOT NULL,
    roles json NOT NULL,
    password character varying(255) NOT NULL,
    user_profile_picture_url character varying(255) NOT NULL,
    banned boolean NOT NULL
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO postgres;

--
-- Data for Name: coupons; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.coupons (id, restaurant_id, receive_date, expiration_date, amount, redeemed) FROM stdin;
\.


--
-- Data for Name: doctrine_migration_versions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.doctrine_migration_versions (version, executed_at, execution_time) FROM stdin;
DoctrineMigrations\\Version20230215185624	2023-02-21 20:45:56.789571	51
\.


--
-- Data for Name: orders; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.orders (id, restaurant_id, commiter_id, order_time, delivery_time, total_price, total_items, faulty, bonus, driver_needed_help, score) FROM stdin;
1	2	\N	2023-07-19 13:16:00	2023-07-19 14:00:00	4894	6	f	f	f	10
2	5	\N	2023-07-20 11:59:00	2023-07-20 13:30:00	5632	5	f	f	f	8
3	15	\N	2023-07-21 10:37:00	2023-07-21 11:45:00	6887	7	f	f	f	13
4	1	\N	2023-07-25 11:38:00	2023-07-25 12:15:00	4945	4	f	f	f	10
5	13	\N	2023-07-27 10:33:00	2023-07-27 11:45:00	3680	4	f	f	f	13
6	9	\N	2023-07-29 10:58:00	2023-07-29 11:45:00	4965	4	f	f	f	13
7	1	\N	2023-08-01 11:07:00	2023-08-01 11:55:00	5045	4	f	f	f	13
8	15	\N	2023-08-02 11:16:00	2023-08-02 12:00:00	4780	5	f	f	f	13
9	4	\N	2023-08-03 10:21:00	2023-08-03 12:00:00	1950	2	f	f	f	11
10	1	\N	2023-08-09 09:54:00	2023-08-09 11:45:00	4250	7	f	f	f	11
11	1	\N	2023-08-11 11:00:00	2023-08-11 11:45:00	5600	6	f	f	f	13
12	5	\N	2023-08-12 11:25:00	2023-08-12 12:15:00	4950	7	f	f	f	10
13	1	\N	2023-08-15 10:14:00	2023-08-15 11:45:00	2670	3	f	f	f	11
14	16	\N	2023-08-16 11:34:00	2023-08-16 12:30:00	3600	4	f	f	f	10
15	3	\N	2023-08-19 10:40:00	2023-08-19 12:45:00	3050	4	f	f	f	8
16	1	\N	2023-08-22 11:11:00	2023-08-22 12:00:00	2430	3	f	f	f	13
17	15	\N	2023-08-23 11:47:00	2023-08-23 12:30:00	4350	5	f	f	f	10
18	5	\N	2023-08-26 09:19:00	2023-08-26 11:45:00	4110	6	f	f	f	11
19	1	\N	2023-08-29 11:42:00	2023-08-29 12:30:00	3140	5	f	f	f	10
20	17	\N	2023-08-31 11:50:00	2023-08-31 12:30:00	4010	5	f	f	f	10
21	10	\N	2023-09-05 10:50:00	2023-09-05 12:45:00	2430	3	f	f	f	8
22	1	\N	2023-09-06 10:31:00	2023-09-06 11:45:00	3630	3	f	f	f	13
23	15	\N	2023-09-09 09:53:00	2023-09-09 11:45:00	4159	4	f	f	f	11
24	15	\N	2023-09-12 10:55:00	2023-09-12 11:45:00	2669	2	f	f	f	13
25	8	\N	2023-09-13 09:56:00	2023-09-13 11:45:00	2497	3	f	f	f	11
26	1	\N	2023-09-14 11:46:00	2023-09-14 12:30:00	3760	5	f	f	f	10
27	1	\N	2023-09-22 09:24:00	2023-09-22 11:45:00	3040	4	f	f	f	11
28	11	\N	2023-09-23 10:27:00	2023-09-23 12:45:00	4690	6	f	f	f	8
29	4	\N	2023-09-26 11:03:00	2023-09-26 11:45:00	2300	4	f	f	f	13
30	1	\N	2023-09-27 11:16:00	2023-09-27 12:15:00	2400	3	f	f	f	10
31	1	\N	2023-09-28 10:52:00	2023-09-28 11:45:00	2600	3	f	f	f	13
32	14	\N	2023-09-29 11:42:00	2023-09-29 12:45:00	4600	4	f	f	f	10
33	11	\N	2023-09-30 11:18:00	2023-09-30 12:45:00	3090	5	f	f	f	10
34	15	\N	2023-10-04 11:09:00	2023-10-04 11:45:00	3059	3	f	f	f	13
35	11	\N	2023-10-07 12:18:00	2023-10-07 12:45:00	3130	2	f	f	f	10
36	16	\N	2023-10-11 11:35:00	2023-10-11 12:30:00	2380	2	f	f	f	10
37	4	\N	2023-10-12 11:33:00	2023-10-12 11:45:00	5980	7	f	f	f	13
38	7	\N	2023-10-14 11:09:00	2023-10-14 12:00:00	2659	3	f	f	f	13
39	7	\N	2023-10-18 11:07:00	2023-10-18 12:00:00	2814	2	f	f	f	13
40	1	\N	2023-10-20 10:36:00	2023-10-20 11:45:00	4600	7	f	f	f	13
41	1	\N	2023-10-24 11:06:00	2023-10-24 11:58:00	4125	6	f	f	f	13
42	11	\N	2023-10-28 09:56:00	2023-10-28 12:38:00	4120	5	f	f	f	8
43	15	\N	2023-11-03 12:01:00	2023-11-03 13:00:00	5930	5	f	f	f	10
44	1	\N	2023-11-04 11:03:00	2023-11-04 11:45:00	5800	8	f	f	f	13
45	1	\N	2023-11-07 11:05:00	2023-11-07 11:55:00	2775	3	f	f	f	13
46	5	\N	2023-11-08 11:11:00	2023-11-08 11:44:00	3430	4	f	f	f	13
47	11	\N	2023-11-09 11:02:00	2023-11-09 12:45:00	2860	4	f	f	f	8
48	1	\N	2023-11-10 10:31:00	2023-11-10 12:00:00	4400	6	f	f	f	13
49	7	\N	2023-11-11 11:13:00	2023-11-11 12:01:00	5019	4	f	f	f	10
50	1	\N	2023-11-14 11:04:00	2023-11-14 11:51:00	4200	6	f	f	f	13
51	4	\N	2023-11-15 11:28:00	2023-11-15 11:55:00	3270	4	f	f	f	13
52	1	\N	2023-11-21 11:07:00	2023-11-21 12:00:00	3180	4	f	f	f	13
53	7	\N	2023-11-30 12:00:00	2023-11-30 12:50:00	3939	3	f	f	f	10
54	1	\N	2023-12-05 12:08:00	2023-12-05 12:55:00	3115	3	f	f	f	10
55	4	\N	2023-12-06 12:06:00	2023-12-06 12:50:00	2530	3	f	f	f	10
56	11	\N	2023-12-09 11:44:00	2023-12-09 12:45:00	1540	2	f	f	f	10
57	15	\N	2023-12-12 10:35:00	2023-12-12 11:45:00	1989	2	f	f	f	13
58	1	\N	2023-12-16 11:00:00	2023-12-16 11:45:00	6350	9	f	f	f	13
59	11	\N	2023-12-19 10:56:00	2023-12-19 12:45:00	2530	2	f	f	f	8
60	4	\N	2023-12-20 11:00:00	2023-12-20 12:00:00	2220	2	f	f	f	13
61	16	\N	2023-12-23 11:00:00	2023-12-23 12:00:00	2380	2	f	f	f	13
62	1	\N	2023-12-29 11:00:00	2023-12-29 12:00:00	3250	2	f	f	f	13
63	4	\N	2023-01-02 11:00:00	2023-01-02 12:00:00	3000	4	f	f	f	13
64	1	\N	2023-01-03 11:00:00	2023-01-03 12:00:00	3380	5	f	f	f	13
65	16	\N	2023-01-09 11:00:00	2023-01-09 12:00:00	4290	5	f	f	f	13
66	1	\N	2023-01-10 11:00:00	2023-01-10 12:00:00	3910	5	f	f	f	13
67	16	\N	2023-01-16 11:00:00	2023-01-16 12:00:00	3470	3	f	f	f	13
68	1	\N	2023-01-19 11:00:00	2023-01-19 12:00:00	9320	10	f	f	f	13
69	1	\N	2023-02-03 11:00:00	2023-02-03 12:00:00	4620	6	f	f	f	13
70	16	\N	2023-02-06 11:00:00	2023-02-06 12:00:00	3100	4	f	f	f	13
71	1	\N	2023-02-10 11:00:00	2023-02-10 12:00:00	4520	8	f	f	f	13
72	16	\N	2023-02-16 11:00:00	2023-02-16 12:00:00	5350	7	f	f	f	13
73	1	\N	2023-02-17 11:00:00	2023-02-17 12:00:00	4140	6	f	f	f	13
74	4	\N	2023-02-21 11:00:00	2023-02-21 12:00:00	3160	3	f	f	f	13
75	18	\N	2023-11-16 11:00:00	2023-11-16 12:00:00	4050	5	f	f	f	13
76	18	\N	2023-11-18 11:00:00	2023-11-18 12:00:00	4150	6	f	f	f	13
77	19	\N	2023-11-28 11:00:00	2023-11-28 12:00:00	2448	2	f	f	f	13
78	20	\N	2023-11-29 11:00:00	2023-11-29 12:00:00	2450	2	f	f	f	13
79	20	\N	2023-12-13 11:00:00	2023-12-13 12:00:00	4071	5	f	f	f	13
80	19	\N	2023-12-28 11:00:00	2023-12-28 12:00:00	2400	4	f	f	f	13
81	21	\N	2023-12-30 11:00:00	2023-12-30 12:00:00	2580	2	f	f	f	13
82	20	\N	2023-01-11 11:00:00	2023-01-11 12:00:00	3599	3	f	f	f	13
83	20	\N	2023-01-30 11:00:00	2023-01-30 12:00:00	3349	3	f	f	f	13
84	20	\N	2023-02-07 11:00:00	2023-02-07 12:00:00	4849	4	f	f	f	13
85	20	\N	2023-02-20 11:00:00	2023-02-20 12:00:00	3699	3	f	f	f	13
86	22	\N	2023-02-27 11:00:00	2023-02-27 12:00:00	2780	2	f	f	f	13
87	22	\N	2023-03-02 11:00:00	2023-03-02 12:00:00	4620	5	f	f	f	13
88	16	\N	2023-03-08 11:00:00	2023-03-08 12:00:00	2510	3	f	f	f	13
89	1	\N	2023-03-14 11:00:00	2023-03-14 12:00:00	3740	4	f	f	f	13
90	19	\N	2023-03-17 11:00:00	2023-03-17 12:00:00	3547	4	f	f	f	13
91	16	\N	2023-03-20 11:00:00	2023-03-20 12:00:00	3060	3	f	f	f	13
92	1	\N	2023-03-21 11:00:00	2023-03-21 12:00:00	4410	5	f	f	f	13
93	24	\N	2023-03-22 11:00:00	2023-03-22 12:00:00	2600	2	f	f	f	13
94	24	\N	2023-03-28 11:00:00	2023-03-28 12:00:00	2370	3	f	f	f	13
95	1	\N	2023-04-03 11:00:00	2023-04-03 12:00:00	2820	4	f	f	f	13
96	24	\N	2023-04-04 11:00:00	2023-04-04 12:00:00	2600	2	f	f	f	13
97	16	\N	2023-04-05 11:00:00	2023-04-05 12:00:00	3160	3	f	f	f	13
\.


--
-- Data for Name: restaurants; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.restaurants (id, name, categories, shop_url, logo_file, logo_url, background_file, background_url) FROM stdin;
1	Haki's Burger & Pide	["Burger","T\\u00fcrkisch","Salate"]	https://www.lieferando.de/speisekarte/hakis	/tmp/php1SDPln	assets/img/restaurants/logo Haki's Burger & Pide.png	/tmp/phpCBVbHp	assets/img/restaurants/background Haki's Burger & Pide.jpg
2	2 Brüder Pizza & Pasta	["Burger","Italienische Pizza","Pasta"]	https://www.lieferando.de/speisekarte/2-brueder-pizza-pasta	/tmp/phpGiDs3o	assets/img/restaurants/logo 2 Brüder Pizza & Pasta.png	/tmp/php8teoKm	assets/img/restaurants/background 2 Brüder Pizza & Pasta.jpg
3	Pizza- und Nudelhaus Amore	["Italienische Pizza","Mittagsangebote"]	https://www.lieferando.de/speisekarte/pizzeria-amore-40589	/tmp/phptcpCEp	assets/img/restaurants/logo Pizza- und Nudelhaus Amore.png	/tmp/php6agY9o	assets/img/restaurants/background Pizza- und Nudelhaus Amore.jpg
4	Asia China Imbiss	["Chinesisch","Japanisch","Thail\\u00e4ndisch"]	https://www.lieferando.de/speisekarte/asia-china-imbiss-eurasia-duesseldorf	/tmp/phpMwMHGm	assets/img/restaurants/logo Asia China Imbiss.png	/tmp/phpLdOpJn	assets/img/restaurants/background Asia China Imbiss.jpg
5	Asia Thai	["Asiatisch","Chinesisch","Thail\\u00e4ndisch"]	https://www.lieferando.de/speisekarte/asia-thai-henkelstrasse	/tmp/php36Qk9q	assets/img/restaurants/logo Asia Thai.png	/tmp/phprT7Abr	assets/img/restaurants/background Asia Thai.jpg
6	Grill Taverne Athos	["Griechisch","Italienisch","Italienische Pizza"]	https://www.lieferando.de/speisekarte/grill-taverne-athos	/tmp/php1qPSOn	assets/img/restaurants/logo Grill Taverne Athos.png	/tmp/php32qgSn	assets/img/restaurants/background Grill Taverne Athos.jpg
7	Celery Bar	["Salate","Poke bowl","Wraps"]	https://www.lieferando.de/speisekarte/celery-bar	/tmp/phpMOmSKp	assets/img/restaurants/logo Celery Bar.png	/tmp/phpUdJSAn	assets/img/restaurants/background Celery Bar.jpg
8	Chicos - Burritos & Quesadillas	["Mexikanisch","Vegan","Vegetarisch"]	https://www.lieferando.de/speisekarte/chicos-burritos-quesadillas-duesseldorf	/tmp/phpJFT13q	assets/img/restaurants/logo Chicos - Burritos & Quesadillas.png	/tmp/php47b03q	assets/img/restaurants/background Chicos - Burritos & Quesadillas.jpg
9	finefine	["Vegan","Poke bowl","Bio"]	https://www.lieferando.de/speisekarte/finefine-healthy-food-duesseldorf-sued	/tmp/phpGQXqXo	assets/img/restaurants/logo finefine.png	/tmp/phpIHXiAn	assets/img/restaurants/background finefine.jpg
10	Holy Rice	["Italienische Pizza","Japanisch","Sushi"]	https://www.lieferando.de/speisekarte/holy-rice	/tmp/phproP5Xq	assets/img/restaurants/logo Holy Rice.png	/tmp/phpTebDXp	assets/img/restaurants/background Holy Rice.jpg
11	Just Lecker	["D\\u00f6ner","Burger","Falafel"]	https://www.lieferando.de/speisekarte/just-lecker	/tmp/php4UTWnn	assets/img/restaurants/logo Just Lecker.png	/tmp/phpMd4Jcq	assets/img/restaurants/background Just Lecker.jpg
12	Khaohom	["Thail\\u00e4ndisch","Asiatisch"]	https://www.lieferando.de/speisekarte/thai-restaurant-duesseldorf-khaohom	/tmp/phpnK7lYq	assets/img/restaurants/logo Khaohom.png	/tmp/phpcCXjWn	assets/img/restaurants/background Khaohom.jpg
13	Pizza Cab	["Burger","Italienische Pizza","Pasta"]	https://www.lieferando.de/speisekarte/pizza-cab-dusseldorf-am-hackenbruch	/tmp/php7T9xYo	assets/img/restaurants/logo Pizza Cab.png	/tmp/phpjxl9gq	assets/img/restaurants/background Pizza Cab.jpg
14	ROUNDTWO Burger	["H\\u00fchnchen","Pasta","Burger"]	https://www.lieferando.de/speisekarte/roundtwo-burger	/tmp/phpXQ1GPo	assets/img/restaurants/logo ROUNDTWO Burger.png	/tmp/phpJCHU4p	assets/img/restaurants/background ROUNDTWO Burger.jpg
15	Royal Indische Küche 3	["Indisch","100% Halal","Vegetarisch"]	https://www.lieferando.de/speisekarte/royal-indische-kueche-3	/tmp/phphB9n6o	assets/img/restaurants/logo Royal Indische Küche 3.png	/tmp/php41erDn	assets/img/restaurants/background Royal Indische Küche 3.jpg
16	Tandoori Palace	["Curry","Vegan","Indisch"]	https://www.lieferando.de/speisekarte/tandoori-palace-dusseldorf-kolner-landstrasse	/tmp/phpO6IMzq	assets/img/restaurants/logo Tandoori Palace.png	/tmp/phpeTfjCo	assets/img/restaurants/background Tandoori Palace.jpg
17	Zu-di's Asia-Wok	["Asiatisch","Chinesisch","Thail\\u00e4ndisch"]	https://www.lieferando.de/speisekarte/zu-dis-asia-wok	/tmp/phpa9FTQq	assets/img/restaurants/logo Zu-di's Asia-Wok.png	/tmp/php3ssYkq	assets/img/restaurants/background Zu-di's Asia-Wok.jpg
18	Sindbad's Restaurant	["Arabisch","100% Halal","Italienisch"]	https://www.lieferando.de/speisekarte/sindbads-restaurant	/tmp/phpJiqOu6	assets/img/restaurants/logo Sindbad's Restaurant.png	/tmp/phpQeSpn5	assets/img/restaurants/background Sindbad's Restaurant.jpg
19	Imbiss Beirut	["Arabisch","Libanesisch","Falafel"]	https://www.lieferando.de/speisekarte/imbiss-beirut-1	/tmp/php2IvqG6	assets/img/restaurants/logo Imbiss Beirut.png	/tmp/phpXj3o56	assets/img/restaurants/background Imbiss Beirut.jpg
20	Fortuna Döner & Burger	["D\\u00f6ner","Vegetarisch","Burger"]	https://www.lieferando.de/speisekarte/fortuna-doner-burger	/tmp/phpp3V87l	assets/img/restaurants/logo Fortuna Döner & Burger.png	/tmp/php497W7i	assets/img/restaurants/background Fortuna Döner & Burger.jpg
21	Thai orchid Bistro	["Thail\\u00e4ndisch","Asiatisch"]	https://www.lieferando.de/speisekarte/thai-orchid-bistro	/tmp/phpsrcmcl	assets/img/restaurants/logo Thai orchid Bistro.png	/tmp/phpRvTVHi	assets/img/restaurants/background Thai orchid Bistro.jpg
22	Pak Royal Tandoori Art	["Vegan","Indisch","Vegetarisch"]	https://www.lieferando.de/speisekarte/pak-royal-tandoor	/tmp/phpJHBFMh	assets/img/restaurants/logo Pak Royal Tandoori Art.png	/tmp/php86bgkm	assets/img/restaurants/background Pak Royal Tandoori Art.jpg
23	Rewe	["alles"]	https://shop.rewe.de/	/tmp/phppWut07	assets/img/restaurants/logo Rewe.svg	/tmp/phphXq2k6	assets/img/restaurants/background Rewe.svg
24	China-Imbiss Gold Dragon	["H\\u00fchnchen","Chinesisch","Thail\\u00e4ndisch"]	https://www.lieferando.de/speisekarte/golddragon-duesseldorf-lierenfeld	/tmp/php1lx9XE	assets/img/restaurants/logo China-Imbiss Gold Dragon.png	/tmp/php6omYPG	assets/img/restaurants/background China-Imbiss Gold Dragon.jpg
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, username, roles, password, user_profile_picture_url, banned) FROM stdin;
\.


--
-- Name: coupons_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.coupons_id_seq', 1, false);


--
-- Name: orders_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.orders_id_seq', 97, true);


--
-- Name: restaurants_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.restaurants_id_seq', 24, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 1, false);


--
-- Name: coupons coupons_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.coupons
    ADD CONSTRAINT coupons_pkey PRIMARY KEY (id);


--
-- Name: doctrine_migration_versions doctrine_migration_versions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.doctrine_migration_versions
    ADD CONSTRAINT doctrine_migration_versions_pkey PRIMARY KEY (version);


--
-- Name: orders orders_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_pkey PRIMARY KEY (id);


--
-- Name: restaurants restaurants_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.restaurants
    ADD CONSTRAINT restaurants_pkey PRIMARY KEY (id);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: idx_e52ffdeeb1e7706e; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_e52ffdeeb1e7706e ON public.orders USING btree (restaurant_id);


--
-- Name: idx_e52ffdeee3e60758; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_e52ffdeee3e60758 ON public.orders USING btree (commiter_id);


--
-- Name: idx_f5641118b1e7706e; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_f5641118b1e7706e ON public.coupons USING btree (restaurant_id);


--
-- Name: uniq_1483a5e9f85e0677; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX uniq_1483a5e9f85e0677 ON public.users USING btree (username);


--
-- Name: orders fk_e52ffdeeb1e7706e; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT fk_e52ffdeeb1e7706e FOREIGN KEY (restaurant_id) REFERENCES public.restaurants(id);


--
-- Name: orders fk_e52ffdeee3e60758; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT fk_e52ffdeee3e60758 FOREIGN KEY (commiter_id) REFERENCES public.users(id);


--
-- Name: coupons fk_f5641118b1e7706e; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.coupons
    ADD CONSTRAINT fk_f5641118b1e7706e FOREIGN KEY (restaurant_id) REFERENCES public.restaurants(id);


--
-- PostgreSQL database dump complete
--

