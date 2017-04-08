<?php

namespace Api\Exceptions;

/**
 * Missing URI exception.
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class MissingUriException extends \Exception
{
    /**
     * MissingUriException constructor.
     *
     * @param string $className
     */
    public function __construct($className)
    {
        $message = "Class '{$className}' does not have a URI defined";

        parent::__construct($message);
    }
}
