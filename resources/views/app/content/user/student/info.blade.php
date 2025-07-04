<div class="container">
    <h2 class="mb-4">Student's data</h2>

    <div class="card mb-4">
        <div class="card-header aplus-bg-dark-orange text-white">Basic information</div>
        <div class="card-body">
            <p><strong>Name and surname:</strong> {{ $student->user->Name }}</p>
            <p><strong>E-mail:</strong> {{ $student->user->Email }}</p>
            <p><strong>Class:</strong> {{ $class->Name }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header aplus-bg-dark-violet text-white">Grades</div>
        <div class="card-body">
            @if ($student->grades->count() > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Przedmiot</th>
                            <th>Ocena</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($student->grades as $grade)
                            <tr>
                                <td>{{ $grade->SubjectName ?? 'Unknown' }}</td>
                                <td>{{ $grade->Mark }}</td>
                                <td>{{ $grade->CreationDate->format('Y-m-d') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No grades to show.</p>
            @endif
        </div>
    </div>
</div>