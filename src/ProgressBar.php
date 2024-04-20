<?php

namespace ProgressBar;

use ProgressBar\Output\OutputFactory;
use ProgressBar\Output\OutputInterface;

/**
 * @class ProgressBar
 * @description 命令行进度条
 * @author gping123
 * @date 2024-04-16
 */
class ProgressBar
{
    /**
     * @var int total 总进度
     */
    protected int $total = 0;

    /**
     * @var int current 当前进度
     */
    protected int $current = 0;

    /** @var OutputInterface $stdOutput */
    protected $stdOutput = null;

    /**
     * @method __construct
     * @desciption 构造方法
     */
    public function __construct(int $total = 0)
    {
        $this->setTotal($total);

        // 加载依赖类
        $this->initialize();
    }

    /**
     * @method initialize
     * @desciption 初始化方法
     */
    public function initialize() : void
    {
        $this->loading();
    }

    /**
     * @method loading
     * @desciption 加载依赖项
     */
    public function loading() : void
    {
        // 输出依赖
        $this->setStdOutput(OutputFactory::make());
    }

    // ====== protected methods ======
    
    /**
     * @method render
     * @desciption 渲染
     */
    protected function render()
    {
        if ($this->current > $this->total) {
            return ;
        }
        return $this->stdOutput->render($this);
    }

    // ====== setter and getter ======

    /**
     * @method setTotal
     * @desciption 设置总进度
     * @param $total 总进度值
     * @return self
     */
    public function setTotal(int $total) : self
    {
        $this->total = $total;
        return $this;
    }

    /**
     * @method setTotal
     * @desciption 设置当前进度
     * @param int $current 当前进度值
     * @return self
     */
    public function setCurrent(int $current) : self
    {
        $this->current = $current;
        $this->render($this);
        return $this;
    }

    /**
     * @method setStdOutput
     * @desciption 设置终端输出依赖
     * @param StdOutputInterface $stdOutput 终端输出依赖
     * @return self
     */
    public function setStdOutput(OutputInterface $stdOutput) : self
    {
        $this->stdOutput = $stdOutput;
        return $this;
    }

    /**
     * @method getStdOutput
     * @desciption 获取输出对象
     * @return OutputInterface
     */
    public function getStdOutput() : OutputInterface
    {
        return $this->stdOutput;    
    }

    /**
     * @method getTotal
     * @desciption 获取总进度
     * @return int
     */
    public function getTotal() : int
    {
        return $this->total;
    }

    /**
     * @method getCurrent
     * @desciption 获取当前进度
     * @return int
     */
    public function getCurrent() : int
    {
        return $this->current;
    }

    // ====== actions methods ======

    /**
     * @method setTotal
     * @desciption 添加当前进度
     * @param int $step 步长
     * @return self
     */
    public function add(int $step = 1) : self
    {
        $this->current += $step;
        $this->render();
        return $this;
    }

    /**
     * @method
     * @desciption 重置进度条
     */
    public function reset() : self
    {
        return $this->setCurrent(0);
    }

}
