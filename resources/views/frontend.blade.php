<!--
  I linked a CSS file to this file. 
  Because adding the CSS codes inline (on the same tags ) or in the head tag will make the file so crowded. 
  It is better to put them all in a different file and connect it with a Link tag.
  ----------------------- :
  There are some new classes which i added to some Tags. I needed to add those Classes so i can use them for adding the CSS styles. 
  I did not change any ID or Classes that were writteen before i only added new Classes and tried to make their name as clear as possible.
-->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- I added this Link Tag in order to connect the CSS file to the HTML file.
    Maybe the (href) needs to be changed ! because now the location of the CSS file is changed so the new location or Url should be added.-->
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">

    <title>@lang('messages.pagetitle')</title>

</head>

<body>

@if (session('alert'))
    <div class="alert alert-success">
        {!! session('alert') !!}
    </div>
@else
@foreach($registered as $reg)
    <div class="alert alert-success">
       @lang('messages.current_registration', ['name' => $reg['name'], 'service' => $reg['service'], 'count' => $reg['count']])
       <form action="{{ route('cancelregistration', [], false) }}" method="post">
        @csrf
        @method('DELETE')
          <input type="hidden" name="uuid" value="{{$uuid}}"/>
          <input type="hidden" name="participant_id" value="{{ $reg['participant_id'] }}"/>
          <input class="submit-btn btn-big" type="submit" value="@lang('messages.cancel_registration')">
       </form>
    </div>
@endforeach
@endif

    <form class="form" action="{{ route('frontend.store', [], false) }}" method="post">
        @csrf
        <input type="hidden" name="uuid" value="{{$uuid}}"/>
        <div class="field{{$hidechurchname}}">
           {{ $churchname }}
        </div>
        <fieldset class="field">
            <!-- Here i added this Label tag so i can apply the styles to the text also -->
            <label class="name-input" for="name" id="name">@lang('messages.my_name'):</label>
            <input class="name-input" type="text" id="name" name="name" required value="{{old('name')}}"><br/>
@if ($collect_contact_details)
            <label class="name-input" for="address">@lang('messages.my_address'):</label>
            <input class="name-input" type="text" id="address" name="address" required value="{{old('address')}}"><br/>
            <label class="name-input" for="phone">@lang('messages.my_phone'):</label>
            <input class="name-input" type="text" id="phone" name="phone" required value="{{old('phone')}}"><br/>

@endif
@if ($option_to_report_contact_details)
            <input class="name-input" type="checkbox" id="report_details" name="report_details" value="1" checked>
            <label class="name-input" for="report_details">@lang('messages.report_details')</label>
            <br/>

@endif
        </fieldset>
        <fieldset class="field" class="main-field">
            <p class="label{{$hideselectservice}}">@lang('messages.select_service'):
                </><br/>
@foreach ($services as $service)
                    <div class="row">
                        <div class="col">
                            <input class="selectservice" type="radio" id="service-{{ $service->id }}" name="service_id" value="{{$service->id}}" required {{$checkedservice}}>
                            <label class="servicename" for="service-{{ $service->id }}">{{$service->description}}</label>
                        </div>
                        <div class="countparticipants">
                            <label for="service-{{ $service->id }}">
@if ($service->max_visitors === 0)
                                @lang('messages.currently_visitors_no_max', ['value' => $service->count_adults + $service->count_children])
@else
                                @lang('messages.currently_visitors', ['value' => $service->count_adults + $service->count_children, 'max' => $service->max_visitors])
@endif
                            </label>
                        </div>
                    </div>
@endforeach
        </fieldset>

        <fieldset class="field">
            <input class="persons-num-input" type="number" id="quantityAdults" name="count_adults" min="1" max="9" value="{{old('count_adults', 1)}}" required>
            <label class="persons-num-label" for="quantityAdults">@lang('messages.number_of_visitors')</label>
            <input type="hidden" id="quantityChildren" name="count_children" value="0" />
        </fieldset>

        <input class="submit-btn" type="submit" value="@lang('messages.submit')">
    </form>

    <div class="upstream">
        <a href="https://www.wo2odermehr.de" target="_blank">wo2odermehr.de</a>
    </div>

</body>

</html>
