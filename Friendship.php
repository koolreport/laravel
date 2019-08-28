<?php

namespace koolreport\laravel;

use Config;
use \koolreport\core\Utility;

trait Friendship
{
    public function __constructFriendship()
    {

        $base_url = url("");
        $base_url = str_replace("://", "--", $base_url);
        if (strpos($base_url, "/") !== false) {
            $base_url = substr($base_url, strpos($base_url, "/"));
        } else {
            $base_url = "";
        }

        //assets folder
        $assets = Utility::get($this->reportSettings, "assets");
        if ($assets == null) {
            $public_path = str_replace("\\", "/", public_path());
            if (!is_dir($public_path . "/koolreport_assets")) {
                mkdir($public_path . "/koolreport_assets", 0755);
            }
            $assets = array(
                "url" => $base_url . "/koolreport_assets",
                "path" => $public_path . "/koolreport_assets",
            );
            $this->reportSettings["assets"] = $assets;
        }

        //DataSources
        $dbSources = array();
        $dbConfig = Config::get('database');
        $defaultSource = Utility::get($dbConfig, "default");
        if ($defaultSource) {
            $dbSources[$defaultSource] = array(
                "class" => LaravelDataSource::class,
                "name" => $defaultSource,
            );
        }
        foreach ($dbConfig["connections"] as $name => $config) {
            $dbSources[$name] = array(
                "class" => LaravelDataSource::class,
                "name" => $name,
            );
        }
        $dataSources = Utility::get($this->reportSettings, "dataSources", array());
        $this->reportSettings["dataSources"] = array_merge($dbSources, $dataSources);

    }
}
