/* comma separated tables list */
select GROUP_CONCAT(information_schema.`TABLES`.TABLE_NAME SEPARATOR ',') as `list` FROM information_schema.`TABLES` WHERE information_schema.`TABLES`.TABLE_SCHEMA =  'test'

/* content/img replace */
update pages set content = replace(content, '/etc/content/img/', '/content/img/');