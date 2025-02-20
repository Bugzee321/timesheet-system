--
-- PostgreSQL database dump
--

-- Dumped from database version 15.3 (Debian 15.3-1.pgdg120+1)
-- Dumped by pg_dump version 15.3 (Debian 15.3-1.pgdg120+1)

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
-- Name: attribute_values; Type: TABLE; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE TABLE public.attribute_values (
    id bigint NOT NULL,
    attribute_id bigint NOT NULL,
    value text NOT NULL,
    entity_type character varying(255) NOT NULL,
    entity_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.attribute_values OWNER TO "ZnYMbCRbv49iSXEW";

--
-- Name: attribute_values_id_seq; Type: SEQUENCE; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE SEQUENCE public.attribute_values_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.attribute_values_id_seq OWNER TO "ZnYMbCRbv49iSXEW";

--
-- Name: attribute_values_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER SEQUENCE public.attribute_values_id_seq OWNED BY public.attribute_values.id;


--
-- Name: attributes; Type: TABLE; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE TABLE public.attributes (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    type character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT attributes_type_check CHECK (((type)::text = ANY ((ARRAY['text'::character varying, 'date'::character varying, 'number'::character varying, 'select'::character varying])::text[])))
);


ALTER TABLE public.attributes OWNER TO "ZnYMbCRbv49iSXEW";

--
-- Name: attributes_id_seq; Type: SEQUENCE; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE SEQUENCE public.attributes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.attributes_id_seq OWNER TO "ZnYMbCRbv49iSXEW";

--
-- Name: attributes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER SEQUENCE public.attributes_id_seq OWNED BY public.attributes.id;


--
-- Name: cache; Type: TABLE; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache OWNER TO "ZnYMbCRbv49iSXEW";

--
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache_locks OWNER TO "ZnYMbCRbv49iSXEW";

--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO "ZnYMbCRbv49iSXEW";

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.failed_jobs_id_seq OWNER TO "ZnYMbCRbv49iSXEW";

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: job_batches; Type: TABLE; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);


ALTER TABLE public.job_batches OWNER TO "ZnYMbCRbv49iSXEW";

--
-- Name: jobs; Type: TABLE; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


ALTER TABLE public.jobs OWNER TO "ZnYMbCRbv49iSXEW";

--
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.jobs_id_seq OWNER TO "ZnYMbCRbv49iSXEW";

--
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO "ZnYMbCRbv49iSXEW";

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.migrations_id_seq OWNER TO "ZnYMbCRbv49iSXEW";

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: oauth_access_tokens; Type: TABLE; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE TABLE public.oauth_access_tokens (
    id character varying(100) NOT NULL,
    user_id bigint,
    client_id bigint NOT NULL,
    name character varying(255),
    scopes text,
    revoked boolean NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone
);


ALTER TABLE public.oauth_access_tokens OWNER TO "ZnYMbCRbv49iSXEW";

--
-- Name: oauth_auth_codes; Type: TABLE; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE TABLE public.oauth_auth_codes (
    id character varying(100) NOT NULL,
    user_id bigint NOT NULL,
    client_id bigint NOT NULL,
    scopes text,
    revoked boolean NOT NULL,
    expires_at timestamp(0) without time zone
);


ALTER TABLE public.oauth_auth_codes OWNER TO "ZnYMbCRbv49iSXEW";

