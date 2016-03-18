# Yii Extension for Zumba ***Swivel***

This plugin provides the necessary elements for using Swivel in a Yii 1.1+ Application.

This plugin is based on the zumba/swivel-cake plugin.

### Configuration for Yii Component:

By default, the component is assumed to be under the /protected/vendors/ directory, if your composer.json is under the
protected folder. If you need to change that location, simply update the extensionAlias in the configuration array. 

```php
 'swivel' => [ 
 	'class'=>'SwivelComponent' 
 ],
```
```php
 'swivel' => [ 
	'class'=>'SwivelComponent',
 	'extensionAlias'=>'application.extensions.swivel',
 ],
```

### Access from the application
```php
// If the user has the feature behavior bucket enabled, use the testFeature.New.Something behavior,
// else use the default
Yii::app()->swivel->forFeature( 'testFeature' )
	->addBehavior('New.Something', [$this,'doSomethingB'], $args)
	->defaultBehavior([$this, 'doSomethingA'], $args )
	->execute();

// If the user has the feature behavior bucket enabled, use the first callable,
// else use the second callable (default)
Yii::app()->swivel->invoke('testFeature.New.Something', [$this,'doSomethingB'],[$this, 'doSomethingA']);
```

Make sure that your bootstrap file is set to properly include the composer autoloader. This extension assumes that 
your vendor directory is under the protected folder, so if that is not the case, please make sure you adjust the 
paths accordingly in the require and configuration options.

In the index.php bootstrap:
```php
require(__DIR__ . '/protected/vendor/autoload.php');
```

#### The ***Swivel*** Libraries 

https://github.com/zumba/swivel 

https://github.com/zumba/swivel-cake
