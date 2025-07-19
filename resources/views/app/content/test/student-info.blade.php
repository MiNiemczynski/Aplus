<?php
use App\Helpers\ColorHelper;
?>

<div class="container">
    <h2 class="mb-4">{{ $subject }} test</h2>

    <div class="card mb-4">
        <div class="card-header {{ ColorHelper::randomColor() }} text-white">Basic information</div>
        <div class="card-body">
            <p><strong>Date: </strong> {{ $date }}</p>
            <p><strong>Subject: </strong> {{ $subject }}</p>
            <p><strong>Grade: </strong> {!! $grade->Mark ?? '<i>no grade</i>' !!} </p>
            <p><strong>Created at: </strong> {{ $test->CreationDate }}</p>
            <p><strong>Edited at: </strong> {{ $test->EditionDate != $test->CreationDate ? $test->EditionDate : "not edited" }}</p>
        </div>
    </div>
</div>