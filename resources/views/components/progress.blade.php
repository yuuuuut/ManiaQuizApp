<div class="progress m-3">
    <div
        class="progress-bar progress-bar-striped progress-bar-animated"
        role="progressbar"
        style="width: {{ $count }}%; background-color: {{ $bg_color }};"
        aria-valuenow="{{ $count }}"
        aria-valuemin="0"
        aria-valuemax="100"
    >
        <div class="text-primary">
            {{ $val }}
        </div>
    </div>
</div>