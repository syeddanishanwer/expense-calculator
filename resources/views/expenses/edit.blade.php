<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Expense</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .card { border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card p-4">
                <h4 class="mb-4 fw-bold">Edit Expense</h4>
                <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Transaction Amount (PKR)</label>
                        <input type="number" name="amount" step="0.01" min="0.01"
                            class="form-control @error('amount') is-invalid @enderror"
                            value="{{ old('amount', $expense->amount) }}" required>
                        @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Expense Category</label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">Select a Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $expense->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Calendar Date</label>
                        <input type="date" name="expense_date"
                            class="form-control @error('expense_date') is-invalid @enderror"
                            value="{{ old('expense_date', $expense->expense_date) }}" required>
                        @error('expense_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Cloud Attachment Asset Link (Optional)</label>
                        <input type="url" name="attachment_url"
                            class="form-control @error('attachment_url') is-invalid @enderror"
                            placeholder="https://cdn.example.com/receipt.jpg"
                            value="{{ old('attachment_url', $expense->attachment_url) }}">
                        @error('attachment_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Extended Notes / Description</label>
                        <textarea name="description" rows="3"
                            class="form-control @error('description') is-invalid @enderror">{{ old('description', $expense->description) }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Update Expense</button>
                        <a href="{{ route('expenses.index') }}" class="btn btn-outline-secondary w-100 py-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>