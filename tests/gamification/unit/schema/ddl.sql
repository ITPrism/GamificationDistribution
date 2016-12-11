CREATE TABLE [jos_gfy_achievements] (
  'id'            INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  'title'         TEXT    NOT NULL,
  'context'       TEXT    NOT NULL,
  'description'   TEXT,
  'image'         TEXT,
  'image_small'   TEXT,
  'image_square'  TEXT,
  'activity_text' TEXT,
  'note'          TEXT,
  'published'     INTEGER NOT NULL             DEFAULT '0',
  'ordering'      INTEGER NOT NULL             DEFAULT '0',
  'custom_data'   TEXT    NOT NULL             DEFAULT '{}',
  'rewards'       TEXT    NOT NULL             DEFAULT '{}',
  'points_number' INTEGER NOT NULL             DEFAULT '0',
  'points_id'     INTEGER NOT NULL             DEFAULT '0',
  'group_id'      INTEGER NOT NULL
);

CREATE TABLE [jos_gfy_activities] (
  'id'      INTEGER   NOT NULL PRIMARY KEY AUTOINCREMENT,
  'title'   TEXT,
  'content' TEXT      NOT NULL,
  'image'   TEXT,
  'url'     TEXT,
  'created' TIMESTAMP NOT NULL             DEFAULT CURRENT_TIMESTAMP,
  'user_id' INTEGER   NOT NULL
);

CREATE TABLE [jos_gfy_badges] (
  'id'            INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  'title'         TEXT    NOT NULL,
  'description'   TEXT,
  'points_number' INTEGER NOT NULL             DEFAULT '0',
  'image'         TEXT    NOT NULL,
  'note'          TEXT,
  'activity_text' TEXT,
  'ordering'      INTEGER NOT NULL             DEFAULT '0',
  'published'     INTEGER NOT NULL             DEFAULT '0',
  'params'        TEXT    NOT NULL             DEFAULT '{}',
  'custom_data'   TEXT    NOT NULL             DEFAULT '{}',
  'points_id'     INTEGER NOT NULL             DEFAULT '0',
  'group_id'      INTEGER NOT NULL
);

CREATE TABLE [jos_gfy_challenges] (
  'id'          INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  'title'       TEXT    NOT NULL,
  'description' TEXT,
  'image'       TEXT    NOT NULL,
  'note'        TEXT,
  'published'   INTEGER NOT NULL             DEFAULT '0',
  'params'      TEXT    NOT NULL             DEFAULT '{}',
  'group_id'    INTEGER NOT NULL
);

CREATE TABLE [jos_gfy_groups] (
  'id'   INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  'name' TEXT    NOT NULL,
  'note' TEXT    NOT NULL
);

CREATE TABLE [jos_gfy_levels] (
  'id'            INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  'title'         TEXT    NOT NULL,
  'points_number' INTEGER NOT NULL             DEFAULT '0',
  'value'         INTEGER NOT NULL,
  'published'     INTEGER NOT NULL             DEFAULT '0',
  'points_id'     INTEGER NOT NULL,
  'rank_id'       INTEGER NOT NULL             DEFAULT '0',
  'group_id'      INTEGER NOT NULL
);

CREATE TABLE [jos_gfy_notifications] (
  'id'      INTEGER   NOT NULL PRIMARY KEY AUTOINCREMENT,
  'title'   TEXT,
  'content' TEXT      NOT NULL,
  'image'   TEXT,
  'url'     TEXT,
  'created' TIMESTAMP NOT NULL             DEFAULT CURRENT_TIMESTAMP,
  'status'  INTEGER   NOT NULL             DEFAULT '0',
  'user_id' INTEGER   NOT NULL
);

CREATE TABLE [jos_gfy_points] (
  'id'        INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  'title'     TEXT    NOT NULL,
  'abbr'      TEXT    NOT NULL,
  'note'      TEXT,
  'published' INTEGER NOT NULL             DEFAULT '0',
  'group_id'  INTEGER NOT NULL
);

CREATE TABLE [jos_gfy_points_history] (
  'id'          INTEGER   NOT NULL PRIMARY KEY AUTOINCREMENT,
  'user_id'     INTEGER   NOT NULL,
  'points_id'   INTEGER   NOT NULL,
  'points'      INTEGER   NOT NULL             DEFAULT '0',
  'context'     TEXT      NOT NULL,
  'hash'        TEXT      NOT NULL,
  'record_date' TIMESTAMP NOT NULL             DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE [jos_gfy_ranks] (
  'id'            INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  'title'         TEXT    NOT NULL,
  'description'   TEXT,
  'points_number' INTEGER NOT NULL             DEFAULT '0',
  'image'         TEXT    NOT NULL,
  'note'          TEXT,
  'activity_text' TEXT,
  'published'     INTEGER NOT NULL             DEFAULT '0',
  'points_id'     INTEGER NOT NULL             DEFAULT '0',
  'group_id'      INTEGER NOT NULL
);

CREATE TABLE [jos_gfy_rewards] (
  'id'            INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  'title'         TEXT    NOT NULL,
  'description'   TEXT,
  'image'         TEXT,
  'image_small'   TEXT,
  'image_square'  TEXT,
  'activity_text' TEXT,
  'note'          TEXT,
  'number'        INTEGER,
  'published'     INTEGER NOT NULL             DEFAULT '0',
  'points_number' INTEGER NOT NULL             DEFAULT '0',
  'points_id'     INTEGER NOT NULL             DEFAULT '0',
  'group_id'      INTEGER NOT NULL
);

CREATE TABLE [jos_gfy_userachievements] (
  'id'              INTEGER   NOT NULL PRIMARY KEY AUTOINCREMENT,
  'user_id'         INTEGER   NOT NULL,
  'achievement_id'  INTEGER   NOT NULL,
  'accomplished'    INTEGER   NOT NULL             DEFAULT '0',
  'accomplished_at' TIMESTAMP NOT NULL             DEFAULT '0000-00-00 00:00:00'
);

CREATE TABLE [jos_gfy_userbadges] (
  'id'       INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  'user_id'  INTEGER NOT NULL,
  'group_id' INTEGER NOT NULL,
  'badge_id' INTEGER NOT NULL
);

CREATE TABLE [jos_gfy_userlevels] (
  'id'       INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  'user_id'  INTEGER NOT NULL,
  'group_id' INTEGER NOT NULL,
  'level_id' INTEGER NOT NULL
);

CREATE TABLE [jos_gfy_userpoints] (
  'id'            INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  'user_id'       INTEGER NOT NULL,
  'points_id'     INTEGER NOT NULL,
  'points_number' INTEGER NOT NULL             DEFAULT '0'
);

CREATE TABLE [jos_gfy_userranks] (
  'id'       INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  'user_id'  INTEGER NOT NULL,
  'group_id' INTEGER NOT NULL,
  'rank_id'  INTEGER NOT NULL
);

CREATE TABLE [jos_gfy_userrewards] (
  'id'        INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  'user_id'   INTEGER NOT NULL,
  'group_id'  INTEGER NOT NULL,
  'reward_id' INTEGER NOT NULL
);