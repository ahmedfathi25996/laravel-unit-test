<?php


    if($accepturl == ""){
        $accepturl = url("/admin/new_accept_item");
    }

?>
<div class="parent_accepters_div">
<?php foreach($accepters_data as $accepter_key=>$accepter_val): ?>
    <a href='#'
       class='new_general_accept_item'
       data-acceptersdata="{{json_encode($accepters_data)}}"
       data-accept="{{$accepter_key}}"
       data-accepturl="{{$accepturl}}"
       data-tablename="{{$model}}"
       data-fieldname="{{$accept_or_refuse_col}}"
       data-item_primary_col="{{$item_primary_col}}"
       data-itemid="<?= $item_obj->{$item_primary_col} ?>"
       data-display_block="{{$display_block}}">

     <?php if($item_obj->{$accept_or_refuse_col} == $accepter_key):?>
         <label class='btn btn-primary mg-b-6' {{ ($display_block)?"style='display: block;'":"" }} >{!! $accepter_val !!}</label>
     <?php else: ?>
         <label class='btn btn-outline-primary mg-b-6' {{ ($display_block)?"style='display: block;'":"" }} >{!! $accepter_val !!}</label>
     <?php endif;?>
    </a>
<?php endforeach; ?>

</div>

