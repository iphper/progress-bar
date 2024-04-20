<?php

namespace ProgressBar\Output;

/**
 * 输出工厂
 */
class OutputFactory
{
    // 禁止实例化
    private function __construct()
    {

    }

    // 禁止克隆
    private function clone()
    {
        
    }

    // 禁止序列化
    public function __sleep()
    {

    }

    /**
     * @method make
     * @desciption 根据系统生成输出对象
     * @return OutputInterface
     */
    public static function make() : OutputInterface
    {
        $os = ucfirst(strtolower(PHP_OS));
        $class = __NAMESPACE__.'\\'.$os.'Output';

        if (true || class_exists($class)) {
            return new $class(...func_get_args());
        }

        // not found class
        throw new \Exception('Class ' . $class . ' not found');
    }

}
