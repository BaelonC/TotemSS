-- USER SQL
CREATE USER "TOTEM" IDENTIFIED BY Gh49DF45mm67
DEFAULT TABLESPACE "TOTEM"
TEMPORARY TABLESPACE "TEMP"
ACCOUNT UNLOCK ;

-- QUOTAS

-- ROLES
ALTER USER "TOTEM" DEFAULT ROLE "CONNECT","RESOURCE";

-- SYSTEM PRIVILEGES


