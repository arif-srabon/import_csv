@if (session('dangerMsg'))
<div class="alert alert-danger alert-styled-left alert-bordered">
    <button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>
    <ul>
        <li> {{ session('dangerMsg') }}</li>
    </ul>
</div>
@endif

@if (session('primaryMsg'))
<div class="alert alert-primary alert-styled-left">
    <button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>
    <ul>
         <li> {{ session('primaryMsg') }}</li>
    </ul>
</div>
@endif


@if (session('successMsg'))
<div class="alert alert-success alert-styled-left alert-arrow-left alert-bordered">
    <button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>
    <ul>
        <li> {{ session('successMsg') }}</li>
    </ul>
</div>
@endif


@if (session('warningMsg'))
<div class="alert alert-warning alert-styled-left">
    <button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>
    <ul>
        <li> {{ session('warningMsg') }}</li>
    </ul>
</div>
@endif

@if (session('infoMsg'))
<div class="alert alert-info alert-styled-left alert-bordered">
    <button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>
    <ul>
       <li> {{ session('infoMsg') }}</li>
    </ul>
</div>
@endif


@if (session('customMsg'))
<div class="alert alert-styled-left alert-styled-custom alert-arrow-left alpha-teal alert-bordered">
    <button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>
    <ul>
       <li> {{ session('customMsg') }}</li>
    </ul>
</div>
@endif