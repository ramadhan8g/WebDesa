<?php



/**
 * Define a custom exception class
 */
class MyException extends Exception
{
    /**
     * Exception khusus untuk tabel referensi kosong.
     *
     * {@inheritDoc}
     */
    public function __construct(string $message, int $code = 99001, ?Throwable $previous = null)
    {
        parent::__construct("[PERIKSA] Tabel referensi kosong: {$message}", $code, $previous);
    }
}
