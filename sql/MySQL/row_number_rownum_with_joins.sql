SELECT
	@rownum:=@rownum+1 num
	,t.etc
FROM
	(tbl t, (SELECT @rownum:=0) r)
WHERE
	t.etc1 = 1
ORDER BY
	t.etc2 DESC
LIMIT
	3;