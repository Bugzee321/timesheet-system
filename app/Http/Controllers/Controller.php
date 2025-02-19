<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Laravel API Documentation",
 *      description="Swagger API documentation for Laravel project",
 *      @OA\Contact(
 *          email="support@example.com"
 *      )
 * )
 * 
 * @OA\SecurityScheme(
 *      securityScheme="passport",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT"
 * )
 */
abstract class Controller
{
    //
}
