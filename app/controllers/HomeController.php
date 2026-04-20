<?php

declare(strict_types=1);

class HomeController extends Controller
{
    public function index(): void
    {
        if (Auth::role() === 'admin') {
            redirect('admin/dashboard');
        }

        if (Auth::role() === 'responsable') {
            redirect('responsable/voyages');
        }

        redirect('voyages');
    }
}
