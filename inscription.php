<?php
/* =====================================================================
 * INSCRIPTION - CS Constantine
 * Le visiteur choisit un service, décrit sa demande, laisse email + téléphone.
 * -> enregistré dans la table `inscriptions` (base csc_db)
 * -> envoyé par email à l'adresse 'mail_to' de Data/config.php
 * ===================================================================== */
session_start();
require_once __DIR__ . '/Data/lang.php';
include 'Data/Dbo.php';   // charge aussi $CSC_CONFIG

$SERVICES = ['Marketing', 'Logistique', 'Comptabilité', 'Communication'];
// Nom affiché du service (la valeur envoyée reste en français)
$SERVICE_LABEL = ['Marketing' => L('Marketing', 'التسويق'), 'Logistique' => L('Logistique', 'اللوجستيك'), 'Comptabilité' => L('Comptabilité', 'المحاسبة'), 'Communication' => L('Communication', 'الاتصال')];

if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(16));

$errors = [];
$old = ['service' => '', 'nom' => '', 'email' => '', 'telephone' => '', 'description' => ''];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($old as $k => $v) $old[$k] = trim((string)($_POST[$k] ?? ''));

    // Anti-spam : champ caché rempli par les robots + jeton du formulaire
    $isBot = !empty($_POST['site_web']);
    if (!hash_equals($_SESSION['csrf'], (string)($_POST['csrf'] ?? ''))) {
        $errors['global'] = L('La session a expiré, merci de renvoyer le formulaire.', 'انتهت صلاحية الجلسة، يرجى إعادة إرسال الاستمارة.');
    }

    if (!in_array($old['service'], $SERVICES, true))            $errors['service'] = L('Choisissez un service.', 'اختر خدمة.');
    if (mb_strlen($old['nom']) < 3)                               $errors['nom'] = L('Indiquez votre nom complet.', 'أدخل اسمك الكامل.');
    if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL))       $errors['email'] = L('Adresse email invalide.', 'البريد الإلكتروني غير صحيح.');
    $tel = preg_replace('/[\s.\-]/', '', $old['telephone']);
    if (!preg_match('/^(\+213|00213|0)[5-7]\d{8}$|^\+?\d{8,15}$/', $tel)) $errors['telephone'] = L('Numéro de téléphone invalide (ex : 0555 12 34 56).', 'رقم الهاتف غير صحيح (مثال: 0555 12 34 56).');
    if (mb_strlen($old['description']) < 10)                      $errors['description'] = L('Décrivez votre demande (10 caractères minimum).', 'صف طلبك (10 أحرف على الأقل).');
    if (mb_strlen($old['description']) > 3000)                    $errors['description'] = L('Description trop longue (3000 caractères maximum).', 'الوصف طويل جدا (3000 حرف كحد أقصى).');

    if (!$errors && $isBot) { $success = true; }   // on fait semblant pour le robot
    elseif (!$errors) {
        // 1) Envoi de l'email à l'équipe CSC
        $to   = $CSC_CONFIG['mail_to']   ?? 'contact@csconstantine.dz';
        $from = $CSC_CONFIG['mail_from'] ?? 'no-reply@csconstantine.dz';
        $subject = '=?UTF-8?B?' . base64_encode('Nouvelle inscription - ' . $old['service']) . '?=';
        $e = fn($s) => htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
        $body = '<div style="font-family:Arial,sans-serif;max-width:600px;margin:auto;border:1px solid #e3e3e3;border-radius:8px;overflow:hidden">'
              . '<div style="background:#0a4f0a;color:#fff;padding:16px 20px;font-size:18px;font-weight:bold">Nouvelle inscription - site CSC</div>'
              . '<table style="width:100%;border-collapse:collapse;font-size:14px">'
              . '<tr><td style="padding:10px 20px;color:#666;width:140px">Service</td><td style="padding:10px 20px;font-weight:bold">' . $e($old['service']) . '</td></tr>'
              . '<tr style="background:#f7f7f7"><td style="padding:10px 20px;color:#666">Nom</td><td style="padding:10px 20px">' . $e($old['nom']) . '</td></tr>'
              . '<tr><td style="padding:10px 20px;color:#666">Email</td><td style="padding:10px 20px"><a href="mailto:' . $e($old['email']) . '">' . $e($old['email']) . '</a></td></tr>'
              . '<tr style="background:#f7f7f7"><td style="padding:10px 20px;color:#666">Téléphone</td><td style="padding:10px 20px"><a href="tel:' . $e($tel) . '">' . $e($old['telephone']) . '</a></td></tr>'
              . '<tr><td style="padding:10px 20px;color:#666;vertical-align:top">Demande</td><td style="padding:10px 20px;white-space:pre-wrap">' . $e($old['description']) . '</td></tr>'
              . '</table><div style="padding:12px 20px;font-size:12px;color:#999">Reçu le ' . date('d/m/Y à H:i') . ' - répondez directement à cet email pour contacter la personne.</div></div>';
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "From: CSC Site <{$from}>\r\n";
        $headers .= "Reply-To: {$old['email']}\r\n";
        $mailOk = @mail($to, $subject, $body, $headers, '-f' . $from);

        // 2) Sauvegarde en base (copie de sécurité + futur espace admin)
        $dbOk = false;
        $pdo = getConnectionPDO();
        if ($pdo) {
            try {
                $st = $pdo->prepare("INSERT INTO inscriptions (service, nom, email, telephone, description, email_envoye, ip) VALUES (?,?,?,?,?,?,?)");
                $dbOk = $st->execute([$old['service'], $old['nom'], $old['email'], $old['telephone'], $old['description'], $mailOk ? 1 : 0, $_SERVER['REMOTE_ADDR'] ?? null]);
            } catch (Throwable $ex) { error_log('[CSC] Inscription non enregistrée : ' . $ex->getMessage()); }
            close();
        }

        if ($mailOk || $dbOk) {
            $success = true;
            $_SESSION['csrf'] = bin2hex(random_bytes(16));
            $old = array_map(fn() => '', $old);
        } else {
            $errors['global'] = L('Votre demande n\'a pas pu être envoyée. Merci de réessayer plus tard ou d\'écrire à ', 'تعذر إرسال طلبك. يرجى المحاولة لاحقا أو الكتابة إلى ') . $to;
        }
    }
}
$err = fn($k) => isset($errors[$k]) ? '<div class="ins-error">' . htmlspecialchars($errors[$k]) . '</div>' : '';
?>
<!doctype html>
<html lang="<?= $LANG ?>" dir="<?= $DIR ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="images/fav.png" type="image/png">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/color.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome.css">
    <title><?= L('Inscription - CS Constantine', 'التسجيل - النادي الرياضي القسنطيني') ?></title>
    <style>
        .ins-wrap{max-width:820px;margin:0 auto;}
        .ins-intro{text-align:center;margin-bottom:35px;}
        .ins-intro h2{font-weight:800;color:#0a4f0a;margin-bottom:8px;}
        .ins-intro p{color:#555;margin:0;}
        .ins-card{background:#fff;border-radius:16px;box-shadow:0 10px 35px rgba(0,0,0,.08);padding:40px;border-top:5px solid #0a4f0a;}
        .ins-step{display:flex;align-items:center;gap:10px;font-weight:800;color:#111;margin:0 0 14px;font-size:17px;}
        .ins-step b{background:#0a4f0a;color:#fff;width:28px;height:28px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:14px;}
        .ins-services{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:30px;}
        .ins-services input{position:absolute;opacity:0;pointer-events:none;}
        .ins-services label{display:flex;flex-direction:column;align-items:center;gap:8px;border:2px solid #e2e8e2;border-radius:12px;padding:18px 8px;cursor:pointer;text-align:center;font-weight:700;color:#333;transition:.2s;margin:0;}
        .ins-services label i{font-size:24px;color:#1a7a1a;}
        .ins-services label:hover{border-color:#1a7a1a;}
        .ins-services input:checked + label{border-color:#0a4f0a;background:#0a4f0a;color:#fff;box-shadow:0 6px 16px rgba(10,79,10,.3);}
        .ins-services input:checked + label i{color:#fff;}
        .ins-services input:focus-visible + label{outline:3px solid #7fdc8f;}
        .ins-field{margin-bottom:20px;}
        .ins-field label{font-weight:700;color:#222;margin-bottom:6px;display:block;}
        .ins-field label span{color:#c0392b;}
        .ins-field input,.ins-field textarea{width:100%;border:2px solid #e2e8e2;border-radius:10px;padding:12px 14px;font-size:15px;transition:.2s;background:#fafcfa;}
        .ins-field input:focus,.ins-field textarea:focus{outline:none;border-color:#1a7a1a;background:#fff;}
        .ins-field textarea{min-height:150px;resize:vertical;}
        .ins-row{display:grid;grid-template-columns:1fr 1fr;gap:20px;}
        .ins-error{color:#c0392b;font-size:13px;margin-top:5px;font-weight:600;}
        .ins-alert{border-radius:10px;padding:14px 18px;margin-bottom:25px;font-weight:600;}
        .ins-alert.err{background:#fdecea;color:#a12a1f;}
        .ins-success{text-align:center;padding:30px 10px;}
        .ins-success i{font-size:60px;color:#1a7a1a;margin-bottom:15px;}
        .ins-success h3{font-weight:800;color:#0a4f0a;}
        .ins-submit{background:linear-gradient(135deg,#0a4f0a,#1a7a1a);color:#fff;border:0;border-radius:30px;padding:14px 40px;font-weight:800;font-size:16px;cursor:pointer;box-shadow:0 6px 16px rgba(10,79,10,.3);transition:.2s;}
        .ins-submit:hover{transform:translateY(-2px);}
        .ins-hp{position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0 0 0 0);opacity:0;}
        .ins-count{font-size:12px;color:#888;text-align:right;margin-top:4px;}
        @media(max-width:768px){.ins-services{grid-template-columns:repeat(2,1fr);}.ins-row{grid-template-columns:1fr;gap:0;}.ins-card{padding:25px 18px;}}
    </style>
</head>
<body>
<div class="wrapper">
    <?php require 'header.php'; ?>

    <div class="inner-banner-header wf100">
        <h1 data-generated="<?= L('Inscription', 'التسجيل') ?>"><?= L('Inscription', 'التسجيل') ?></h1>
        <div class="gt-breadcrumbs">
            <ul>
                <li><a href="index.php" class="active"><i class="fas fa-home"></i> <?= L('Accueil', 'الرئيسية') ?></a></li>
                <li><a href="#"><?= L('Inscription', 'التسجيل') ?></a></li>
            </ul>
        </div>
    </div>

    <div class="main-content innerpagebg wf100">
        <div class="wf100 p80">
            <div class="container">
                <div class="ins-wrap">
                    <div class="ins-intro">
                        <h2><?= L('Rejoignez l\'aventure du CSC', 'انضم إلى مغامرة النادي الرياضي القسنطيني') ?></h2>
                        <p><?= L('Choisissez le service qui vous intéresse, décrivez votre demande : l\'équipe du club vous recontactera.', 'اختر الخدمة التي تهمك وصف طلبك، وسيتواصل معك فريق النادي.') ?></p>
                    </div>

                    <div class="ins-card">
                    <?php if ($success): ?>
                        <div class="ins-success">
                            <i class="fas fa-check-circle"></i>
                            <h3><?= L('Merci, votre inscription a bien été envoyée !', 'شكرا، تم إرسال تسجيلك بنجاح!') ?></h3>
                            <p><?= L('L\'équipe du CS Constantine étudiera votre demande et vous recontactera par email ou par téléphone.', 'سيدرس فريق النادي الرياضي القسنطيني طلبك ويتواصل معك عبر البريد الإلكتروني أو الهاتف.') ?></p>
                            <a href="index.php" class="ins-submit" style="display:inline-block;margin-top:15px;text-decoration:none;"><?= L('Retour à l\'accueil', 'العودة إلى الرئيسية') ?></a>
                        </div>
                    <?php else: ?>
                        <?php if (!empty($errors['global'])): ?><div class="ins-alert err"><?= htmlspecialchars($errors['global']) ?></div><?php endif; ?>
                        <form method="post" action="inscription.php" novalidate>
                            <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                            <div class="ins-hp" aria-hidden="true"><input type="text" name="site_web" tabindex="-1" autocomplete="off"></div>

                            <p class="ins-step"><b>1</b> <?= L('Choisissez le service', 'اختر الخدمة') ?></p>
                            <?php $icons = ['Marketing' => 'fa-chart-line', 'Logistique' => 'fa-truck', 'Comptabilité' => 'fa-calculator', 'Communication' => 'fa-comments']; ?>
                            <div class="ins-services">
                                <?php foreach ($SERVICES as $i => $s): ?>
                                    <input type="radio" name="service" id="srv<?= $i ?>" value="<?= $s ?>" <?= $old['service'] === $s ? 'checked' : '' ?> required>
                                    <label for="srv<?= $i ?>"><i class="fas <?= $icons[$s] ?>"></i><?= $SERVICE_LABEL[$s] ?></label>
                                <?php endforeach; ?>
                            </div>
                            <?= $err('service') ?>

                            <p class="ins-step"><b>2</b> <?= L('Votre demande', 'طلبك') ?></p>
                            <div class="ins-field">
                                <label for="description"><?= L('Description', 'الوصف') ?> <span>*</span></label>
                                <textarea id="description" name="description" maxlength="3000" placeholder="<?= L('Présentez-vous et expliquez ce que vous souhaitez faire / proposer...', 'عرّف بنفسك واشرح ما تريد القيام به أو اقتراحه...') ?>" required><?= htmlspecialchars($old['description']) ?></textarea>
                                <div class="ins-count"><span id="descCount">0</span> / 3000</div>
                                <?= $err('description') ?>
                            </div>

                            <p class="ins-step"><b>3</b> <?= L('Vos coordonnées', 'معلومات الاتصال') ?></p>
                            <div class="ins-field">
                                <label for="nom"><?= L('Nom complet', 'الاسم الكامل') ?> <span>*</span></label>
                                <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($old['nom']) ?>" placeholder="<?= L('Nom et prénom', 'الاسم واللقب') ?>" required>
                                <?= $err('nom') ?>
                            </div>
                            <div class="ins-row">
                                <div class="ins-field">
                                    <label for="email"><?= L('Email', 'البريد الإلكتروني') ?> <span>*</span></label>
                                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($old['email']) ?>" placeholder="exemple@gmail.com" required>
                                    <?= $err('email') ?>
                                </div>
                                <div class="ins-field">
                                    <label for="telephone"><?= L('Téléphone', 'الهاتف') ?> <span>*</span></label>
                                    <input type="tel" id="telephone" name="telephone" value="<?= htmlspecialchars($old['telephone']) ?>" placeholder="0555 12 34 56" required>
                                    <?= $err('telephone') ?>
                                </div>
                            </div>

                            <div style="text-align:center;margin-top:10px;">
                                <button type="submit" class="ins-submit"><i class="fas fa-paper-plane"></i> <?= L('Envoyer mon inscription', 'إرسال التسجيل') ?></button>
                            </div>
                        </form>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require 'footer.php'; ?>
</div>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/mobile-nav.js"></script>
<script>
(function(){
    var t = document.getElementById('description'), c = document.getElementById('descCount');
    if (t && c) { var u = function(){ c.textContent = t.value.length; }; t.addEventListener('input', u); u(); }
})();
</script>
</body>
</html>
