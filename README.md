# AnhDateTimePickerBundle

Symfony bundle which implements jQuery UI date and time pickers in a Form Type Extension.

## Download using composer

```sh
$ php composer.phar require anh/datetimepicker-bundle
```

## Enable the bundle

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Anh\DateTimePickerBundle\AnhDateTimePickerBundle(),
    );
}
```

## Install assets

```sh
$ app/console sp:bower:install
```

## Create form filed

```php
<?php
// Form/ExampleType.php

public function buildForm(FormBuilderInterface $builder, array $options)
{
    // ...
    $builder
        ->add('dateTimeField', 'datetime', array(
            'picker' => true,
            'format' => 'yyyy-MM-dd HH:mm:ss',
            'separator' => ' '
        ))
    ;
    // ...
    $builder
        ->add('dateField', 'date', array(
            'picker' => true,
            'format' => 'dd.MM.yyyy'
        ))
    ;
    // ...
    $builder
        ->add('timeField', 'time', array(
            'picker' => true,
            'with_seconds' => true
        ))
    ;
    // ...
}
```

## Include resources

Bundle provides assets for javascript and stylesheet — `@dateTimePicker_js` and `@dateTimePicker_css`. Don't forget to include jQuery and jQuery UI.

```html
{% block javascripts %}
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

    {% javascripts
        '@anh_dateTimePicker_js'
    %}<script src="{{ asset_url }}"></script>{% endjavascripts %}
{% endblock %}
```

```html
{% block stylesheets %}
    <link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.min.css" rel="stylesheet">

    {% stylesheets
        '@anh_dateTimePicker_css'
    %}<link rel="stylesheet" href="{{ asset_url }}" />{% endstylesheets %}
{% endblock %}
```