WITH RECURSIVE cte AS (
    SELECT
        id,
        owner_table,
        owner_uuid,
        target_table,
        target_uuid,
        JSON_ARRAY(
            CONCAT(owner_table, ':', owner_uuid),
            CONCAT(target_table, ':', target_uuid)
        ) AS visited,
        0 AS processed
    FROM relations
    WHERE owner_table = ? AND owner_uuid = ?
    UNION ALL
    SELECT
        r.id,
        r.owner_table,
        r.owner_uuid,
        r.target_table,
        r.target_uuid,
        JSON_ARRAY_APPEND(
            cte.visited,
            '$',
            CONCAT(r.target_table, ':', r.target_uuid)
        ),
        JSON_CONTAINS(
            cte.visited,
            JSON_QUOTE(CONCAT(r.target_table, ':', r.target_uuid))
        ) AS processed
    FROM relations r
    INNER JOIN cte
        ON cte.target_table = r.owner_table
        AND cte.target_uuid = r.owner_uuid
    WHERE cte.processed = 0
)
SELECT
    id,
    owner_table,
    owner_uuid,
    target_table,
    target_uuid
FROM cte