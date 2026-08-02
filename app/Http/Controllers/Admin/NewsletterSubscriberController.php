<?php

namespace App\Http\Controllers\Admin;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsletterSubscriberController extends Controller
{
    /**
     * Afficher la liste des abonnés
     */
    public function index(Request $request)
    {
        $query = NewsletterSubscriber::query();

        // Recherche
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('email', 'like', "%$search%");
        }

        // Tri
        $sort = $request->input('sort', 'created_at');
        $order = strtolower($request->input('order', 'desc'));

        if (! in_array($sort, ['email', 'created_at', 'updated_at'], true)) {
            $sort = 'created_at';
        }

        if (! in_array($order, ['asc', 'desc'], true)) {
            $order = 'desc';
        }

        $query->orderBy($sort, $order);

        // Pagination
        $subscribers = $query->paginate(50)->appends($request->query());
        $count = NewsletterSubscriber::count();
        $countThisMonth = NewsletterSubscriber::where('created_at', '>=', now()->startOfMonth())->count();

        return view('admin.newsletter-subscribers.index', compact(
            'subscribers',
            'count',
            'countThisMonth'
        ));
    }

    /**
     * Supprimer un abonné
     */
    public function destroy(NewsletterSubscriber $subscriber)
    {
        $email = $subscriber->email;
        $subscriber->delete();

        return redirect()->route('admin.newsletter-subscribers.index')
            ->with('success', "L'abonné $email a été supprimé.");
    }

    /**
     * Supprimer plusieurs abonnés
     */
    public function destroyMultiple(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->route('admin.newsletter-subscribers.index')
                ->with('error', 'Veuillez sélectionner au moins un abonné.');
        }

        $count = NewsletterSubscriber::whereIn('id', $ids)->delete();

        return redirect()->route('admin.newsletter-subscribers.index')
            ->with('success', "$count abonné(s) supprimé(s).");
    }

    /**
     * Exporter les abonnés en CSV
     */
    public function export()
    {
        $subscribers = NewsletterSubscriber::all();

        $csv = "Email,Date d'inscription\n";
        foreach ($subscribers as $subscriber) {
            $csv .= $subscriber->email . "," . $subscriber->created_at->format('d/m/Y H:i') . "\n";
        }

        return response()->streamDownload(function () use ($csv) {
            echo $csv;
        }, 'abonnes-newsletter-' . now()->format('Y-m-d-His') . '.csv', [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="abonnes.csv"',
        ]);
    }
}
