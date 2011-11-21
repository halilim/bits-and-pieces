indexer --config /usr/local/etc/sphinx.conf --merge tblname tblname_delta --merge-dst-range deleted 0 0 --rotate
mysql -uMYSQL_USER -pMYSQL_PASS -e"REPLACE INTO sphinx_counter SELECT 'tblname', ( SELECT deltaMax FROM sphinx_counter WHERE indexName = 'tblname' ), MAX(id) FROM tblname;" MYSQL_DB
