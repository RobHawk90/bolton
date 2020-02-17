<?php

namespace Bolton\Repository;

interface Repository {
    public function beginTransaction(): void;

    public function commit(): void;

    public function rollBack(): void;
}
