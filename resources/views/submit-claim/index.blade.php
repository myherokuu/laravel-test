<!doctype html>
<html><body>
<h1>Submit claim</h1>
<form method="POST" action="{{ route('submit-claim.store') }}">@csrf<input name="name" required><button type="submit">Create</button></form>
<table><tbody>@foreach($items as $item)<tr><td>{{ $item->name }}</td><td><form method="POST" action="{{ route('submit-claim.update', $item) }}">@csrf @method('PUT')<input name="name" value="{{ $item->name }}"><button>Update</button></form><form method="POST" action="{{ route('submit-claim.destroy', $item) }}">@csrf @method('DELETE')<button>Delete</button></form></td></tr>@endforeach</tbody></table>
</body></html>
