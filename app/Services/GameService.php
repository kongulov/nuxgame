<?php

namespace App\Services;

class GameService
{
    public function play()
    {
        $rand = random_int(1, 1000);
        $isWin = false;
        $win = 0;

        if ($rand % 2 == 0) {
            $isWin = true;

            if ($rand > 900) {
                $win = $rand * 0.7;
            } elseif ($rand > 600) {
                $win = $rand * 0.5;
            } elseif ($rand > 300) {
                $win = $rand * 0.3;
            } else {
                $win = $rand * 0.1;
            }
        }

        return [
            'is_winner' => $isWin,
            'rand' => $rand,
            'amount' => $win,
        ];
    }
}
