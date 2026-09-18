<!doctype html>
<html><body>
<h1>Form</h1>
<table><thead><tr><th>Name</th><th>Email</th><th>Email Verified At</th></tr></thead><tbody>@forelse($items as $item)<tr><td>{{ $item->name }}</td><td>{{ $item->email }}</td><td>{{ $item->email_verified_at }}</td></tr>@empty<tr><td colspan="3">Tiada data.</td></tr>@endforelse</tbody></table>
{{ $items->links() }}
</body></html>
