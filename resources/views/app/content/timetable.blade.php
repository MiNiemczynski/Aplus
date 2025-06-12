<?php
use Carbon\Carbon;
?>
<div class="row">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="{{ route($role . '.timetable', ['offset' => $offset - 1]) }}" class="btn btn-outline-success">
      < Previous </a>
        <h4>Week: {{ $week }}
        </h4>
        <a href="{{ route($role . '.timetable', ['offset' => $offset + 1]) }}" class="btn btn-outline-success">
          Next >
        </a>
  </div>
  @foreach($days as $day)
    <div class="col {{ Carbon::parse($day)->isSameDay(Carbon::now()) ? "aplus-bg-light-orange" : "" }} border p-2">
    <h5 class="text-center">{{ $day->translatedFormat('l') }}<br><small>{{ $day->format('d.m.Y') }}</small></h5>

    @foreach($groupedSessions[$day->format('Y-m-d')] ?? [] as $session)
    <div class="card my-2">
      <div class="card-body p-2">
      <strong>{{ $session->Subject->Name }}</strong><br>
      <small>{{ substr($session->StartHour, 0, -3) }} - {{ substr($session->EndHour, 0, -3) }}</small>
      </div>
    </div>
    @endforeach

    </div>
  @endforeach
</div>