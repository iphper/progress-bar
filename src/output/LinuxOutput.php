<?php

namespace ProgressBar\Output;

use ProgressBar\ProgressBar;

class LinuxOutput extends BaseOutput
{
    // 获取命令行宽度
    public function sttySize(bool $force = false) : int
    {
        if ($force == false && $this->sttySize > 0) {
            return $this->sttySize;
        }
        try {
            $col = trim($this->shellRun('stty size'));
            $col = explode(' ', $col)[1];
            $this->sttySize = $col;
        } catch(\Exception $e) {

        }
        return $this->sttySize;
    }
}

