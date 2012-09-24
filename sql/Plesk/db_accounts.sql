SELECT
    domains.name AS domain
    ,data_bases.name AS db
    ,db_users.login AS user
    ,CAST(accounts.`password` AS CHAR) AS pass
FROM
    db_users
    LEFT JOIN accounts ON accounts.id = db_users.account_id
    LEFT JOIN data_bases ON data_bases.id = db_users.db_id
    LEFT JOIN domains ON domains.id = data_bases.dom_id
WHERE
    domains.`name` LIKE '%/*[VARIABLE]*/%'
ORDER BY
    domains.`name` ASC;