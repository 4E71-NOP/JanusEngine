CREATE OR REPLACE 
FUNCTION HEX(bytea) 
	returns text as $$ 
	SELECT encode($1::bytea, 'hex'); 
$$ language sql; 
-- -----------------------------------
-- select hex('\x1a2b3c4d5e'::bytea);
