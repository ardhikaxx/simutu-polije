<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $survei->judul }} - Survei</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f5f7fa; }
        .survey-container { max-width: 700px; margin: 40px auto; }
        .question-card { border-radius: 12px; border: none; box-shadow: 0 2px 12px rgba(0,0,0,0.08); }
        .rating-stars .form-check { display: inline-block; margin-right: 12px; }
        .rating-stars .form-check-input { width: 1.5em; height: 1.5em; }
    </style>
</head>
<body>
    <div class="survey-container">
        <div class="text-center mb-4">
            <h3 class="fw-bold">{{ $survei->judul }}</h3>
            <p class="text-muted">{{ $survei->jenisSurvei->nama ?? '' }} &middot; {{ $survei->tahunAkademik->nama ?? '' }}</p>
        </div>

        <form action="{{ route('survei.fill.submit', $survei) }}" method="POST">
            @csrf
            @forelse($survei->pertanyaanSurvei as $index => $pertanyaan)
            <div class="card question-card mb-3">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">{{ $index + 1 }}. {{ $pertanyaan->teks_pertanyaan }}</h6>
                    <input type="hidden" name="answers[{{ $index }}][pertanyaan_survei_id]" value="{{ $pertanyaan->id }}">

                    @if($pertanyaan->tipe_jawaban === 'Rating')
                    <div class="rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[{{ $index }}][jawaban_rating]" value="{{ $i }}" id="q{{ $index }}_r{{ $i }}" required>
                            <label class="form-check-label" for="q{{ $index }}_r{{ $i }}">{{ $i }}</label>
                        </div>
                        @endfor
                    </div>
                    @elseif($pertanyaan->tipe_jawaban === 'Teks')
                    <textarea class="form-control" name="answers[{{ $index }}][jawaban_teks]" rows="3" placeholder="Tulis jawaban Anda..."></textarea>
                    @else
                    <input type="text" class="form-control" name="answers[{{ $index }}][jawaban_teks]" placeholder="Tulis jawaban Anda...">
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center text-muted py-5">
                <p>Survei ini belum memiliki pertanyaan.</p>
            </div>
            @endforelse

            @if($survei->pertanyaanSurvei->count() > 0)
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary btn-lg px-5">Kirim Jawaban</button>
            </div>
            @endif
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
