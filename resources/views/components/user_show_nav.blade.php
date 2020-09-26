<ul
    class="mx-auto nav nav-tabs nav-justified"
    style="width: 480px;"
    id="myTab"
    role="tablist"
>
    <li
        class="nav-item"
        role="presentation"
    >
        <a
            class="nav-link active"
            id="home-tab"
            data-toggle="tab"
            href="#home"
            role="tab"
            aria-controls="home"
            aria-selected="true"
        >
            投稿した問題
        </a>
    </li>
    <li
        class="nav-item"
        role="presentation"
    >
        <a
            class="nav-link"
            id="answer-tab"
            data-toggle="tab"
            href="#answer"
            role="tab"
            aria-controls="answer"
            aria-selected="false"
        >
            投稿した回答
        </a>
    </li>
    <li
        class="nav-item"
        role="presentation"
    >
        <a
            class="nav-link"
            id="performance-tab"
            data-toggle="tab"
            href="#performance"
            role="tab"
            aria-controls="performance"
            aria-selected="false"
        >
            実績
        </a>
    </li>
</ul>
<div
    class="tab-content"
    id="myTabContent"
>
    <div
        class="tab-pane fade show active"
        id="home"
        role="tabpanel"
        aria-labelledby="home-tab"
    >
        @foreach($user_quizzes as $quiz)
            @component('components.quiz_list',
                ['quiz' => $quiz])
            @endcomponent
        @endforeach
        {{ $user_quizzes->links() }}
    </div>
    <div
        class="tab-pane fade"
        id="answer"
        role="tabpanel"
        aria-labelledby="answer-tab"
    >
        @foreach($user_answers as $answer)
            @component('components.answer_template',
                ['answer' => $answer])
            @endcomponent
        @endforeach
        {{ $user_answers->links() }}
    </div>
    <div
        class="tab-pane fade"
        id="performance"
        role="tabpanel"
        aria-labelledby="performance-tab"
    >
        @component('performance.index', 
            ['user' => $user])
        @endcomponent
    </div>
</div>