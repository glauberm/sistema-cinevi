<?php

declare(strict_types=1);

namespace Tests\Feature;

interface CrudTestInterface
{
    public function testCreate(): void;

    public function testPaginate(): void;

    public function testShow(): void;

    public function testUpdate(): void;

    public function testRemove(): void;

    public function testRemoveIsAdminGate(): void;
}
