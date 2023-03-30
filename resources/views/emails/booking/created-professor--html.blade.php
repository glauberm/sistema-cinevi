@extends('layout.email-html')

@section('content')

    @component('components.email.paragraph')
        A reserva <strong>#{{ $booking->id }}</strong> que vai de 
        <strong>{{ Carbon\CarbonImmutable::parse($booking->withdrawal_date)->format('d/m/Y') }}</strong> a 
        <strong>{{ Carbon\CarbonImmutable::parse($booking->devolution_date)->format('d/m/Y') }}</strong> e tem você 
        como professor responsável acaba de ser registrada por <strong>{{ $booking->owner->name }}</strong>.
    @endcomponent

    @component('components.email.table', [
        'headers' => ['Código', 'Nome']
    ])
        @foreach ($booking->bookables as $bookable)
            <tr>
                <td>{{ $bookable->identifier }}</td>
                <td>{{ $bookable->name }}</td>
            </tr>
        @endforeach
    @endcomponent

    @component('components.email.paragraph')
        Para visualizá-la, acesse o link abaixo.
    @endcomponent

@endsection