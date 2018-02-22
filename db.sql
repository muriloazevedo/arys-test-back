CREATE TABLE IF NOT EXISTS usuarios (
	id serial PRIMARY KEY,
	nome text,
	sobrenome text,
	username text,
	senha text,
	salt text,
	datacriacao timestamp
);

