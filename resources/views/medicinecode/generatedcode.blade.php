<div class="row">
  <div class="col-md-12">
    <div class="row"> 
      @forelse ($codes as $code)
     	 <div class="col-md-2"> <span class="text-primary">{{ $code->unique_code }}</span> </div>
      @empty
     	 <p>No codes found</p>
      @endforelse </div>
  </div>
</div>
