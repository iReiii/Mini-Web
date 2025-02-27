--
-- PostgreSQL database dump
--

-- Dumped from database version 17.3
-- Dumped by pg_dump version 17.3

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
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
-- Name: dokter; Type: TABLE; Schema: public; Owner: lumm
--

CREATE TABLE public.dokter (
    id integer NOT NULL,
    nama character varying(100) NOT NULL,
    spesialisasi character varying(100) NOT NULL,
    tanggal_lahir date NOT NULL,
    jenis_kelamin character varying(10) NOT NULL,
    agama character varying(20) NOT NULL,
    pendidikan character varying(50) NOT NULL,
    foto character varying(255),
    kontak character varying(50) NOT NULL,
    CONSTRAINT dokter_agama_check CHECK (((agama)::text = ANY ((ARRAY['Islam'::character varying, 'Kristen'::character varying, 'Katolik'::character varying, 'Hindu'::character varying, 'Buddha'::character varying, 'Konghucu'::character varying])::text[]))),
    CONSTRAINT dokter_jenis_kelamin_check CHECK (((jenis_kelamin)::text = ANY ((ARRAY['Laki-laki'::character varying, 'Perempuan'::character varying])::text[])))
);


ALTER TABLE public.dokter OWNER TO lumm;

--
-- Name: dokter_id_seq; Type: SEQUENCE; Schema: public; Owner: lumm
--

CREATE SEQUENCE public.dokter_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.dokter_id_seq OWNER TO lumm;

--
-- Name: dokter_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: lumm
--

ALTER SEQUENCE public.dokter_id_seq OWNED BY public.dokter.id;


--
-- Name: pasien; Type: TABLE; Schema: public; Owner: lumm
--

CREATE TABLE public.pasien (
    id_pasien integer NOT NULL,
    nama character varying(100) NOT NULL,
    jenis_kelamin character varying(10) NOT NULL,
    tanggal_lahir date NOT NULL,
    agama character varying(20) NOT NULL,
    pendidikan character varying(50) NOT NULL,
    diagnosa character varying(50) NOT NULL,
    foto character varying(255) DEFAULT NULL::character varying,
    CONSTRAINT pasien_jenis_kelamin_check CHECK (((jenis_kelamin)::text = ANY ((ARRAY['Laki-laki'::character varying, 'Perempuan'::character varying])::text[])))
);


ALTER TABLE public.pasien OWNER TO lumm;

--
-- Name: pasien_id_pasien_seq; Type: SEQUENCE; Schema: public; Owner: lumm
--

CREATE SEQUENCE public.pasien_id_pasien_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.pasien_id_pasien_seq OWNER TO lumm;

--
-- Name: pasien_id_pasien_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: lumm
--

ALTER SEQUENCE public.pasien_id_pasien_seq OWNED BY public.pasien.id_pasien;


--
-- Name: users; Type: TABLE; Schema: public; Owner: lumm
--

CREATE TABLE public.users (
    id_users integer NOT NULL,
    username character varying(50),
    password character varying(50)
);


ALTER TABLE public.users OWNER TO lumm;

--
-- Name: users_id_users_seq; Type: SEQUENCE; Schema: public; Owner: lumm
--

CREATE SEQUENCE public.users_id_users_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_users_seq OWNER TO lumm;

--
-- Name: users_id_users_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: lumm
--

ALTER SEQUENCE public.users_id_users_seq OWNED BY public.users.id_users;


--
-- Name: dokter id; Type: DEFAULT; Schema: public; Owner: lumm
--

ALTER TABLE ONLY public.dokter ALTER COLUMN id SET DEFAULT nextval('public.dokter_id_seq'::regclass);


--
-- Name: pasien id_pasien; Type: DEFAULT; Schema: public; Owner: lumm
--

ALTER TABLE ONLY public.pasien ALTER COLUMN id_pasien SET DEFAULT nextval('public.pasien_id_pasien_seq'::regclass);


--
-- Name: users id_users; Type: DEFAULT; Schema: public; Owner: lumm
--

ALTER TABLE ONLY public.users ALTER COLUMN id_users SET DEFAULT nextval('public.users_id_users_seq'::regclass);


--
-- Data for Name: dokter; Type: TABLE DATA; Schema: public; Owner: lumm
--

COPY public.dokter (id, nama, spesialisasi, tanggal_lahir, jenis_kelamin, agama, pendidikan, foto, kontak) FROM stdin;
\.


--
-- Data for Name: pasien; Type: TABLE DATA; Schema: public; Owner: lumm
--

COPY public.pasien (id_pasien, nama, jenis_kelamin, tanggal_lahir, agama, pendidikan, diagnosa, foto) FROM stdin;
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: lumm
--

COPY public.users (id_users, username, password) FROM stdin;
1	Lummi	123
\.


--
-- Name: dokter_id_seq; Type: SEQUENCE SET; Schema: public; Owner: lumm
--

SELECT pg_catalog.setval('public.dokter_id_seq', 1, false);


--
-- Name: pasien_id_pasien_seq; Type: SEQUENCE SET; Schema: public; Owner: lumm
--

SELECT pg_catalog.setval('public.pasien_id_pasien_seq', 7, true);


--
-- Name: users_id_users_seq; Type: SEQUENCE SET; Schema: public; Owner: lumm
--

SELECT pg_catalog.setval('public.users_id_users_seq', 1, true);


--
-- Name: dokter dokter_pkey; Type: CONSTRAINT; Schema: public; Owner: lumm
--

ALTER TABLE ONLY public.dokter
    ADD CONSTRAINT dokter_pkey PRIMARY KEY (id);


--
-- Name: pasien pasien_pkey; Type: CONSTRAINT; Schema: public; Owner: lumm
--

ALTER TABLE ONLY public.pasien
    ADD CONSTRAINT pasien_pkey PRIMARY KEY (id_pasien);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: lumm
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id_users);


--
-- Name: users users_username_key; Type: CONSTRAINT; Schema: public; Owner: lumm
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_username_key UNIQUE (username);


--
-- PostgreSQL database dump complete
--

