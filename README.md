# Introduction

Without doubt, [Laravel](https://laravel.com) is the most favorite PHP Framework in the world. It is easy to learn, fast and powerful with full capability for any web application.

Since we created KoolReport we received many questions like "_How to use KoolReport in Laravel?_". The answer is KoolReport was designed to work with any PHP Frameworks and Laravel is one of them. The setting to make them work together is simple but we want to make things simpler.

__Laravel package__ is an add-on extension to make KoolReport work seamlessly in Laravel Framework environment. By adding package, report created with KoolReport will recorgnize Laravel databases automatically. Furthermore, KoolReport's widgets will be configured assets path and url so that all are working without requiring any further set-up effort from you. All with a simple line of code:

```
use \koolreport\laravel\Friendship;
```

While Laravel is PHP Framework for general purpose, KoolReport only __focus on reporting, data processing, charts and graphs__. KoolReport will power Laravel report capability to the max. For fun comparison, Laravel with KoolReport is like _Thanos with Mind Stone_ and this package is like the glove to connect them. Laravel is a __powerful framework__ and KoolReport will make it __better__.

# Requirement

1. KoolReport >= 2.75.0
2. Laravel >= 4.2

# Installation

## By downloading .zip file

1. [Download](https://www.koolreport.com/packages/laravel)
2. Unzip the zip file
3. Copy the folder `laravel` into `koolreport` folder so that look like below

```bash
koolreport
├── core
├── laravel
```

## By composer

```
composer require koolreport/laravel
```

# Documentation

## Step-by-step tutorial

#### Step 1: Create report and claim friendship with Laravel

1. First, you create folder `Reports` inside Laravel's `app` folder
2. Inside Reports folder, create two files `MyReport.php` and `MyReport.view.php`
3. Adding `use \koolreport\laravel\Friendship` to your report like following

`MyReport.php`

```
<?php
namespace App\Reports;

class MyReport extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    // By adding above statement, you have claim the friendship between two frameworks
    // As a result, this report will be able to accessed all databases of Laravel
    // There are no need to define the settings() function anymore
    // while you can do so if you have other datasources rather than those
    // defined in Laravel.
    

    function setup()
    {
        // Let say, you have "sale_database" is defined in Laravel's database settings.
        // Now you can use that database without any futher setitngs.
        $this->src("sale_database")
        ->query("SELECT * FROM offices")
        ->pipe($this->dataStore("offices"));        
    }
}
```

`MyReport.view.php`

```
<?php
use \koolreport\widgets\koolphp\Table;
?>
<html>
    <head>
    <title>My Report</title>
    </head>
    <body>
        <h1>It works</h1>
        <?php
        Table::create([
            "dataSource"=>$this->dataStore("offices")
        ]);
        ?>
    </body>
</html>
```

#### Step 2: Run report and display report

Now you have MyReport ready, in order to get report display inside Laravel, you will create MyReport's object in controller and pass that object to the view to render.


`HomeController.php`

```
<?php

namespace App\Http\Controllers;

use App\Reports\MyReport;

class HomeController extends Controller
{
public function __contruct()
    {
        $this->middleware("guest");
    }
    public function index()
    {
        $report = new MyReport;
        $report->run();
        return view("report",["report"=>$report]);
    }
}
```

`report.blade.php`

```
<?php $report->render(); ?>
```

## Other notes

### Auto-generated assets

__Laravel packages__ will automatically create a folder name `koolreport_assets` inside Laravel's `public` folder in order to hold the report resources such as Javascript files or CSS file.


### Other datasources other than Laravel's default

If you have another datasources rather than Laravel's datasources, feel free to add them in `settings()` function as you normally do. For example, in below example code, we will have anoher csv source:

```
class MyReport extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    function settings()
    {
        return array(
            "dataSources"=>array(
                "csv_source"=>array(
                    "class"=>'\koolreport\datasources\CSVDataSource',
                    'filePath'=>dirname(__FILE__)."\mycsvdata.csv",
                )
            )
        );
    }
}
```

### Customize assets folder

By default, adding `Friendship` will configure assets path and url for report automatically. But in some cases that you would like to set your own location, you can do:

```
class MyReport extends \koolreport\KoolReport
{
    function settings()
    {
        return array(
            "assets"=>array(
                "path"=>"../../public/resources/kool"
                "url"=>"resources/kool"
            )
        );
    }
}
```

The `path` can be ralative path from the report to the assets folder or absolute path to assets folder.

The `url` is the browser url to access the assets folder.


# Support

Please use our forum if you need support, by this way other people can benefit as well. If the support request need privacy, you may send email to us at __support@koolreport.com__.