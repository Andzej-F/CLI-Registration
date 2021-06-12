<?PHP

/* Editing functions */

function editName($newName, $id)
{
    global $pdo;

    /* Edit name query template */
    $query = "UPDATE users
SET name = :newName
WHERE (id = :id)";

    /* Values array for PDO */
    $values = [':newName' => $newName, ':id' => $id];

    /* Execute the query */
    try {
        $res = $pdo->prepare($query);
        $res->execute($values);
    } catch (PDOException $e) {
        /* If there is a PDO exception, throw a standard exception */
        throw new Exception('Database query error');
    }
}

function editEmail($newEmail, $id)
{
    global $pdo;

    /* Edit email query template */
    $query = "UPDATE `users`
SET `email` = :newEmail
WHERE (`id` = :id)";

    /* Values array for PDO */
    $values = [':newEmail' => $newEmail, ':id' => $id];

    /* Execute the query */
    try {
        $res = $pdo->prepare($query);
        $res->execute($values);
    } catch (PDOException $e) {
        /* If there is a PDO exception, throw a standard exception */
        throw new Exception('Database query error');
    }
}

function editPhone($newPhone, $id)
{
    global $pdo;

    /* Edit name query template */
    $query = "UPDATE users
SET phone = :newPhone
WHERE (id = :id)";

    /* Values array for PDO */
    $values = [':newPhone' => $newPhone, ':id' => $id];

    /* Execute the query */
    try {
        $res = $pdo->prepare($query);
        $res->execute($values);
    } catch (PDOException $e) {
        /* If there is a PDO exception, throw a standard exception */
        throw new Exception('Database query error');
    }
}

function editNin($newNin, $id)
{
    global $pdo;

    /* Edit name query template */
    $query = "UPDATE users
SET nin = :newNin
WHERE (id = :id)";

    /* Values array for PDO */
    $values = [':newNin' => $newNin, ':id' => $id];

    /* Execute the query */
    try {
        $res = $pdo->prepare($query);
        $res->execute($values);
    } catch (PDOException $e) {
        /* If there is a PDO exception, throw a standard exception */
        throw new Exception('Database query error');
    }
}

function editDate($newDate, $id)
{
    global $pdo;

    /* Edit name query template */
    $query = "UPDATE users
SET date = :newDate
WHERE (id = :id)";

    /* Values array for PDO */
    $values = [':newDate' => $newDate, ':id' => $id];

    /* Execute the query */
    try {
        $res = $pdo->prepare($query);
        $res->execute($values);
    } catch (PDOException $e) {
        /* If there is a PDO exception, throw a standard exception */
        throw new Exception('Database query error');
    }
}

function editTime($newTime, $id)
{
    global $pdo;

    /* Edit name query template */
    $query = "UPDATE users
SET time = :newTime
WHERE (id = :id)";

    /* Values array for PDO */
    $values = [':newTime' => $newTime, ':id' => $id];

    /* Execute the query */
    try {
        $res = $pdo->prepare($query);
        $res->execute($values);
    } catch (PDOException $e) {
        /* If there is a PDO exception, throw a standard exception */
        throw new Exception('Database query error');
    }
}
