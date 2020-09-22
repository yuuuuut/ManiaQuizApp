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
            id="profile-tab"
            data-toggle="tab"
            href="#profile"
            role="tab"
            aria-controls="profile"
            aria-selected="false"
        >
            回答した問題
        </a>
    </li>
    <li
        class="nav-item"
        role="presentation"
    >
        <a
            class="nav-link"
            id="contact-tab"
            data-toggle="tab"
            href="#contact"
            role="tab"
            aria-controls="contact"
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
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

    </div>
    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
</div>