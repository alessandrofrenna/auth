# Auth extension for YII2

Allow your users to connecto to your Yii application with this module.

# Installation 

To install the module, you have to do: 

`composer require frenna\auth`
 
or import the package inside your `require` section in `composer.json`

` "frenna\auth" : "dev-master" `

# Configuration

Inside your main Yii2 configuration file, you should add the following section:
``

```php
  ...
  
  "modules" => [
      "auth" => [
          "class" => "frenna\auth\models\User",
      ],
  ],
  
  ...
  
```

Edit also your `components` section to set the appropriate `user`:


```php
  ...
  
  "components" => [
      ...
      "user" => [
          "class" => "frenna\auth\models\User",
      ],
      ...
  ],
  ...
  
```
