<div class="container">
    <h2 class="mb-4">Subject data</h2>

    <div class="card mb-4">
        <div class="card-header aplus-bg-dark-green text-white">Basic information</div>
        <div class="card-body">
            <p><strong>Name: </strong> {{ $subject->Name }}</p>
            <p><strong>Created at: </strong> {{ $subject->CreationDate }}</p>
            <p><strong>Edited at: </strong> {{ $subject->EditionDate != $subject->CreationDate ? $subject->EditionDate : "not edited" }}</p>
        </div>
    </div>
</div>