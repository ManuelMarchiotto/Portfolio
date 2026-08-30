<x-layout title="Accedi">
    <div class="mt-5 row">
        <div class="col-lg-4 mx-auto">
            <h1>Accedi</h1>

            <div class="mt-5">
                <form action="/login" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" />
                            @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>   
                        <div class="col-12">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" />
                            @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>   
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Accedi</button>
                        </div>              
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>