@component('mail::message')
<h1>Hello</h1>
<p>{!! $data['message'] !!}</p>
@component('mail::button', ['url' => $data['url']])
View
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
