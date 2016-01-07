@for($i = 0; $i < config('settings.grade_for_project'); $i++)
    <td class="text-center">
        @if($project->Grade->count() > $i)
            {{ $project->Grade[$i]->grade }}
        @endif
    </td>
@endfor
<td class="text-center">
    {{$project->media}}
</td>