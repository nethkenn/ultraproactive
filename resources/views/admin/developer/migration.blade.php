<form method="POST">
    <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
    <input type="submit" name="migrate" value="migrate"> 
</form>