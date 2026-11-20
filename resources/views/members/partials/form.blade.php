{{-- Общите полета за create и edit. $member е null при нов член. --}}
<div class="mb-3">
    <label for="name" class="form-label">Име</label>
    <input type="text" id="name" name="name" value="{{ old('name', $member?->name) }}"
           class="form-control @error('name') is-invalid @enderror">
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="email" class="form-label">Имейл</label>
    <input type="email" id="email" name="email" value="{{ old('email', $member?->email) }}"
           class="form-control @error('email') is-invalid @enderror">
    @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
