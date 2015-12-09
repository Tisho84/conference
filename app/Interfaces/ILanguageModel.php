<?php

namespace App\Interfaces;

interface ILanguageModel {
    public function scopeLang($query, $id = null);
}