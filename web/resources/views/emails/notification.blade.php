@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{$user->name." ".$user->lastname." congratulates you ".$contact->name}}
        @endcomponent
    @endslot
<h2><strong>{{$contact->name}},</strong></h2>

<p>{{ $contact->message }}</p>

<br>
<hr>
Saludos,<br>
{{$user->name}}

{{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            Never Forget A Birthday, All rights reserved.
        @endcomponent
    @endslot
@endcomponent
