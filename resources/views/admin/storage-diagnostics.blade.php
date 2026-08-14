@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Diagnostic du Stockage</h1>
        @if ($all_ok)
            <span class="badge bg-success">✓ Tout fonctionne</span>
        @else
            <span class="badge bg-danger">✗ Problèmes détectés</span>
        @endif
    </div>

    @if (!$all_ok)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">Problèmes de stockage détectés</h4>
            <p>Des problèmes ont été détectés dans la configuration du stockage. Veuillez vérifier les informations ci-dessous.</p>
            <hr>
            <p class="mb-0"><strong>Actions recommandées:</strong></p>
            <ul class="mb-0 mt-2">
                <li>Exécutez: <code>php artisan storage:link</code></li>
                <li>Exécutez: <code>php artisan storage:verify</code></li>
                <li>Vérifiez les permissions des dossiers</li>
                <li>Contactez votre hébergeur si les problèmes persistent</li>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Chemins configurés -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Chemins configurés</h5>
        </div>
        <div class="card-body">
            <table class="table table-sm mb-0">
                <tr>
                    <td><strong>Disque media actif:</strong></td>
                    <td><code>{{ $media_disk }}</code> <small class="text-muted">({{ $media_disk_driver }})</small></td>
                </tr>
                <tr>
                    <td><strong>Dossier de stockage:</strong></td>
                    <td><code>{{ $storage_path }}</code></td>
                </tr>
                <tr>
                    <td><strong>Dossier public:</strong></td>
                    <td><code>{{ $public_path }}</code></td>
                </tr>
                <tr>
                    <td><strong>Symlink attendu:</strong></td>
                    <td><code>{{ $symlink_path }}</code></td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Vérifications du disque -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Vérifications du disque</h5>
        </div>
        <div class="card-body">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Vérification</th>
                        <th>État</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Symlink existe</strong></td>
                        <td>
                            @if ($disk_checks['symlink_exists'])
                                <span class="badge bg-success">✓ Oui</span>
                            @else
                                <span class="badge bg-danger">✗ Non</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Symlink valide</strong></td>
                        <td>
                            @if ($disk_checks['symlink_valid'])
                                <span class="badge bg-success">✓ Oui</span>
                            @else
                                <span class="badge bg-danger">✗ Non</span>
                            @endif
                            @if ($disk_checks['symlink_target'])
                                <br><small class="text-muted">Points vers: {{ $disk_checks['symlink_target'] }}</small>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Storage Disk fonctionne</strong></td>
                        <td>
                            @if ($disk_checks['storage_disk_works'])
                                <span class="badge bg-success">✓ Oui</span>
                            @else
                                <span class="badge bg-danger">✗ Non</span>
                                @if ($disk_checks['storage_disk_error'] ?? null)
                                    <br><small class="text-muted">Erreur: {{ $disk_checks['storage_disk_error'] }}</small>
                                @endif
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Vérifications des répertoires -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Répertoires</h5>
        </div>
        <div class="card-body">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Répertoire</th>
                        <th>Existe</th>
                        <th>Lisible</th>
                        <th>Inscriptible</th>
                        <th>Chemin</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($directory_checks as $name => $check)
                        <tr>
                            <td><strong>{{ $name }}</strong></td>
                            <td>
                                @if ($check['exists'])
                                    <span class="badge bg-success">✓</span>
                                @else
                                    <span class="badge bg-danger">✗</span>
                                @endif
                            </td>
                            <td>
                                @if ($check['readable'])
                                    <span class="badge bg-success">✓</span>
                                @else
                                    <span class="badge bg-warning">-</span>
                                @endif
                            </td>
                            <td>
                                @if ($check['writable'])
                                    <span class="badge bg-success">✓</span>
                                @else
                                    <span class="badge bg-danger">✗</span>
                                @endif
                            </td>
                            <td><small><code>{{ $check['path'] }}</code></small></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Fichiers d'exemple -->
    @if ($sample_files)
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light">
                <h5 class="mb-0">Fichiers stockés</h5>
            </div>
            <div class="card-body">
                @if ($sample_files['posts'] ?? null)
                    <h6>Articles (Posts)</h6>
                    @if (count($sample_files['posts']) > 0)
                        <ul class="mb-3">
                            @foreach ($sample_files['posts'] as $file)
                                <li><code>{{ $file }}</code></li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Aucun fichier</p>
                    @endif
                @endif

                @if ($sample_files['portfolio'] ?? null)
                    <h6>Portfolio</h6>
                    @if (count($sample_files['portfolio']) > 0)
                        <ul class="mb-3">
                            @foreach ($sample_files['portfolio'] as $file)
                                <li><code>{{ $file }}</code></li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Aucun fichier</p>
                    @endif
                @endif

                @if ($sample_files['error'] ?? null)
                    <div class="alert alert-warning mb-0">
                        {{ $sample_files['error'] }}
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection
