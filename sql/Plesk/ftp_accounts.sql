/* Tested: v10/9 Linux, v8 Windows, */
SELECT
	doms.`name`
	,sys_users.login `user`
	,CAST(accounts.`password` AS CHAR) pass
FROM
	(
		SELECT
			hosting.sys_user_id
			,'' subdomain
			,domains.`name` domain
			,domains.`name`
		FROM
			hosting
			INNER JOIN domains ON hosting.dom_id = domains.id
   	UNION ALL
		SELECT
			subdomains.sys_user_id
			,subdomains.`name` subdomain
			,domains.`name` domain
			,CONCAT(subdomains.`name`, '.', domains.`name`) `name`
		FROM
			subdomains
			INNER JOIN domains ON subdomains.dom_id = domains.id
	) doms
	LEFT JOIN sys_users ON sys_users.id = doms.sys_user_id
	LEFT JOIN accounts ON accounts.id = sys_users.account_id
WHERE
	`name` LIKE '%/*[VARIABLE]*/%'
ORDER BY
	doms.`domain` ASC
	,doms.`subdomain` ASC;