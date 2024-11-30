<?php

namespace database\Exception;

use Exception;

class DatabaseException extends Exception
{
    /**
     * Custom constructor for the DatabaseException class.
     *
     * @param string $message The error message for the exception.
     * @param int $code The error code (optional). Defaults to 0.
     * @param Exception|null $previous The previous exception used for chaining (optional).
     */
    public function __construct(string $message, int $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Convert the DatabaseException object to a string representation.
     *
     * @return string A string representation of the DatabaseException object.
     */
    public function __toString(): string
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}