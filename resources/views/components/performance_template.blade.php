@if($user_count >= 200)
    @component('components.progress', 
        [
            'count' => 100,
            'rank'  => $user_count,
            'bg_color' => '#FFD700',
        ])
    @endcomponent
@elseif($user_count >= 100)
    @component('components.progress', 
        [
            'count' => $user_count - 100,
            'rank'  => $user_count,
            'bg_color' => '#c0c0c0',
        ])
    @endcomponent
@else
    @component('components.progress', 
        [
            'count' => $user_count,
            'rank'  => $user_count,
            'bg_color' => '#815a2b',
        ])
    @endcomponent
@endif