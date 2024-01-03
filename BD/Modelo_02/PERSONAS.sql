--------------------------------------------------------
--  DDL for Table PERSONAS
--------------------------------------------------------

  CREATE TABLE "TOTEM"."PERSONAS" 
   (	"RUT" NUMBER(10,0), 
	"DV" VARCHAR2(1 CHAR), 
	"NOMBRE" VARCHAR2(100 CHAR) NOT NULL ENABLE, 
	"APELLIDO_P" VARCHAR2(30 CHAR), 
	"APELLIDO_M" VARCHAR2(30 CHAR), 
	"TIPO_DOCUMENTO" VARCHAR2(20 CHAR), 
	"ID" NUMBER, 
	"PASAPORTE" VARCHAR2(100 CHAR), 
	"CODIGO_PAIS" VARCHAR2(2 CHAR), 
	 UNIQUE ("RUT")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT)
  TABLESPACE "TOTEM"  ENABLE
   ) PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT)
  TABLESPACE "TOTEM" 
 

   COMMENT ON COLUMN "TOTEM"."PERSONAS"."RUT" IS 'rut de la prsona cuando su tipo de documento es rut'
 
   COMMENT ON COLUMN "TOTEM"."PERSONAS"."DV" IS 'Dígito verfiicador de la persona cuando sudocumento de identificación es el rut'
 
   COMMENT ON COLUMN "TOTEM"."PERSONAS"."NOMBRE" IS 'nombre de la persona'
 
   COMMENT ON COLUMN "TOTEM"."PERSONAS"."APELLIDO_P" IS 'Apellido paterno de la persona'
 
   COMMENT ON COLUMN "TOTEM"."PERSONAS"."APELLIDO_M" IS 'Apellido materno de la persona'
 
   COMMENT ON COLUMN "TOTEM"."PERSONAS"."TIPO_DOCUMENTO" IS 'Tipo de documento de identificación; puede ser RUT o PASAPORTE'
 
   COMMENT ON COLUMN "TOTEM"."PERSONAS"."ID" IS 'Identificador único de la persona'
 
   COMMENT ON COLUMN "TOTEM"."PERSONAS"."PASAPORTE" IS 'Número de pasaporte cuando el documento de identificacxión es el pasaporte'
 
   COMMENT ON COLUMN "TOTEM"."PERSONAS"."CODIGO_PAIS" IS 'Código del pais asociado al pasaporte, en el caso de uso de rut chileno el código país es CL'
