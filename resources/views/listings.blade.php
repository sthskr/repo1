@extends('base')
@section('content')
  <div class="main-container grid gap-y-[24px] gap-x-[24px] md:grid-cols-6">
    @foreach($listings as $listing)
      <a target="_blank" href="{{ $listing->link }}">
        <div class="text-left bg-[#ffffff] rounded-[12px] overflow-hidden flex flex-col">
          <h2 class="text-center mx-auto rounded-t-[12px] p-[10px] text-[20px] font-bold">{{ $listing->name }}</h2>
          <img alt="{{ $listing->name }}" loading="lazy" class="object-cover mx-auto" src="{{ $listing->image ? asset('storage/' . $listing->image) : $listing->thumbnails->pc }}">
          <div class="bg-[#ededed] px-[10px] py-[5px]">
            <p><strong>Gender: </strong>{{ $listing->atts->gender }}</p>
            <p><strong>Age: </strong>{{ $listing->atts->age }}</p>
            <p><strong>Hair Color: </strong>{{ $listing->atts->hair_color }}</p>
            <p><strong>Piercings: </strong>
              @if($listing->atts->piercings == "1")    
                Yes     
              @else
                No
              @endif
            </p>
            <p><strong>Tattoos: </strong>
              @if($listing->atts->tattoos == "1")    
                Yes     
              @else
                No
              @endif
            </p>
            <p><strong>Ethnicity: </strong>{{ $listing->atts->ethnicity }}</p>
            <p><strong>Orientation: </strong>{{ $listing->atts->orientation }}</p>
          </div>
        </div>
      </a>
    @endforeach
  </div>
  <div class="max-w-[1320px] w-full mx-auto my-[40px]">{{ $listings->links() }}</div>
@endsection