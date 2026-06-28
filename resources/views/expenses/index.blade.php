<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Expense Calculator</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .card { border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    </style>
</head>
<body>
<div class="container py-5">
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white p-4 d-flex flex-row justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1 text-uppercase opacity-75">Total Tracked Outflow</h5>
                    <h2 class="display-5 fw-bold mb-0">PKR {{ number_format($totalExpenses, 2) }}</h2>
                </div>
                <div class="fs-1 opacity-50">💸</div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card p-4">
                <h4 class="mb-4 fw-bold">Record New Expense</h4>
                <form action="{{ route('expenses.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Transaction Amount (PKR)</label>
                        <input type="number" name="amount" step="0.01" min="0.01" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}" required>
                        @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Expense Category</label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">Select a Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Calendar Date</label>
                        <input type="date" name="expense_date" class="form-control @error('expense_date') is-invalid @enderror" value="{{ old('expense_date', date('Y-m-d')) }}" required>
                        @error('expense_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Cloud Attachment Asset Link (Optional)</label>
                        <input type="url" name="attachment_url" class="form-control @error('attachment_url') is-invalid @enderror" placeholder="https://cdn.example.com/receipt.jpg" value="{{ old('attachment_url') }}">
                        @error('attachment_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Extended Notes / Description</label>
                        <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Commit Expense Entry</button>
                </form>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card p-4">
                <h4 class="mb-4 fw-bold">Transaction History Ledger</h4>
                
                @if($expenses->isEmpty())
                    <p class="text-muted py-4 text-center">No transactions recorded yet. Commit your first entry to see historical analytical listings here.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Category</th>
                                    <th>Notes</th>
                                    <th class="text-end">Amount</th>
                                    <th class="text-center">Receipt</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($expenses as $item)
                                    <tr>
                                        <td class="text-nowrap">{{ \Carbon\Carbon::parse($item->expense_date)->format('M d, Y') }}</td>
                                        <td><span class="badge bg-secondary px-2 py-1">{{ $item->category->name }}</span></td>
                                        <td><small class="text-muted">{{ $item->description ?? 'No context noted' }}</small></td>
                                        <td class="text-end fw-bold">PKR {{ number_format($item->amount, 2) }}</td>
                                        <td class="text-center">
                                            @if($item->attachment_url)
                                                <a href="{{ $item->attachment_url }}" target="_blank" class="btn btn-sm btn-outline-info px-2 py-0">View</a>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-2">
                                                <a href="{{ route('expenses.edit', $item->id) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                                                
                                                <form action="{{ route('expenses.destroy', $item->id) }}" method="POST" onsubmit="return confirmDestruction(event);">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDestruction(event) {
        if (!confirm("Are you sure you want to delete this log entry permanently? This action modifies the ledger balance data immediately.")) {
            event.preventDefault();
            return false;
        }
        return true;
    }
</script>
</body>
</html>