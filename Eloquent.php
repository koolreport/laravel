<?php

namespace koolreport\laravel;

use \koolreport\core\Utility;

class Eloquent extends \koolreport\core\DataSource
{
    /**
     * Insert eloquent buikder to the pipe.
     * 
     * @param mixed $builder 
     */
    protected $builder;
    protected $retrievingMethod;
    
    public function query($builder, $retrievingMethod = null)
    {
        $this->builder = $builder;
        $this->retrievingMethod = $retrievingMethod;
        return $this;
    }

    public function sendMetaAndItem($metaData, $item) 
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

    /**
     * Start piping data
     *
     * @return null
     */
    public function start() 
    {
        $metaData = null;
        if ($this->retrievingMethod == 'lazy') {
            foreach($this->builder::lazy() as $item)
            {
                $this->sendMetaAndItem($metaData, $item);
            }
        } else {
            foreach($this->builder->cursor() as $item)
            {
                $this->sendMetaAndItem($metaData, $item);
            }
        }
        $this->endInput(null);
    }
}