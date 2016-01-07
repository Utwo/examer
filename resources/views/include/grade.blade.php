@for($i = 0; $i < config('settings.max_grade_add'); $i++)
    <td class="text-center">
        @if($project->Grade->count() > $i)
            {{ $project->Grade[$i]->grade }}
        @endif
    </td>
@endfor
<td class="text-center">
    {{$project->media}}
</td>