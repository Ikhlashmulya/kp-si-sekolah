<?php

namespace App\Dto;

class GetByDateDto
{
    public function __construct(
        public string $month,
        public string $year
    ) {
    }
}
