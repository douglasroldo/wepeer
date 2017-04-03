<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
       
        {{ get_title() }}
        {{ stylesheet_link('css/bootstrap.min.css') }}
 {{ stylesheet_link('css/jquery-ui-1.9.2.custom.min.css') }}
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Your invoices">
        <meta name="author" content="WePeer">
    </head>
    <body>
     <link rel="icon" type="image/ico" href="wepeer.ico"/>
 {{ javascript_include('js/jquery.min.js') }}
 {{ javascript_include('js/jquery-ui-1.9.2.custom.min.js') }}
        {{ javascript_include('js/bootstrap.min.js') }}
        {{ javascript_include('js/utils.js') }}
        {{ content() }}
       
    </body>
</html>