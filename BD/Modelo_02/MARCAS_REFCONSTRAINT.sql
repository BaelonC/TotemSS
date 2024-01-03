--------------------------------------------------------
--  Ref Constraints for Table MARCAS
--------------------------------------------------------

  ALTER TABLE "TOTEM"."MARCAS" ADD CONSTRAINT "MARCAS_FK21672150623083" FOREIGN KEY ("ID_DESTINO")
	  REFERENCES "TOTEM"."DESTINO" ("ID") ENABLE
