SELECT
    clients.pname
    ,clients.type
    ,clients.login AS user
    ,CAST(accounts.`password` AS CHAR) AS pass
    ,domains.name AS first_domain
FROM
    clients
    LEFT JOIN accounts ON accounts.id = clients.account_id
    LEFT JOIN domains ON domains.cl_id = clients.id
WHERE
    clients.`pname` LIKE '%/*[VARIABLE]*/%'
GROUP BY
    clients.id
ORDER BY
    clients.`pname` ASC;