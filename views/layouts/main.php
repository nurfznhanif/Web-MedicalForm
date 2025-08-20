<?php
// HAPUS SEMUA ISI FILE LAMA
// GANTI DENGAN KODE INI:

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\bootstrap5\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);

$isGuest = Yii::$app->user->isGuest;
$user = Yii::$app->user->identity;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title) ?> - Medical Form System</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <?php $this->head() ?>

    <style>
        :root {
            --primary-blue: #1e3a8a;
            --secondary-blue: #3b82f6;
            --accent-yellow: #f59e0b;
            --light-blue: #dbeafe;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --bg-light: #f8fafc;
            --white: #ffffff;
            --border-light: #e5e7eb;
            --success: #10b981;
            --danger: #ef4444;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --border-radius: 12px;
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--bg-light) 0%, #ffffff 100%);
            color: var(--text-dark);
        }

        .navbar-modern {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-light);
            box-shadow: var(--shadow-sm);
            padding: 1rem 0;
        }

        .navbar-brand-modern {
            font-weight: 700 !important;
            color: var(--primary-blue) !important;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--secondary-blue), var(--primary-blue));
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .nav-link-modern {
            color: var(--text-dark) !important;
            font-weight: 500;
            padding: 0.75rem 1rem !important;
            border-radius: 8px;
            transition: var(--transition);
            margin: 0 0.25rem;
        }

        .nav-link-modern:hover {
            color: var(--secondary-blue) !important;
            background: var(--light-blue) !important;
        }

        .card-modern {
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-light);
            transition: var(--transition);
        }

        .card-modern:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .btn-modern {
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius);
            font-weight: 600;
            border: none;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary-modern {
            background: linear-gradient(135deg, var(--secondary-blue), var(--primary-blue));
            color: white;
            box-shadow: var(--shadow-md);
        }

        .btn-primary-modern:hover {
            transform: translateY(-2px);
            color: white;
        }

        .btn-success-modern {
            background: linear-gradient(135deg, var(--success), #059669);
            color: white;
            box-shadow: var(--shadow-md);
        }

        .btn-danger-modern {
            background: linear-gradient(135deg, var(--danger), #dc2626);
            color: white;
            box-shadow: var(--shadow-md);
        }

        .alert.alert-success {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.1));
            color: var(--success);
            border: none;
            border-left: 4px solid var(--success);
            border-radius: var(--border-radius);
        }

        .alert.alert-danger {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.1));
            color: var(--danger);
            border: none;
            border-left: 4px solid var(--danger);
            border-radius: var(--border-radius);
        }

        .footer-modern {
            background: var(--white);
            border-top: 1px solid var(--border-light);
            padding: 2rem 0;
            margin-top: 4rem;
            color: var(--text-light);
        }

        @media (max-width: 768px) {
            .navbar-brand-modern {
                font-size: 1.25rem !important;
            }

            .brand-icon {
                width: 35px;
                height: 35px;
            }
        }
    </style>
</head>

<body>
    <?php $this->beginBody() ?>

    <?php if (!$isGuest): ?>
        <nav class="navbar navbar-expand-lg navbar-modern fixed-top">
            <div class="container">
                <a class="navbar-brand-modern" href="<?= Yii::$app->homeUrl ?>">
                    <div class="brand-icon">
                        <i class="fas fa-notes-medical"></i>
                    </div>
                    <span>Medical Form System</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto ms-3">
                        <li class="nav-item">
                            <a class="nav-link-modern" href="<?= Yii::$app->homeUrl ?>">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-modern" href="<?= \yii\helpers\Url::to(['/registrasi/index']) ?>">
                                <i class="fas fa-users"></i> Data Registrasi
                            </a>
                        </li>
                    </ul>

                    <div class="navbar-nav">
                        <div class="nav-item dropdown">
                            <a class="nav-link-modern dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i>
                                <span><?= $user ? Html::encode($user->full_name) : 'Dr. Admin' ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <h6 class="dropdown-header"><?= $user ? Html::encode($user->full_name) : 'Dr. Admin' ?></h6>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <?= Html::beginForm(['/site/logout'], 'post') ?>
                                    <?= Html::submitButton('<i class="fas fa-sign-out-alt"></i> Logout', ['class' => 'dropdown-item text-danger']) ?>
                                    <?= Html::endForm() ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container" style="margin-top: 90px;">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
        </div>
    <?php endif; ?>

    <div class="<?= $isGuest ? '' : 'container' ?>" style="padding: 2rem 0;">
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>

    <?php if (!$isGuest): ?>
        <footer class="footer-modern">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-0">&copy; <?= date('Y') ?> Medical Form System.</p>
                    </div>
                </div>
            </div>
        </footer>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>