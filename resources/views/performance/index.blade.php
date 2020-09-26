<div>
    <div 
        class="mx-auto mb-1 card text-center"
        style="width: 480px;"
    >
        <div class="card-header">投稿数</div>
        @component('performance.kind.number_of_quizzes', 
            ['user_count' => $user->performance->number_of_quizzes])
        @endcomponent
    </div>

    <div 
        class="mx-auto mb-1 card text-center"
        style="width: 480px;"
    >
        <div class="card-header">回答数</div>
        @component('performance.kind.number_of_answers', 
            ['user_count' => $user->performance->number_of_answers])
        @endcomponent
    </div>

    <div 
        class="mx-auto mb-1 card text-center"
        style="width: 480px;"
    >
        <div class="card-header">ベストアンサー数</div>
        @component('performance.kind.number_of_correct_answers', 
            ['user_count' => $user->performance->number_of_correct_answers])
        @endcomponent
    </div>

</div>