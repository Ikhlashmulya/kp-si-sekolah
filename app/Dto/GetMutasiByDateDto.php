<?php

namespace App\Dto;

class GetMutasiByDateDto
{
    public function __construct(
        public string $month,
        public string $year
    ) {
    }
}
