<?php

require __DIR__.'/../vendor/autoload.php';

use ProgressBar\ProgressBar;

// 简单示例

$total = 1000;

// 测试
$pb = new ProgressBar($total);

for($i = 0; $i < $total; ++$i) {
    $pb->add();
    usleep(10000);
}

// 重置
$pb->reset();

// 修改Output
$output = $pb->getStdOutput();// 或 \ProgressBar\Output\OutputFactory::make();
$output->setUnfinishedChar('-');
$output->setDoneChar('=');
$pb->setStdOutput($output);

// 测试
$step = 5;
for($i = 0; $i < $total; $i += $step) {
    $pb->add($step); // 传入步长
    usleep(10000);
}