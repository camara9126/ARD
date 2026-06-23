<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARD GestioPro - Bienvenue</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="bg-white dark-bg d-flex justify-content-center align-items-center vh-100 px-5">
            <div class="border shadow-sm p-4">
                <h1 class="display-6 font-weight-bold pb-3 text-center">Bonjour {{strtoupper(Auth::user()->name)}},</h1>
                <p class="text-center fw-bold">Votre demande de connexion est prise en charge. Nous allons examiner votre demande et reviendrons vers vous rapidement.</p>
                <ul class="px-4 text-center">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <a href="route('logout')" class="btn btn-success text-center" onclick="event.preventDefault(); this.closest('form').submit();">
                               Retour page de connexion
                            </a>
                        </form>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>