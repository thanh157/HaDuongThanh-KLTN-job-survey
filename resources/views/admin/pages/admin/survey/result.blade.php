@extends('admin.layouts.master')

@section('title', 'Kết quả khảo sát')

@section('content')
    <h3 class="mb-4">📊 Kết quả khảo sát: {{ $survey->title }}</h3>

    @foreach ($responses as $res)
        <div class="border rounded shadow-sm p-4 mb-5 bg-light">
            <h5 class="mb-2 text-primary">👤 {{ $res->ho_ten }} (MSSV: {{ $res->ma_sv }})</h5>
            <div class="text-muted small mb-3">
                Email: {{ $res->email }} | SĐT: {{ $res->phone }} <br>
                🕒 Gửi lúc: {{ $res->submitted_at?->format('H:i d/m/Y') ?? $res->created_at->format('H:i d/m/Y') }}
            </div>

            @foreach ($questions as $question)
                @php
                    $answers = $res->answers->where('question_id', $question->id)->pluck('answer_text')->toArray();
                @endphp

                <div class="mb-4">
                    <label class="fw-semibold d-block mb-2">
                        {{ $loop->iteration }}. {{ $question->question_text }}
                    </label>

                    @foreach ($question->options as $optIndex => $option)
                        <div class="form-check mb-1">
                            <input class="form-check-input"
                                   type="{{ $question->type === 'multiple' ? 'checkbox' : 'radio' }}"
                                   disabled
                                {{ in_array($option['text'], $answers) ? 'checked' : '' }}>
                            <label class="form-check-label">
                                {{ $option['text'] }}
                            </label>
                        </div>

                        @if($option['is_other'] && in_array($option['text'], $answers))
                            @php
                                $otherVals = $res->answers
                                    ->where('question_id', $question->id)
                                    ->filter(fn($a) => $a->answer_text !== $option['text'])
                                    ->pluck('answer_text');
                            @endphp
                            @foreach($otherVals as $otherText)
                                <input type="text"
                                       class="form-control mt-2 mb-2"
                                       value="{{ $otherText }}"
                                       readonly>
                            @endforeach
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>
    @endforeach

@endsection
