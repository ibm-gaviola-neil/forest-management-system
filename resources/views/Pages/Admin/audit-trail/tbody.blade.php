<tbody>
    @forelse ($activities as $activity)
        <tr>
            <td style="text-transform: capitalize">{{ $activity->action }}</td>
            <td style="text-transform: capitalize">{{ $activity->type }}</td>
            <td>{{ $activity->last_name.' '.$activity->first_name }}</td>
            @if ($request->tab === 'blood_issuance')
            <td>{{ $activity->blood_bag_id }}</td>
            @else  
            <td>{{ $activity->message }}</td>
            @endif
            <td>{{ $activity->created_at }}</td>
        </tr>
    @empty
        
    @endforelse
</tbody>