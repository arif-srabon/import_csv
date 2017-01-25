@if($diff)

    <p class=" alert alert-warning" >
        Header Name of column Shoud be
        [&nbsp;<?php echo substr(implode(", ", $headerForImportData), 0);?>&nbsp;]
        For Import {{$type}} File
    </p>
@endif


