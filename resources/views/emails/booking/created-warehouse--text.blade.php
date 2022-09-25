@extends('layouts.email-text')

@section('body')

A reserva #{{ $booking->id }} que vai de 
{{ Carbon\CarbonImmutable::parse($booking->withdrawal_date)->format('d/m/Y') }} a 
{{ Carbon\CarbonImmutable::parse($booking->devolution_date)->format('d/m/Y') }} acaba de ser registrada por 
{{ $booking->owner->name }}.

@foreach ($booking->bookables as $bookable)
    [{{ $bookable->identifier }}] {{ $bookable->name }}
@endforeach

Para visualizá-la, acesse o link abaixo.

{{ $url }}

@endsection