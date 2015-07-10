<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <base href="<?php echo "http://" . $_SERVER["SERVER_NAME"] ?>">
        <script type="text/javascript" src="//code.jquery.com/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="resources/assets/genealogy/drag.js"></script>
        <script type="text/javascript" src="resources/assets/genealogy/genealogy.js"></script>
        <script type="text/javascript" src="resources/assets/chosen_v1.4.2/chosen.jquery.min.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>
        <script type="text/javascript" src="resources/assets/remodal/src/jquery.remodal.js"></script>
        <link rel="stylesheet" type="text/css" href="resources/assets/genealogy/genealogy.css" />
        <link rel="stylesheet" type="text/css" href="resources/assets/remodal/src/jquery.remodal.css" />
        <link rel="stylesheet" type="text/css" href="resources/assets/remodal/src/remodal-default-theme.css" />
        <link rel="stylesheet" type="text/css" href="resources/assets/chosen_v1.4.2/chosen.min.css" />
        <title>Genealogy</title>
    </head>
    <body id="body" class="body" style="height: 100%">
        <div class="overscroll" style="width: 100%; height: inherit; overflow: auto;">
            <div class="tree-container" style="width: 5000%; padding: 20px; height: 5000%;">
                <div class="tree">
                    <ul>
                        <li class="width-reference">
                            <span class="parent parent-reference {{ $slot->slot_type }}" placement="0" sponsor="0" position="left" slot_id="{{ $slot->slot_id }}">   
                                <div class="id">{{ $slot->slot_id }}</div>
                                <div class="name">{{ $slot->account_name }}</div>
                                <div class="membership">{{ $slot->membership_name }} ({{ $slot->slot_type }})</div>
                                <div class="wallet">{{ number_format($slot->slot_wallet, 2) }}</div>
                                <div class="view-downlines">&#8659;</div>
                            </span>
                            <div class="child-container"></div>
                        </li>
                    </ul>       
                </div>
            </div>
        </div>

        <!-- REMODAL NEW SLOT -->
        <div class="remodal slot-form new-slot-form" data-remodal-id="newslot"></div>
        <!-- REMODAL UPDATE SLOT SLOT -->
        <div class="remodal slot-form update-slot-form" data-remodal-id="update-slot"></div>
        <!-- LOADING -->
        <div class="remodal slot-form pop-loading" data-remodal-id="loading"></div>
    </body>
</html>
<style type="text/css">
body
{
    font-family: "Roboto", sans-serif !important;
}
select,
input[type="text"],
button
{
    font-family: "Roboto", sans-serif !important;
}
</style>
