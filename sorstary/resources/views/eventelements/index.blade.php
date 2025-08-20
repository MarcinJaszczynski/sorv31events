<table>
@foreach($data as $element)
<tr>
    <td>{{$element->id}}</td>
    <td>{{$element->element_name}}</td>
    <td>{{$element->eventElementDescription}}</td>
</tr>
@endforeach
</table>