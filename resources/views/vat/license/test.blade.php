<html>
    <body>
<form action="{{route('get-license-types')}}" method="POST">
    @csrf
    <input type="text" name="search">
    <input type="text" name="assessmentAmmount">
    
    <input type="submit">
</form>
</body>
</html>