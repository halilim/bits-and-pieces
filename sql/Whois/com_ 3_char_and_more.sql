SELECT
	whois_domain.`name`,
	whois_domain.sld,
	whois_domain.tld
FROM
	whois_domain
WHERE
	whois_domain.available = 1 AND
	whois_domain.tld = 'com' AND
	(whois_domain.sld = '' OR
	whois_domain.sld IS NULL) AND
	CHARACTER_LENGTH(whois_domain.`name`) = LENGTH(whois_domain.`name`) AND
	LENGTH(whois_domain.`name`) > 2 AND
	whois_domain.`name` REGEXP '^[^0-9\-]*$'
ORDER BY
	CHARACTER_LENGTH(whois_domain.`name`) ASC
LIMIT
	0, 1000