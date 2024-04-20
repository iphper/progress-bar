<?php

namespace ProgressBar\Output;

/**
 * @interface StdOutputInterface
 * @desciption 输出终端接口
 */
interface OutputInterface
{
    // 初始化
    public function initialize();
    
    // 获取命令行宽度
    public function sttySize() : int;

    // 渲染
    public function render($pb);
}
