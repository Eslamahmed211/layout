<?php


use Illuminate\Support\Facades\Schedule;


Schedule::command('campaigns:run')->everyFiveSeconds();
