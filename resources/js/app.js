/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

require('./bootstrap');

import { ExcelFileCalculationsController } from "./controllers/ExcelFileCalculationsController";


$(function(){

    var excelFileCalculationsController = new ExcelFileCalculationsController();
    excelFileCalculationsController.init();
});



