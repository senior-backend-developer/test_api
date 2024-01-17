<?php

namespace app\components\Token;

interface TokenInterface
{
    /**
     * @param int $user_id
     * @return string|null
     */
    public function generate(int $user_id): ?string;
}