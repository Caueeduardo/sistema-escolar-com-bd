ALTER TABLE aluno ADD COLUMN id SERIAL;
UPDATE      aluno SET id = codigo;
ALTER TABLE aluno DROP COLUMN codigo;
ALTER TABLE aluno RENAME COLUMN id TO codigo;

ALTER TABLE cidade ADD COLUMN id SERIAL;
UPDATE      cidade SET id = codigo;
ALTER TABLE cidade DROP COLUMN codigo;
ALTER TABLE cidade RENAME COLUMN id TO codigo;

ALTER TABLE escola ADD COLUMN id SERIAL;
UPDATE      escola SET id = codigo;
ALTER TABLE escola DROP COLUMN codigo;
ALTER TABLE escola RENAME COLUMN id TO codigo;

ALTER TABLE materia ADD COLUMN id SERIAL;
UPDATE      materia SET id = codigo;
ALTER TABLE materia DROP COLUMN codigo;
ALTER TABLE materia RENAME COLUMN id TO codigo;

ALTER TABLE professor ADD COLUMN id SERIAL;
UPDATE      professor SET id = codigo;
ALTER TABLE professor DROP COLUMN codigo;
ALTER TABLE professor RENAME COLUMN id TO codigo;

ALTER TABLE turma ADD COLUMN id SERIAL;
UPDATE      turma SET id = codigo;
ALTER TABLE turma DROP COLUMN codigo;
ALTER TABLE turma RENAME COLUMN id TO codigo;

ALTER TABLE usuario ADD COLUMN id SERIAL;
UPDATE      usuario SET id = usucodigo;
ALTER TABLE usuario DROP COLUMN usucodigo;
ALTER TABLE usuario RENAME COLUMN id TO usucodigo;

ALTER TABLE sistema ADD COLUMN id SERIAL;
UPDATE      sistema SET id = siscodigo;
ALTER TABLE sistema DROP COLUMN siscodigo;
ALTER TABLE sistema RENAME COLUMN id TO siscodigo;

ALTER TABLE menu ADD COLUMN id SERIAL;
UPDATE      menu SET id = mencodigo;
ALTER TABLE menu DROP COLUMN mencodigo;
ALTER TABLE menu RENAME COLUMN id TO mencodigo;


