SELECT
    CONCAT(mail_name, "@", `name`) AS email_address,
    CAST(accounts.password AS CHAR) AS password
FROM
    mail
    LEFT JOIN domains ON domains.id = mail.dom_id
    LEFT JOIN accounts ON accounts.id = mail.account_id
WHERE
    CONCAT(mail_name, "@", `name`) LIKE '%/*[VARIABLE]*/%';