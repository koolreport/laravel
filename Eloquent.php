<?php

namespace koolreport\laravel;

use \koolreport\core\Utility;

class Eloquent extends \koolreport\core\DataSource
{
    protected $builder;
    /**
     * Insert eloquent buikder to the pipe.
     * 
     * @param mixed $builder 
     */
    public function query($builder)
    {
        $this->builder = $builder;
        return $this;
    }

    /**
     * Start piping data
     *
     * @return null
     */
    public function start() 
    {
        $metaData = null;
        foreach($this->builder->cursor() as $item)
        {
            if(!$metaData)
            {
                $metaData = array(
                    "columns"=>array()
                );
                foreach($item->toArray() as $k=>$v)
                {
                    $metaData["columns"][$k] = array(
                        "type"=>Utility::guessType($v)
                    );
                }
                $this->sendMeta($metaData, $this);
                $this->startInput(null);
            }
            $this->next($item->toArray(), $this);
        }
        $this->endInput(null);
    }
}