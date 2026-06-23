<?php
/**
 * Module: Controller
 * Created: 2026-06-23
 * Author: Raditya Natha Azra
 * Synopsis: Base Controller class
 * 
 * Functions:
 *   - 
 * 
 * Input Parameters:
 *   - 
 * 
 * Return Values:
 *   - 
 */

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
