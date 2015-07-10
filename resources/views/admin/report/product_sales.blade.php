@extends('admin.layout')
@section('content')
	Under Development (Product Sales) test
	<a data-remodal-target="modal" href="#">Call the modal with data-remodal-id="modal"</a>

	<div class="remodal" data-remodal-id="modal"
  data-remodal-options="hashTracking: false, closeOnOutsideClick: false">

  <button data-remodal-action="close" class="remodal-close"></button>
  <h1>Remodal</h1>
  <p>
    Responsive, lightweight, fast, synchronized with CSS animations, fully customizable modal window plugin with declarative configuration and hash tracking.
  </p>
  <br>
  <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
  <button data-remodal-action="confirm" class="remodal-confirm">OK</button>
</div>
@endsection