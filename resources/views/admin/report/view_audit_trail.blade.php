<table>
	<tr>

		<td>
			@foreach($_old as $key => $old)
				@foreach($old as $k => $o)
				  @if($o != $_new[$key]->$k)
				  	<span style="color:red">{{$o}}</span>
				  @else
				  	<span>{{$o}}</span>
				  @endif
				@endforeach
			</br>
			@endforeach
		</td>

		<td>
			@foreach($_new as $key => $new)
				@foreach($new as $n)
				{{$n}}
				@endforeach
			</br>
			@endforeach
		</td>

	</tr>
</table>