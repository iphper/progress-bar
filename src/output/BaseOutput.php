<?php

namespace ProgressBar\Output;

/**
 * @class BaseOutput
 * @desciption 抽象输出器类
 */
abstract class BaseOutput implements OutputInterface
{
    /** @var array $args 一些参数 */
    protected array $args = [];

    /** @var int $sttySize 屏幕宽度 */
    protected int $sttySize = 100;

    /** @var array $frontier 进度条两端字符 */
    protected array $frontier = [
        '[', ']'
    ];

    // 未完成字符
    protected string $unfinishedChar = ' ';
    // 已完成字符
    protected string $doneChar = '■';

    /**
     * @method __construct
     * @desciption 构造方法
     */
    public function __construct(?int $sttySize = null)
    {
        $this->args = func_get_args();

        // 默认设置屏幕宽度
        is_null($sttySize) or $this->setSttySize($sttySize);

        $this->initialize();
    }
    
    /**
     * @method initialize
     * @desciption 初始化方法
     */
    public function initialize()
    {
        $this->sttySize();
    }
    
    // 获取命令行宽度 [具体类实现]
    abstract public function sttySize(bool $force = false) : int;

    /**
     * @method render
     * @desciption 渲染方法
     * @param ProgressBar $pb
     * @template [===----] 50/100( 50%)
     */
    public function render($pb)
    {
        // 获取进度信息
        $total = $pb->getTotal();
        $current = $pb->getCurrent();
        
        // 计算占比 
        $rate = number_format($current / $total, 2);

        // 步数显示【单边显示字符宽度】
        $steplen = strlen("" . $total);
        // 总步数显示宽度
        $stepTotalLen = $steplen * 2 + 1;

        // 占比显示字符宽度
        $rateLen  = strlen('(100%)');

        // 进度条总字符长度【不包括其它显示】 
        $progressBarLen = $this->sttySize - $stepTotalLen - $rateLen - 2;

        // 完成字符数
        $doneLen = floor($progressBarLen * $rate);

        // 已完成字符串
        $doneStr = str_repeat($this->doneChar, $doneLen);
        // 未完成才计算未完成字符串
        $unfinishedStr = $progressBarLen > $doneLen ? str_repeat($this->unfinishedChar, $progressBarLen - $doneLen) : "";

        // 计算占比
        printf(
            "%1s%s%s%1s%{$steplen}d%1s%-{$steplen}d%{$rateLen}s" . ($current >= $total ? "\n" : "\r"), 
            $this->frontier[0], 
            $doneStr, 
            $unfinishedStr, 
            $this->frontier[1], 
            $current, '/', $total,
            sprintf("(%3d%%)", $rate * 100)
        );
    }

    // ====== protected methods ======
    /**
     * @method shellRun
     * @desciption 运行命令行
     * @param string $cmd
     * @throw \Exception
     * @return ?string
     */
    public function shellRun(string $cmd) : ?string
    {
        if (function_exists('shell_exec')) {
            return shell_exec($cmd);
        }
        throw new \Exception('shell_exec function not found');
    }

    // ====== setter and getter ======
    /**
     * @method setFrontier
     * @desciption 设置进度条边界符
     * @param array $frontier
     * @return self
     */
    public function setFrontier(array $frontier) : self
    {
        $this->frontier = array_merge($this->frontier, $frontier);
        return $this;
    }

    /**
     * @method getFrontier
     * @desciption 获取进度条边界符
     * @return array
     */
    public function getFrontier() : array
    {
        return $this->frontier;
    }

    /**
     * @method setUnfinishedChar
     * @desciption 设置未完成进度字符
     * @param string $unfinishedChar
     * @return self
     */
    public function setUnfinishedChar(string $unfinishedChar) : self
    {
        $this->unfinishedChar = $unfinishedChar;
        return $this;
    }

    /**
     * @method getUnfinishedChar
     * @desciption 获取未完成进度字符
     * @return string
     */
    public function getUnfinishedChar() : string
    {
        return $this->unfinishedChar;
    }

    /**
     * @method setDoneChar
     * @desciption 设置已完成进度字符
     * @param string $doneChar
     * @return self
     */
    public function setDoneChar(string $doneChar) : self
    {
        $this->doneChar = $doneChar;
        return $this;
    }

    /**
     * @method getDoneChar
     * @desciption 获取已完成进度字符
     * @return string
     */
    public function getDoneChar() : string
    {
        return $this->doneChar;
    }

    /**
     * @method setSttySiZe
     * @desciption 设置屏幕宽度
     * @param int $sttySize
     * @return self
     */
    public function setSttySize(int $sttySize) : self
    {
        $this->sttySize = $sttySize;
        return $this;
    }

}
