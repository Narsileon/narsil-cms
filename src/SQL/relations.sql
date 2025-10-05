WITH RECURSIVE cte AS (
    SELECT
        id,
        owner_table,
        owner_id,
        target_table,
        target_id,
        JSON_ARRAY(
            CONCAT(owner_table, ':', owner_id),
            CONCAT(target_table, ':', target_id)
        ) AS visited,
        0 AS processed
    FROM relations
    WHERE owner_table = ?
        AND owner_id = ?
        AND deleted_at IS NULL
    UNION ALL
    SELECT
        r.id,
        r.owner_table,
        r.owner_id,
        r.target_table,
        r.target_id,
        JSON_ARRAY_APPEND(
            cte.visited,
            '$',
            CONCAT(r.target_table, ':', r.target_id)
        ),
        JSON_CONTAINS(
            cte.visited,
            JSON_QUOTE(CONCAT(r.target_table, ':', r.target_id))
        ) AS processed
    FROM relations r
    INNER JOIN cte
        ON cte.target_table = r.owner_table
        AND cte.target_id = r.owner_id
    WHERE cte.processed = 0
        AND r.deleted_at IS NULL
)

SELECT
    id,
    owner_table,
    owner_id,
    target_table,
    target_id
FROM cte