<?php
use \Psr\Http\Message\RequestInterface;
use \Psr\Http\Message\ResponseInterface;

// Root
$app->get("/", "Controllers\Users:get");

// Users
$app->get("/users", "Controllers\Users:get");
$app->get("/users/{id}", "Controllers\Users:getById");
$app->post("/createUser", "Controllers\Users:set");
$app->post("/updateUser/{id}", "Controllers\Users:update");
$app->delete("/deleteUser/{id}", "Controllers\Users:delete");
