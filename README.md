# Yii Extension for Zumba ***Swivel***

This plugin provides the necessary elements for using Swivel in a Yii 1.1+ Application.

This plugin is based on the zumba/swivel-cake plugin.

### Configuration for Yii Component:

By default, the component is assumed to be under the /protected/extensions/ directory. If you need to change that 
location, simply update the extensionAlias in the configuration array. 

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
// If the user has the feature behavior bucket enabled, use the testFeature.New.Something behavior, else use the default
Yii::app()->swivel->forFeature( 'testFeature' )
	->addBehavior('New.Something', [$this,'doSomethingB'], $args)
	->defaultBehavior([$this, 'doSomethingA'], $args )
	->execute();

// If the user has the feature behavior bucket enabled, use the first callable, else use the second callable (default)
Yii::app()->swivel->invoke('testFeature.New.Something', [$this,'doSomethingB'],[$this, 'doSomethingA']);
```

#### The ***Swivel*** Libraries 

https://github.com/zumba/swivel 

https://github.com/zumba/swivel-cake
