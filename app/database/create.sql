BEGIN TRANSACTION;
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`first_name`	TEXT NOT NULL,
	`last_name`	TEXT NOT NULL,
	`email`	TEXT NOT NULL,
	`password`	TEXT NOT NULL,
	`created_at`	TEXT NOT NULL,
	`updated_at`	TEXT,
	`username`	TEXT NOT NULL,
	`profile_picture`	BLOB,
	`biography`	TEXT
);

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`user_id`	INTEGER NOT NULL,
	`content`	BLOB NOT NULL,
	`description`	TEXT NOT NULL,
	`created_at`	TEXT NOT NULL,
	`updated_at`	TEXT,
	FOREIGN KEY (user_id) REFERENCES users(`id`) ON DELETE CASCADE
);
DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`conversation_id`	INTEGER NOT NULL,
	`sender_id`	INTEGER NOT NULL,
	`content`	INTEGER,
	`created_at`	INTEGER,
	FOREIGN KEY (sender_id) REFERENCES users(`id`) ON DELETE CASCADE,
	FOREIGN KEY (conversation_id) REFERENCES conversations(`id`) ON DELETE CASCADE
);

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
	`post_id`	INTEGER,
	`user_id`	INTEGER,
	`created_at`	TEXT,
	FOREIGN KEY (user_id) REFERENCES users(`id`) ON DELETE CASCADE,
	FOREIGN KEY (post_id) REFERENCES posts(`id`) ON DELETE CASCADE
);

DROP TABLE IF EXISTS `followers`;
CREATE TABLE IF NOT EXISTS `followers` (
	`user_id`	INTEGER NOT NULL,
	`follower_id`	INTEGER NOT NULL,
	`created_at`	TEXT NOT NULL,
	FOREIGN KEY (user_id) REFERENCES users(`id`) ON DELETE CASCADE,
	FOREIGN KEY (follower_id) REFERENCES users(`id`) ON DELETE CASCADE
);

DROP TABLE IF EXISTS `conversations`;
CREATE TABLE IF NOT EXISTS `conversations` (
	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`created_at`	TEXT
);

DROP TABLE IF EXISTS `conversation_members`;
CREATE TABLE IF NOT EXISTS `conversation_members` (
	`conversation_id`	INTEGER NOT NULL,
	`user_id`	INTEGER NOT NULL,
	FOREIGN KEY (user_id) REFERENCES users(`id`) ON DELETE CASCADE,
	FOREIGN KEY (conversation_id) REFERENCES conversations(`id`) ON DELETE CASCADE
);

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`post_id`	INTEGER,
	`user_id`	INTEGER,
	`content`	TEXT,
	`created_at`	TEXT,
	FOREIGN KEY (user_id) REFERENCES users(`id`) ON DELETE CASCADE,
	FOREIGN KEY (post_id) REFERENCES posts(`id`) ON DELETE CASCADE
);
COMMIT;
