@extends('base')
@section('content')
  <div class="main-container grid gap-y-[24px] gap-x-[24px] md:grid-cols-6">
    @foreach($listings as $listing)
      <a target="_blank" href="@isset($listing->link){{ $listing->link }}@endisset">
        <div class="text-left bg-[#ffffff] rounded-[12px] overflow-hidden flex flex-col">
          <h2 class="text-center mx-auto rounded-t-[12px] p-[10px] text-[20px] font-bold">@isset($listing->name){{ $listing->name }}@endisset</h2>
          <img alt="{{ $listing->name }}" loading="lazy" class="object-cover mx-auto" src="@isset($listing->image){{ $listing->image ? asset('storage/' . $listing->image) : asset('storage/default-avatar.png') }}@endisset">
          <div class="bg-[#ededed] px-[10px] py-[5px]">
            @isset($listing->atts->gender)
              <p><strong>Gender: </strong>{{ $listing->atts->gender }}</p>
            @endisset
            @isset($listing->atts->age)
              <p><strong>Age: </strong>{{ $listing->atts->age }}</p>
            @endisset
            @isset($listing->atts->hair_color)
              <p><strong>Hair Color: </strong>{{ $listing->atts->hair_color }}</p>
            @endisset
            @isset($listing->atts->piercings)
              <p><strong>Piercings: </strong>
                @if($listing->atts->piercings == "1")    
                  Yes     
                @else
                  No
                @endif
              </p>
            @endisset
            @isset($listing->atts->tattoos)
              <p><strong>Tattoos: </strong>
                @if($listing->atts->tattoos == "1")    
                  Yes     
                @else
                  No
                @endif
              </p>
            @endisset
            @isset($listing->atts->ethnicity)
              <p><strong>Ethnicity: </strong>{{ $listing->atts->ethnicity }}</p>
            @endisset
            @isset($listing->atts->orientation)
              <p><strong>Orientation: </strong>{{ $listing->atts->orientation }}</p>
            @endisset
          </div>
        </div>
      </a>
    @endforeach
  </div>
  <div class="max-w-[1320px] w-full mx-auto my-[40px]">{{ $listings->links() }}</div>
@endsection