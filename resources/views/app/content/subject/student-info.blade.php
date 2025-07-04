<div class="container">
    <h2 class="mb-4">Subject data</h2>

    <div class="card mb-4">
        <div class="card-header aplus-bg-dark-green text-white">Basic information</div>
        <div class="card-body">
            <p><strong>Name: </strong> {{ $subject->Name }}</p>
            <p><strong>Grades: </strong>
                @forelse ($grades as $grade)
                    {{ $grade->Mark }},
                @empty
                    <i>no grades</i>
                @endforelse
            </p>
            <p><strong>Final grade: </strong> {!! $finalGrade ?? '<i>no final grade</i>' !!}</p>
        </div>
    </div>
</div>