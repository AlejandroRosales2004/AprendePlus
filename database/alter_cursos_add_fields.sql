-- Script para agregar campos avanzados a la tabla cursos
ALTER TABLE [cursos]
  ADD [nivel] VARCHAR(30) NULL;

ALTER TABLE [cursos]
  ADD [duracion] VARCHAR(30) NULL;

ALTER TABLE [cursos]
  ADD [requisitos] TEXT NULL;
