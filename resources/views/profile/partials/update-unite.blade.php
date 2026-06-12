 <?php

    use App\Models\Unite;


    $unite = Unite::Where('id', request()->user()->unite_id)->first();
?>
 <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Information unite') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __("Mettez à jour les informations de votre unite, vos coordonnées et votre adresse.") }}
            </p>
        </header>

        <form method="post" action="{{ route('unite.update', $unite) }}" enctype="multipart/form-data" class="mt-6 space-y-6">
            @csrf
            @method('patch')

            <div>
                <x-input-label for="nom" :value="__('Nom')" />
                <x-text-input id="nom" name="nom" readOnly type="text" class="mt-1 block w-full" :value="old('nom', $unite->nom)" required autofocus autocomplete="nom" />
                <x-input-error class="mt-2" :messages="$errors->get('nom')" />
            </div>

            <div>
                <x-input-label for="telephone" :value="__('Contact')" />
                <x-text-input id="contact" name="contact" type="text" class="mt-1 block w-full" :value="old('contact', $unite->contact)" required autocomplete="contact" />
                <x-input-error class="mt-2" :messages="$errors->get('contact')" />
            </div>

            <div>
                <x-input-label for="adresse" :value="__('Adresse')" />
                <x-text-input id="" name="adresse" type="text" class="mt-1 block w-full" :value="old('adresse', $unite->adresse)" autofocus autocomplete="adresse" />
                <x-input-error class="mt-2" :messages="$errors->get('adresse')" />
            </div>

            <div>
                <x-input-label for="ninea" :value="__('Ninea')" />
                <x-text-input id="" name="ninea" type="text" class="mt-1 block w-full" :value="old('ninea', $unite->ninea)" autofocus autocomplete="ninea" />
                <x-input-error class="mt-2" :messages="$errors->get('ninea')" />
            </div>

            <div>
                <x-input-label for="adresse" :value="__('TVA')" />
                <x-text-input id="" name="taux_tva" type="text" class="mt-1 block w-full" :value="old('taux_tva', $unite->taux_tva)" autofocus autocomplete="tva" />
                <x-input-error class="mt-2" :messages="$errors->get('taux_tva')" />
            </div>              
            
            <div>
                <x-input-label for="logo" :value="__('Logo')" />
                <img src="{{asset('storage/'.$unite->logo)}}" name="logo" class="mt-1 block w-full" style="width: 150px; height: 60px;" alt="Aucun Logo" autofocus autocomplete="logo">

                <x-text-input id="" name="logo" type="file" class="mt-1 block w-full" :value="old('logo', $unite->logo)" autofocus autocomplete="logo" />
                <x-input-error class="mt-2" :messages="$errors->get('logo')" />
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Enregister') }}</x-primary-button>

                @if (session('status') === 'unite-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600"
                    >{{ __('enregistrée.') }}</p>
                @endif
            </div>
        </form>
    </section>