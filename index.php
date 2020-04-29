<?php

// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Start a session
session_start();

// Require the autoload file
require_once("vendor/autoload.php");

// Instantiate the F3 Base Class
$f3 = Base::instance();

// Default route
$f3->route('GET /', function()
{
    //echo '<h1>Welcome to my Food Page</h1>';

    $view = new Template();
    echo $view->render('views/home.html');
});

// Default route to Orders
$f3->route('GET|POST /order', function($f3)
{
    //echo '<h1>Welcome to my Food Page</h1>';

    // If the form has been submitted
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        var_dump($_POST);
        //array(2) { ["food"]=> string(5) "Tacos" ["meal"]=> string(2) "on" }

        // Validate the data
        $meals = array("breakfast", "lunch", "dinner");
        if (empty($_POST['food']))
        {
            echo "<p>Please enter a food</p>";
        }
        elseif (!in_array($_POST['meal'], $meals))
        {
            echo "<p>Please enter a meal</p>";
        }
        // Data is valid
        else
        {
            // Store the data in the session array
            $_SESSION['food'] = $_POST['food'];
            $_SESSION['meal'] = $_POST['meal'];

            // Redirect to summary page
            $f3->reroute('summary');
            session_destroy();
        }
    }
    $view = new Template();
    echo $view->render('views/orderForm.html');
});

// Breakfast route
$f3->route('GET /breakfast', function()
{
    //echo '<h1>Welcome to my Breakfast Page</h1>';

    $view = new Template();
    echo $view->render('views/bfast.html');
});

// Breakfast - green eggs & ham route
$f3->route('GET /breakfast/green-eggs', function()
{
    //echo '<h1>Welcome to my Breakfast Page</h1>';

    $view = new Template();
    echo $view->render('views/greenEggsAndHam.html');
});

// Breakfast - Cereals
$f3->route('GET /breakfast/cereal', function()
{
    //echo '<h1>Welcome to my Breakfast Page</h1>';

    $view = new Template();
    echo $view->render('views/cereal.html');
});

// Breakfast route
$f3->route('GET /summary', function()
{
    //echo '<h1>Thank you for your order!</h1>';

    $view = new Template();
    echo $view->render('views/summary.html');
});

// Run F3
$f3->run();

