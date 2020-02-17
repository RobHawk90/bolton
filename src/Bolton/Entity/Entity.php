<?php

namespace Bolton\Entity;

interface Entity
{
    public function toJson(): String;

    public function toArray(): Array;
}
