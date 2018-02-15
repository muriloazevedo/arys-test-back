CREATE TABLE IF NOT EXISTS usuarios (
	id serial,
	nome text,
	sobrenome text,
	username text,
	senha text,
	salt text,
	datacriacao timestamp,
	PRIMARY KEY( id )
);

