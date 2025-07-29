CREATE TABLE IF NOT EXISTS "migrations"(
  "id" integer primary key autoincrement not null,
  "migration" varchar not null,
  "batch" integer not null
);
CREATE TABLE IF NOT EXISTS "users"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "email" varchar not null,
  "is_admin" tinyint(1) not null default '0',
  "email_verified_at" datetime,
  "password" varchar not null,
  "remember_token" varchar,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE UNIQUE INDEX "users_email_unique" on "users"("email");
CREATE TABLE IF NOT EXISTS "password_reset_tokens"(
  "email" varchar not null,
  "token" varchar not null,
  "created_at" datetime,
  primary key("email")
);
CREATE TABLE IF NOT EXISTS "sessions"(
  "id" varchar not null,
  "user_id" integer,
  "ip_address" varchar,
  "user_agent" text,
  "payload" text not null,
  "last_activity" integer not null,
  primary key("id")
);
CREATE INDEX "sessions_user_id_index" on "sessions"("user_id");
CREATE INDEX "sessions_last_activity_index" on "sessions"("last_activity");
CREATE TABLE IF NOT EXISTS "cache"(
  "key" varchar not null,
  "value" text not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE TABLE IF NOT EXISTS "cache_locks"(
  "key" varchar not null,
  "owner" varchar not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE TABLE IF NOT EXISTS "jobs"(
  "id" integer primary key autoincrement not null,
  "queue" varchar not null,
  "payload" text not null,
  "attempts" integer not null,
  "reserved_at" integer,
  "available_at" integer not null,
  "created_at" integer not null
);
CREATE INDEX "jobs_queue_index" on "jobs"("queue");
CREATE TABLE IF NOT EXISTS "job_batches"(
  "id" varchar not null,
  "name" varchar not null,
  "total_jobs" integer not null,
  "pending_jobs" integer not null,
  "failed_jobs" integer not null,
  "failed_job_ids" text not null,
  "options" text,
  "cancelled_at" integer,
  "created_at" integer not null,
  "finished_at" integer,
  primary key("id")
);
CREATE TABLE IF NOT EXISTS "failed_jobs"(
  "id" integer primary key autoincrement not null,
  "uuid" varchar not null,
  "connection" text not null,
  "queue" text not null,
  "payload" text not null,
  "exception" text not null,
  "failed_at" datetime not null default CURRENT_TIMESTAMP
);
CREATE UNIQUE INDEX "failed_jobs_uuid_unique" on "failed_jobs"("uuid");
CREATE TABLE IF NOT EXISTS "categories"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "created_at" datetime,
  "updated_at" datetime,
  "position" integer not null default '0'
);
CREATE TABLE IF NOT EXISTS "menu_items"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "description" text,
  "price" numeric not null,
  "image" varchar,
  "created_at" datetime,
  "updated_at" datetime,
  "category_id" integer,
  foreign key("category_id") references "categories"("id") on delete set null
);
CREATE TABLE IF NOT EXISTS "allergens"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE UNIQUE INDEX "allergens_name_unique" on "allergens"("name");
CREATE TABLE IF NOT EXISTS "allergen_menu_item"(
  "id" integer primary key autoincrement not null,
  "menu_item_id" integer not null,
  "allergen_id" integer not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("menu_item_id") references "menu_items"("id") on delete cascade,
  foreign key("allergen_id") references "allergens"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "personal_access_tokens"(
  "id" integer primary key autoincrement not null,
  "tokenable_type" varchar not null,
  "tokenable_id" integer not null,
  "name" text not null,
  "token" varchar not null,
  "abilities" text,
  "last_used_at" datetime,
  "expires_at" datetime,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE INDEX "personal_access_tokens_tokenable_type_tokenable_id_index" on "personal_access_tokens"(
  "tokenable_type",
  "tokenable_id"
);
CREATE UNIQUE INDEX "personal_access_tokens_token_unique" on "personal_access_tokens"(
  "token"
);
CREATE TABLE IF NOT EXISTS "menus"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "slug" varchar not null,
  "start_time" time not null,
  "end_time" time not null,
  "description" text,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE UNIQUE INDEX "menus_slug_unique" on "menus"("slug");
CREATE TABLE IF NOT EXISTS "category_menu"(
  "id" integer primary key autoincrement not null,
  "menu_id" integer not null,
  "category_id" integer not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("menu_id") references "menus"("id") on delete cascade,
  foreign key("category_id") references "categories"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "menu_category_items"(
  "id" integer primary key autoincrement not null,
  "menu_category_id" integer not null,
  "menu_item_id" integer not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("menu_category_id") references "menu_categories"("id") on delete cascade,
  foreign key("menu_item_id") references "menu_items"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "menu_categories"(
  "id" integer primary key autoincrement not null,
  "created_at" datetime,
  "updated_at" datetime,
  "position" integer not null default('0'),
  "menu_id" integer not null,
  "name" varchar not null,
  foreign key("menu_id") references "menus"("id") on delete cascade
);

INSERT INTO migrations VALUES(1,'0001_01_01_000000_create_users_table',1);
INSERT INTO migrations VALUES(2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO migrations VALUES(3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO migrations VALUES(4,'2025_07_17_112334_create_menu_items_table',1);
INSERT INTO migrations VALUES(5,'2025_07_17_120600_create_categories_table',1);
INSERT INTO migrations VALUES(6,'2025_07_17_120614_add_category_id_to_menu_items_table',1);
INSERT INTO migrations VALUES(7,'2025_07_21_055005_create_allergens_table',1);
INSERT INTO migrations VALUES(8,'2025_07_21_055217_create_allergen_menu_item_table',1);
INSERT INTO migrations VALUES(9,'2025_07_21_120708_create_personal_access_tokens_table',1);
INSERT INTO migrations VALUES(10,'2025_07_22_110843_create_menus_table',1);
INSERT INTO migrations VALUES(11,'2025_07_22_120759_create_menu_categories_table',1);
INSERT INTO migrations VALUES(12,'2025_07_22_122153_create_category_menu_table',1);
INSERT INTO migrations VALUES(13,'2025_07_23_120000_create_menu_category_items_table',2);
INSERT INTO migrations VALUES(14,'2025_07_24_065644_add_position_to_categories_table',3);
INSERT INTO migrations VALUES(15,'2025_07_24_074606_add_position_to_menu_categories_table',4);