--
-- Name: oauth_clients; Type: TABLE; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE TABLE public.oauth_clients (
    id bigint NOT NULL,
    user_id bigint,
    name character varying(255) NOT NULL,
    secret character varying(100),
    provider character varying(255),
    redirect text NOT NULL,
    personal_access_client boolean NOT NULL,
    password_client boolean NOT NULL,
    revoked boolean NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.oauth_clients OWNER TO "ZnYMbCRbv49iSXEW";

--
-- Name: oauth_clients_id_seq; Type: SEQUENCE; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE SEQUENCE public.oauth_clients_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.oauth_clients_id_seq OWNER TO "ZnYMbCRbv49iSXEW";

--
-- Name: oauth_clients_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER SEQUENCE public.oauth_clients_id_seq OWNED BY public.oauth_clients.id;


--
-- Name: oauth_personal_access_clients; Type: TABLE; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE TABLE public.oauth_personal_access_clients (
    id bigint NOT NULL,
    client_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.oauth_personal_access_clients OWNER TO "ZnYMbCRbv49iSXEW";

--
-- Name: oauth_personal_access_clients_id_seq; Type: SEQUENCE; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE SEQUENCE public.oauth_personal_access_clients_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.oauth_personal_access_clients_id_seq OWNER TO "ZnYMbCRbv49iSXEW";

--
-- Name: oauth_personal_access_clients_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER SEQUENCE public.oauth_personal_access_clients_id_seq OWNED BY public.oauth_personal_access_clients.id;


--
-- Name: oauth_refresh_tokens; Type: TABLE; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE TABLE public.oauth_refresh_tokens (
    id character varying(100) NOT NULL,
    access_token_id character varying(100) NOT NULL,
    revoked boolean NOT NULL,
    expires_at timestamp(0) without time zone
);


ALTER TABLE public.oauth_refresh_tokens OWNER TO "ZnYMbCRbv49iSXEW";

--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO "ZnYMbCRbv49iSXEW";

--
-- Name: project_user; Type: TABLE; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE TABLE public.project_user (
    project_id bigint NOT NULL,
    user_id bigint NOT NULL
);


ALTER TABLE public.project_user OWNER TO "ZnYMbCRbv49iSXEW";

--
-- Name: projects; Type: TABLE; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE TABLE public.projects (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    status character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.projects OWNER TO "ZnYMbCRbv49iSXEW";

--
-- Name: projects_id_seq; Type: SEQUENCE; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE SEQUENCE public.projects_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.projects_id_seq OWNER TO "ZnYMbCRbv49iSXEW";

--
-- Name: projects_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER SEQUENCE public.projects_id_seq OWNED BY public.projects.id;


--
-- Name: sessions; Type: TABLE; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


ALTER TABLE public.sessions OWNER TO "ZnYMbCRbv49iSXEW";

--
-- Name: timesheets; Type: TABLE; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE TABLE public.timesheets (
    id bigint NOT NULL,
    task_name character varying(255) NOT NULL,
    date date NOT NULL,
    hours numeric(8,2) NOT NULL,
    user_id bigint NOT NULL,
    project_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.timesheets OWNER TO "ZnYMbCRbv49iSXEW";

--
-- Name: timesheets_id_seq; Type: SEQUENCE; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE SEQUENCE public.timesheets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.timesheets_id_seq OWNER TO "ZnYMbCRbv49iSXEW";

--
-- Name: timesheets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER SEQUENCE public.timesheets_id_seq OWNED BY public.timesheets.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    first_name character varying(255) NOT NULL,
    last_name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.users OWNER TO "ZnYMbCRbv49iSXEW";

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO "ZnYMbCRbv49iSXEW";

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: attribute_values id; Type: DEFAULT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.attribute_values ALTER COLUMN id SET DEFAULT nextval('public.attribute_values_id_seq'::regclass);


--
-- Name: attributes id; Type: DEFAULT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.attributes ALTER COLUMN id SET DEFAULT nextval('public.attributes_id_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: oauth_clients id; Type: DEFAULT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.oauth_clients ALTER COLUMN id SET DEFAULT nextval('public.oauth_clients_id_seq'::regclass);


--
-- Name: oauth_personal_access_clients id; Type: DEFAULT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.oauth_personal_access_clients ALTER COLUMN id SET DEFAULT nextval('public.oauth_personal_access_clients_id_seq'::regclass);


--
-- Name: projects id; Type: DEFAULT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.projects ALTER COLUMN id SET DEFAULT nextval('public.projects_id_seq'::regclass);


--
-- Name: timesheets id; Type: DEFAULT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.timesheets ALTER COLUMN id SET DEFAULT nextval('public.timesheets_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: attribute_values; Type: TABLE DATA; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

COPY public.attribute_values (id, attribute_id, value, entity_type, entity_id, created_at, updated_at) FROM stdin;
1	3	a	App\\Models\\Project	1	2025-02-20 07:11:40	2025-02-20 07:11:40
2	3	distinctio	App\\Models\\Project	2	2025-02-20 07:11:40	2025-02-20 07:11:40
3	9	quo	App\\Models\\Project	3	2025-02-20 07:11:40	2025-02-20 07:11:40
4	2	possimus	App\\Models\\Project	4	2025-02-20 07:11:40	2025-02-20 07:11:40
5	1	est	App\\Models\\Project	5	2025-02-20 07:11:40	2025-02-20 07:11:40
\.


--
-- Data for Name: attributes; Type: TABLE DATA; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

COPY public.attributes (id, name, type, created_at, updated_at) FROM stdin;
1	dolorum	text	2025-02-20 07:11:40	2025-02-20 07:11:40
2	quisquam	number	2025-02-20 07:11:40	2025-02-20 07:11:40
3	laborum	number	2025-02-20 07:11:40	2025-02-20 07:11:40
4	beatae	date	2025-02-20 07:11:40	2025-02-20 07:11:40
5	rerum	date	2025-02-20 07:11:40	2025-02-20 07:11:40
6	est	text	2025-02-20 07:11:40	2025-02-20 07:11:40
7	voluptates	number	2025-02-20 07:11:40	2025-02-20 07:11:40
8	ea	date	2025-02-20 07:11:40	2025-02-20 07:11:40
9	et	text	2025-02-20 07:11:40	2025-02-20 07:11:40
10	est	number	2025-02-20 07:11:40	2025-02-20 07:11:40
\.


--
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

COPY public.cache (key, value, expiration) FROM stdin;
\.


--
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

COPY public.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) FROM stdin;
\.


--
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	0001_01_01_000000_create_users_table	1
2	0001_01_01_000001_create_cache_table	1
3	0001_01_01_000002_create_jobs_table	1
4	2025_02_17_143125_create_oauth_auth_codes_table	1
5	2025_02_17_143126_create_oauth_access_tokens_table	1
6	2025_02_17_143127_create_oauth_refresh_tokens_table	1
7	2025_02_17_143128_create_oauth_clients_table	1
8	2025_02_17_143129_create_oauth_personal_access_clients_table	1
9	2025_02_17_143406_create_projects_table	1
10	2025_02_17_143416_create_timesheets_table	1
11	2025_02_17_143827_create_attributes_table	1
12	2025_02_17_143844_create_attribute_values_table	1
\.


--
-- Data for Name: oauth_access_tokens; Type: TABLE DATA; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

COPY public.oauth_access_tokens (id, user_id, client_id, name, scopes, revoked, created_at, updated_at, expires_at) FROM stdin;
\.


--
-- Data for Name: oauth_auth_codes; Type: TABLE DATA; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

COPY public.oauth_auth_codes (id, user_id, client_id, scopes, revoked, expires_at) FROM stdin;
\.


--
-- Data for Name: oauth_clients; Type: TABLE DATA; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

COPY public.oauth_clients (id, user_id, name, secret, provider, redirect, personal_access_client, password_client, revoked, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: oauth_personal_access_clients; Type: TABLE DATA; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

COPY public.oauth_personal_access_clients (id, client_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: oauth_refresh_tokens; Type: TABLE DATA; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

COPY public.oauth_refresh_tokens (id, access_token_id, revoked, expires_at) FROM stdin;
\.


--
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: project_user; Type: TABLE DATA; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

COPY public.project_user (project_id, user_id) FROM stdin;
\.


--
-- Data for Name: projects; Type: TABLE DATA; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

COPY public.projects (id, name, status, created_at, updated_at) FROM stdin;
1	Anahi O'Kon	inactive	2025-02-20 07:11:40	2025-02-20 07:11:40
2	Mrs. Crystel Tillman	inactive	2025-02-20 07:11:40	2025-02-20 07:11:40
3	Mrs. Bulah Kertzmann	active	2025-02-20 07:11:40	2025-02-20 07:11:40
4	Maci Douglas	active	2025-02-20 07:11:40	2025-02-20 07:11:40
5	Mafalda Brown Sr.	active	2025-02-20 07:11:40	2025-02-20 07:11:40
\.


--
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
\.


--
-- Data for Name: timesheets; Type: TABLE DATA; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

COPY public.timesheets (id, task_name, date, hours, user_id, project_id, created_at, updated_at) FROM stdin;
1	Casper Cole	2014-12-01	5.00	9	1	2025-02-20 07:11:40	2025-02-20 07:11:40
2	Stan Kuhn	1999-07-03	2.00	9	1	2025-02-20 07:11:40	2025-02-20 07:11:40
3	Garry Kirlin	1992-04-02	2.00	9	1	2025-02-20 07:11:40	2025-02-20 07:11:40
4	Jay Will	2020-06-07	6.00	2	2	2025-02-20 07:11:40	2025-02-20 07:11:40
5	Marcellus Nienow DVM	1997-02-08	4.00	2	2	2025-02-20 07:11:40	2025-02-20 07:11:40
6	Leonie Deckow	2021-07-05	5.00	2	2	2025-02-20 07:11:40	2025-02-20 07:11:40
7	Dr. Dorian Schiller	1994-07-07	3.00	6	3	2025-02-20 07:11:40	2025-02-20 07:11:40
8	Miss Raphaelle Spinka	2012-03-07	8.00	6	3	2025-02-20 07:11:40	2025-02-20 07:11:40
9	Mrs. Lulu Predovic Sr.	2005-04-29	6.00	6	3	2025-02-20 07:11:40	2025-02-20 07:11:40
10	Prof. Elta Bogisich IV	1982-09-13	5.00	5	4	2025-02-20 07:11:40	2025-02-20 07:11:40
11	Miss Esta Thompson	1988-04-30	5.00	5	4	2025-02-20 07:11:40	2025-02-20 07:11:40
12	Miss Izabella Auer IV	1972-01-26	1.00	5	4	2025-02-20 07:11:40	2025-02-20 07:11:40
13	Eliezer Parisian	2020-04-08	8.00	4	5	2025-02-20 07:11:40	2025-02-20 07:11:40
14	Daija Kihn	1980-09-10	6.00	4	5	2025-02-20 07:11:40	2025-02-20 07:11:40
15	Bette Walsh	1983-07-07	8.00	4	5	2025-02-20 07:11:40	2025-02-20 07:11:40
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

COPY public.users (id, first_name, last_name, email, password, remember_token, created_at, updated_at) FROM stdin;
1	Admin	User	admin@astudio.com	$2y$12$pTI9eZe7rPeUOh2Ue2bC.uPc4EKHroIQE/dkVX6dH0/Gaz78skeCe	utQrnDqecZ	2025-02-20 07:11:40	2025-02-20 07:11:40
2	Alexander	Hills	considine.breanne@example.org	$2y$12$8yR2KWtvrqBN9eMt/wxD/.SB0E7DsJr50OgsWx7S3PobrKuzmOKnm	eSwrkk5Hbj	2025-02-20 07:11:40	2025-02-20 07:11:40
3	Adele	Bednar	plakin@example.net	$2y$12$8yR2KWtvrqBN9eMt/wxD/.SB0E7DsJr50OgsWx7S3PobrKuzmOKnm	P46IYZbMBr	2025-02-20 07:11:40	2025-02-20 07:11:40
4	Breanna	Kunde	dnitzsche@example.org	$2y$12$8yR2KWtvrqBN9eMt/wxD/.SB0E7DsJr50OgsWx7S3PobrKuzmOKnm	HRWm3kvBoR	2025-02-20 07:11:40	2025-02-20 07:11:40
5	Ahmed	Gibson	schumm.destini@example.net	$2y$12$8yR2KWtvrqBN9eMt/wxD/.SB0E7DsJr50OgsWx7S3PobrKuzmOKnm	z7yVFHNfbQ	2025-02-20 07:11:40	2025-02-20 07:11:40
6	Estelle	Sipes	urban.braun@example.net	$2y$12$8yR2KWtvrqBN9eMt/wxD/.SB0E7DsJr50OgsWx7S3PobrKuzmOKnm	VLibffjxSh	2025-02-20 07:11:40	2025-02-20 07:11:40
7	Shirley	Will	jaqueline.barton@example.com	$2y$12$8yR2KWtvrqBN9eMt/wxD/.SB0E7DsJr50OgsWx7S3PobrKuzmOKnm	uPBHdewviG	2025-02-20 07:11:40	2025-02-20 07:11:40
8	Jackie	Considine	llesch@example.net	$2y$12$8yR2KWtvrqBN9eMt/wxD/.SB0E7DsJr50OgsWx7S3PobrKuzmOKnm	q5wiznH7eP	2025-02-20 07:11:40	2025-02-20 07:11:40
9	Rosemarie	Dickens	winnifred.monahan@example.com	$2y$12$8yR2KWtvrqBN9eMt/wxD/.SB0E7DsJr50OgsWx7S3PobrKuzmOKnm	GEg3frkT5A	2025-02-20 07:11:40	2025-02-20 07:11:40
10	Tomasa	Ledner	josiane08@example.org	$2y$12$8yR2KWtvrqBN9eMt/wxD/.SB0E7DsJr50OgsWx7S3PobrKuzmOKnm	CryRXIjcjI	2025-02-20 07:11:40	2025-02-20 07:11:40
11	Oren	Jenkins	jtreutel@example.org	$2y$12$8yR2KWtvrqBN9eMt/wxD/.SB0E7DsJr50OgsWx7S3PobrKuzmOKnm	ertxd2OQyh	2025-02-20 07:11:40	2025-02-20 07:11:40
\.


--
-- Name: attribute_values_id_seq; Type: SEQUENCE SET; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

SELECT pg_catalog.setval('public.attribute_values_id_seq', 5, true);


--
-- Name: attributes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

SELECT pg_catalog.setval('public.attributes_id_seq', 10, true);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

SELECT pg_catalog.setval('public.migrations_id_seq', 12, true);


--
-- Name: oauth_clients_id_seq; Type: SEQUENCE SET; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

SELECT pg_catalog.setval('public.oauth_clients_id_seq', 1, false);


--
-- Name: oauth_personal_access_clients_id_seq; Type: SEQUENCE SET; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

SELECT pg_catalog.setval('public.oauth_personal_access_clients_id_seq', 1, false);


--
-- Name: projects_id_seq; Type: SEQUENCE SET; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

SELECT pg_catalog.setval('public.projects_id_seq', 5, true);


--
-- Name: timesheets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

SELECT pg_catalog.setval('public.timesheets_id_seq', 15, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

SELECT pg_catalog.setval('public.users_id_seq', 11, true);


--
-- Name: attribute_values attribute_values_pkey; Type: CONSTRAINT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.attribute_values
    ADD CONSTRAINT attribute_values_pkey PRIMARY KEY (id);


--
-- Name: attributes attributes_pkey; Type: CONSTRAINT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.attributes
    ADD CONSTRAINT attributes_pkey PRIMARY KEY (id);


--
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: oauth_access_tokens oauth_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.oauth_access_tokens
    ADD CONSTRAINT oauth_access_tokens_pkey PRIMARY KEY (id);


--
-- Name: oauth_auth_codes oauth_auth_codes_pkey; Type: CONSTRAINT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.oauth_auth_codes
    ADD CONSTRAINT oauth_auth_codes_pkey PRIMARY KEY (id);


--
-- Name: oauth_clients oauth_clients_pkey; Type: CONSTRAINT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.oauth_clients
    ADD CONSTRAINT oauth_clients_pkey PRIMARY KEY (id);


--
-- Name: oauth_personal_access_clients oauth_personal_access_clients_pkey; Type: CONSTRAINT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.oauth_personal_access_clients
    ADD CONSTRAINT oauth_personal_access_clients_pkey PRIMARY KEY (id);


--
-- Name: oauth_refresh_tokens oauth_refresh_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.oauth_refresh_tokens
    ADD CONSTRAINT oauth_refresh_tokens_pkey PRIMARY KEY (id);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: project_user project_user_pkey; Type: CONSTRAINT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.project_user
    ADD CONSTRAINT project_user_pkey PRIMARY KEY (project_id, user_id);


--
-- Name: projects projects_pkey; Type: CONSTRAINT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.projects
    ADD CONSTRAINT projects_pkey PRIMARY KEY (id);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: timesheets timesheets_pkey; Type: CONSTRAINT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.timesheets
    ADD CONSTRAINT timesheets_pkey PRIMARY KEY (id);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: attribute_values_entity_type_entity_id_index; Type: INDEX; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE INDEX attribute_values_entity_type_entity_id_index ON public.attribute_values USING btree (entity_type, entity_id);


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- Name: oauth_access_tokens_user_id_index; Type: INDEX; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE INDEX oauth_access_tokens_user_id_index ON public.oauth_access_tokens USING btree (user_id);


--
-- Name: oauth_auth_codes_user_id_index; Type: INDEX; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE INDEX oauth_auth_codes_user_id_index ON public.oauth_auth_codes USING btree (user_id);


--
-- Name: oauth_clients_user_id_index; Type: INDEX; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE INDEX oauth_clients_user_id_index ON public.oauth_clients USING btree (user_id);


--
-- Name: oauth_refresh_tokens_access_token_id_index; Type: INDEX; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE INDEX oauth_refresh_tokens_access_token_id_index ON public.oauth_refresh_tokens USING btree (access_token_id);


--
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- Name: attribute_values attribute_values_attribute_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.attribute_values
    ADD CONSTRAINT attribute_values_attribute_id_foreign FOREIGN KEY (attribute_id) REFERENCES public.attributes(id);


--
-- Name: project_user project_user_project_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.project_user
    ADD CONSTRAINT project_user_project_id_foreign FOREIGN KEY (project_id) REFERENCES public.projects(id);


--
-- Name: project_user project_user_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.project_user
    ADD CONSTRAINT project_user_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id);


--
-- Name: timesheets timesheets_project_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.timesheets
    ADD CONSTRAINT timesheets_project_id_foreign FOREIGN KEY (project_id) REFERENCES public.projects(id);


--
-- Name: timesheets timesheets_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: ZnYMbCRbv49iSXEW
--

ALTER TABLE ONLY public.timesheets
    ADD CONSTRAINT timesheets_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id);


--
-- PostgreSQL database dump complete
--

