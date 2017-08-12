# DiveCalculator

## A Laravel Package to Calculate Dive Stats from the PADI RDP

**This package is for informational use only, the author accepts no liability for calculations
made using this package.**

**All divers should perform and check their own calculations with approved charts or devices.**

###Installation
This package is not on packagist yet, so you will need to add the following information to your composer.json file.

Create or add to your repositories section:
```
"repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/ambielecki/dive-calculator"
    }
]
```
In your require section add:
```
"require": {
    "ambielecki/dive-calculator": "1.*"
}
```

Run
```
composer update
```
And you should be good to go.

###Simple Usage
Pardon the formating, markdown and all.

All times should be in minutes, all depths in feet.  I'm in the US, so only Imperial for now.
```php
use Ambielecki\DiveCalculator\DiveCalculator;

$depth = 50;
$time = 45;
$diveCalculator = new DiveCalculator();
$pressuregroup = $diveCalculator->getPressureGroup($depth, $time);

```

###Available Methods
getPressureGroup($depth, $time, $residual_time = null)

getNewPressureGroup($starting_group, $surface_interval)

getResidualNitrogenTime($pressure_group, $depth)

getMaxBottomTime($depth, $rnt = 0)
