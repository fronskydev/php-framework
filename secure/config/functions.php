<?php

/**
 * Starts a new session if one doesn't already exist.
 *
 * @return void
 */
function startSession(): void
{
    if (session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }
}

/**
 * Checks if a specific session variable is active and has a value.
 *
 * @param string $name The name of the session variable to check.
 * @return bool True if the session variable is active and has a value, otherwise false.
 */
function isSessionActive(string $name): bool
{
    startSession();
    return isset($_SESSION[$name]) && $_SESSION[$name] !== "";
}

/**
 * Sets a value for a specific session variable.
 *
 * @param string $name The name of the session variable to set.
 * @param string $value The value to assign to the session variable.
 * @return void
 */
function setSessionValue(string $name, string $value): void
{
    startSession();
    $_SESSION[$name] = $value;
}

/**
 * Deletes a specific session variable and associated data.
 *
 * @param string $name The name of the session variable to delete.
 * @return void
 */
function deleteSession(string $name): void
{
    startSession();
    if (isSessionActive($name))
    {
        $_SESSION[$name] = "";
        unset($_SESSION["data"]);
    }
}

/**
 * Retrieves the value of a specific session variable.
 *
 * @param string $name The name of the session variable to retrieve.
 * @return mixed|null The value of the session variable, or null if the session variable is not active.
 */
function getSessionValue(string $name): mixed
{
    if (isSessionActive($name))
    {
        startSession();
        return $_SESSION[$name];
    }

    return null;
}

/**
 * Checks if a specific cookie is active.
 *
 * @param string $name The name of the cookie to check.
 * @return bool True if the cookie is active, otherwise false.
 */
function isCookieActive(string $name): bool
{
    if (isset($_COOKIE[$name])) {
        return true;
    }

    return false;
}

/**
 * Sets a cookie with the provided values and options.
 *
 * @param string $name The name of the cookie.
 * @param string $value The value to be stored in the cookie.
 * @param int $expiration The expiration time of the cookie in Unix timestamp format. Default is one year from the current time.
 * @param string $path The path on the server where the cookie will be available. Default is "/".
 * @param string $domain The domain for which the cookie is valid. Default is an empty string.
 * @param bool $secure If true, the cookie will only be sent over secure HTTPS connections. Default is false.
 * @param bool $httpOnly If true, the cookie will be accessible only through HTTP(S) and not JavaScript. Default is false.
 * @return void
 */
function setCookieValue(string $name, string $value, int $expiration = 0, string $path = "/", string $domain = "", bool $secure = false, bool $httpOnly = false): void
{
    if ($expiration === 0)
    {
        $expiration = time() + 31536000;
    }

    setcookie($name, $value, $expiration, $path, $domain, $secure, $httpOnly);
}

/**
 * Deletes a specific cookie.
 *
 * @param string $name The name of the cookie to delete.
 * @param string $path The path on the server where the cookie is available. Default is "/".
 * @param string $domain The domain for which the cookie is valid. Default is an empty string.
 * @return void
 */
function deleteCookie(string $name, string $path = "/", string $domain = ""): void
{
    if (isCookieActive($name))
    {
        setcookie($name, "", time() - 3600, $path, $domain);
    }
}

/**
 * Retrieves the value of a specific cookie.
 *
 * @param string $name The name of the cookie to retrieve.
 * @return mixed|null The value of the cookie, or null if the cookie is not active.
 */
function getCookieValue(string $name): mixed
{
    if (isCookieActive($name))
    {
        return $_COOKIE[$name];
    }

    return null;
}

/**
 * Generates a random string of a specified length.
 *
 * @param int $length The length of the random string to generate.
 *
 * @return string The generated random string.
 * @noinspection RandomApiMigrationInspection
 */
function generateRandomString(int $length): string
{
    $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $charactersLength = strlen($characters);
    $randomString = "";

    for ($i = 0; $i < $length; $i++) {
        try {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        } catch (Exception) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
    }

    return $randomString;
}
