@if($user_count >= 300)
    @component('components.progress', 
        [
            'val' => $user_count,
            'count' => 300,
            'bg_color' => '#b9f2ff',
        ])
    @endcomponent
@elseif($user_count >= 200)
    @component('components.progress', 
        [
            'val' => $user_count,
            'count' => $user_count - 200,
            'bg_color' => '#FFD700',
        ])
    @endcomponent
@elseif($user_count >= 100)
    @component('components.progress', 
        [
            'val' => $user_count,
            'count' => $user_count - 100,
            'bg_color' => '#c0c0c0',
        ])
    @endcomponent
@elseif($user_count >= 50)
    @component('components.progress', 
        [
            'val' => $user_count,
            'count' => ($user_count - 50) * 2,
            'bg_color' => '#815a2b',
        ])
@endcomponent
@else
    @component('components.progress', 
        [
            'val' => $user_count,
            'count' => $user_count * 2,
            'bg_color' => 'red',
        ])
    @endcomponent
@endif