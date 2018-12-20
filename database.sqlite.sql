BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS `person` (
	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`nome`	TEXT NOT NULL,
	`idade`	INTEGER,
	`sexo`	TEXT,
	`tipo`	TEXT,
	`linguagem`	TEXT,
	`projeto`	TEXT,
	`updated_at`	TEXT,
	`created_at`	TEXT
);
INSERT INTO `person` (id,nome,idade,sexo,tipo,linguagem,projeto,updated_at,created_at) VALUES (14,'teste',12,'Feminino','Analista',NULL,'teste, teaste','2018-12-20 20:04:06','2018-12-20 20:04:06'),
 (15,'sadasd','sadasd','Feminino','Programador','PHP','asdasdas','2018-12-20 20:15:02','2018-12-20 20:05:02');
CREATE TABLE IF NOT EXISTS `migrations` (
	`id`	integer NOT NULL PRIMARY KEY AUTOINCREMENT,
	`migration`	varchar NOT NULL,
	`batch`	integer NOT NULL
);
COMMIT;
