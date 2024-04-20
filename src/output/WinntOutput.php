<?php

namespace ProgressBar\Output;

use ProgressBar\ProgressBar;

class WinntOutput extends BaseOutput
{
    // 获取命令行宽度
    public function sttySize(bool $force = false) : int
    {
        try {
            $col = $this->shellRun('mode con');
            $col = preg_replace('/\s+/i', ' ', $col);
            $this->sttySize = (int) explode(" ", substr($col, strpos($col, 'Columns')))[1];
        } catch(\Exception $e) {
            
        }
        return $this->sttySize;
    }
}

