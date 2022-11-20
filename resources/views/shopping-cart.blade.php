<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Carrito') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidde">
                <livewire:cart>
            </div>
        </div>
    </div>
    @push('js')
        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/sweetalert2@9.5.3/dist/sweetalert2.all.min.js"></script>
        <script src="https://js.stripe.com/v3/"></script>
        <script>
            let form = document.getElementById('form');
            console.log(form);
            let paymentMethod = null;
            let stripe = Stripe("{{ env('STRIPE_KEY') }}");
            let elements = stripe.elements();
            let style = {
                base: {
                    color: '#aab7c4',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            }
            let card = elements.create('card', {style: style});
            card.mount('#card-element');

            form.addEventListener('submit', async function(e){
                e.preventDefault();

                var loading = Swal.fire({
                    title: "Cargando",
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    onOpen: () => {
                        Swal.showLoading();
                    }
                });

                $('button.pay').attr('disabled', true);

                if (paymentMethod) {
                    return true
                }
                stripe.confirmCardSetup(
                    "{{ $intent->client_secret }}",
                    {
                        payment_method: {
                            card: card,
                            billing_details: {name: $('.card_holder_name').val()}
                        }
                    }
                ).then(function (result) {
                    if (result.error) {
                        $('#card-errors').text(result.error.message);

                        $('button.pay').removeAttr('disabled');
                        loading.close();
                        Swal.fire({
                            type: 'warning',
                            title: "Error",
                            text: result.error.message,
                        });
                    } else {
                        paymentMethod = result.setupIntent.payment_method
                        $('.payment-method').val(paymentMethod)
                        createOrder(loading);
                    }
                })
                return false
            });

            async function createOrder(loading) {
                let fetchOptions = {
                    method: 'get',
                    credentials: "same-origin",
                    mode: "cors",
                    headers: {
                        "Content-Type": "application/json;charset=UTF-8",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                }

                fetchOptions.method = "post";
                fetchOptions.body = JSON.stringify({
                    payment_method: paymentMethod
                });

                let response = await fetch("{{ route('checkout') }}", fetchOptions);

                if (!(response && response.ok)) {
                    let errorSwal = Swal.fire({
                        type: 'error',
                        title: 'Error!',
                        text: "Algo salió mal. Inténtalo de nuevo",
                    });
                    loading.close();
                    console.log(response);
                    return;
                }

                const data = await response.json();

                Swal.fire({
                    type: 'success',
                    title: "Completado",
                    text: data,
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                }).then(function() {
                    window.location.href = "{{ route('dashboard')}}";
                });


            }
        </script>

    @endpush
</x-app-layout>

